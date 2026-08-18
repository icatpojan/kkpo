const createConnection = require('./getConnection');
const axios = require('axios');
const fs = require('fs');

let lastHour = null;
let counter = 0;
let lastVarMOID = 1215678; // Inisialisasi dengan nilai default
let isRunning = false; // Flag untuk mencegah overlap eksekusi

// Fungsi untuk membaca lastVarMOID dari file
function loadLastVarMOID() {
    try {
        const data = fs.readFileSync('last_varmoid.txt', 'utf8');
        lastVarMOID = parseInt(data, 10);
        console.log('Loaded lastVarMOID:', lastVarMOID);
    } catch (error) {
        console.error('Error loading lastVarMOID, using default:', error);
    }
}

// Fungsi untuk menyimpan lastVarMOID ke file
function saveLastVarMOID() {
    try {
        fs.writeFileSync('last_varmoid.txt', lastVarMOID.toString());
        console.log('Saved lastVarMOID:', lastVarMOID);
    } catch (error) {
        console.error('Error saving lastVarMOID:', error);
    }
}

// Panggil fungsi untuk memuat lastVarMOID saat aplikasi mulai
loadLastVarMOID();

function getTransactionId(oTanggal) {
    const sTanggal = oTanggal.toISOString().slice(0, 13).replace(/[-T]/g, '');
    const currentHour = sTanggal;
    if (lastHour !== currentHour) {
        counter = 0;
        lastHour = currentHour;
    }
    const formattedCounter = counter.toString().padStart(4, '0');
    counter++;
    return sTanggal + formattedCounter;
}

async function runQuery() {
    if (isRunning) {
        console.log('Menunggu proses sebelumnya selesai. Eksekusi dibatalkan.');
        return;
    }
    isRunning = true;
    try {
        const connection = await createConnection(); // Mendapatkan koneksi dengan retry
        console.time('QueryTime'); // Mulai menghitung waktu

        const query = `
            SELECT
            ltob.id as lastVarMOID,
            ai_mobile.id,
                ltob.sn,
                ltob.timestamp,
                ltob.latitude,
                ltob.longitude,
                ltob.heading,
                ltob.speed
            FROM
            kapal_pintar_db.ai_mobile as ai_mobile
            INNER JOIN
            kapal_pintar_db.log_tracking_ocean_byte as ltob
            ON
            ai_mobile.sn = ltob.sn
            WHERE
            ai_mobile.category_status_id = 6
            AND ltob.latitude IS NOT NULL
            AND ltob.longitude IS NOT NULL
         AND ltob.id > ?
            ORDER BY ltob.id ASC;
        `;

        connection.query(query, [lastVarMOID], async (error, results) => {
            if (error) {
                console.error('Query error:', error);
                isRunning = false; // Reset flag jika query error
                return;
            }

            // console.log('Query results:', results);

            // Proses dalam batch (paralel) untuk mempercepat pengiriman
            const BATCH_SIZE = 50; // Anda bisa mengubah angka ini sesuai kemampuan server KKP
            for (let i = 0; i < results.length; i += BATCH_SIZE) {
                const batch = results.slice(i, i + BATCH_SIZE);
                console.log(`Memproses batch ${Math.floor(i / BATCH_SIZE) + 1} (${batch.length} data)...`);
                
                const promises = batch.map(async (element) => {
                    const nLatitude = parseFloat(element.latitude);
                    const nLongitude = parseFloat(element.longitude);
                    const kkpId = element.id;
                    const sn = element.sn;
                    const nSpeed = element.speed ? parseFloat(element.speed) * 10 : 0;
                    const sHeading = element.heading || '0';
                    
                    let oTanggal = new Date(element.timestamp);
                    oTanggal.setHours(oTanggal.getHours());
                    const updatedTimestamp = oTanggal.toISOString();
                    oTanggal = new Date(updatedTimestamp);
                    const sWaktu = oTanggal.toISOString().slice(11, 16).replace(':', '');
                    const sTanggal = oTanggal.toISOString().slice(0, 11).replace(/[-T]/g, '');
                    const sTransId = getTransactionId(oTanggal);
                    let body = `//SR//AD/KKP//FR/PINTAR//TM/POS//TR/${sTransId}//IR/${kkpId}//NA/${sn}//LT/${nLatitude}//LG/${nLongitude}//SP/${nSpeed}//CO/${sHeading}//DA/${sTanggal}//TI/${sWaktu}//FS/IDN//NS/9//BH/168//GF/0//VE/12//PW/0//EM/0//AT/0//ER\n`;

                    const soapData = `
                                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vms="http://j2ee.netbeans.org/wsdl/VmsDataProvider/src/VmsDataProvider">
                                   <soapenv:Header/>
                                   <soapenv:Body>
                                      <vms:VmsDataProviderOperation>
                                         <rawData>${body}</rawData>
                                      </vms:VmsDataProviderOperation>
                                   </soapenv:Body>
                                </soapenv:Envelope>
                                `;
                    try {
                        const response = await axios.post('https://devspkp.kkp.go.id:8066/VmsDataProviderService/VmsDataProviderPort', soapData, {
                            headers: {
                                'Content-Type': 'text/xml',
                                'SOAPAction': 'http://j2ee.netbeans.org/wsdl/VmsDataProvider/src/VmsDataProvider/VmsDataProviderOperation'
                            },
                            timeout: 30000 // Timeout 30 detik
                        });

                        const result = response.data;
                        fs.appendFileSync(`result-${sTanggal}.txt`, ` data:${body}\n hasil:${result}\n ---\n`);
                        // Agar log tidak terlalu penuh, kita cetak sTransId saja alih-alih seluruh body
                        console.log(`Data sent: TR/${sTransId}, Response: OK`);
                    } catch (error) {
                        fs.appendFileSync(`id-error-${sTanggal}.txt`, `${element.timestamp.toString()}\n`);
                        fs.appendFileSync(`log-error-${sTanggal}.txt`, `${error}\n `);
                        console.error(`Error sending data TR/${sTransId}: ${error.message}`);
                    }
                });
                
                // Tunggu semua request dalam batch ini selesai sebelum lanjut ke batch berikutnya
                await Promise.all(promises);
            }
            if (results.length > 0) {
                lastVarMOID = results[results.length - 1].lastVarMOID;

                console.log('Data terakhir ' + lastVarMOID);
                console.log('Waktu terakhir ' + results[results.length - 1].timestamp);
                saveLastVarMOID(); // Simpan lastVarMOID ke file
            }

            console.timeEnd('QueryTime'); // Akhiri penghitungan waktu dan cetak hasilnya
            connection.end(err => {
                if (err) {
                    console.error('error ending the pool: ' + err.stack);
                } else {
                    console.log('Pool connections closed');
                }
                isRunning = false; // Reset flag setelah proses selesai
            }); // Tutup koneksi
        });

    } catch (error) {
        console.error('Connection error:', error); // Tangani kesalahan koneksi
        isRunning = false; // Reset flag jika gagal membuat koneksi
    }
}
runQuery();

setInterval(runQuery, 5 * 60 * 1000);
