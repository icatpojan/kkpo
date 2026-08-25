import re
import json

mapping = {
    'PCC': ('PCC', 'Surya Kencana, Pamulang Barat, Kecamatan Pamulang, Kota Tangerang Selatan, Banten', 'https://maps.app.goo.gl/qpTZZrchfQhA8wPA'),
    'Pondok Cabe Golf': ('PONDOK CABE GOLF', 'Jalan Pondok Cabe Golf (atau Jalan Cabe Raya), Pondok Cabe Udik/Ilir, Kecamatan Pamulang, Kota Tangerang Selatan, Banten', 'https://maps.app.goo.gl/pUKkicTbW1dpg2A9R8'),
    'Griya Hijau Alam Sutera': ('Griya Hijau Alam Sutera', 'Jl. Griya Hijau Raya, Pakualam, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15320', 'https://maps.app.goo.gl/7SxXxTRKqX1i19DT8'),
    'Kampus Kademangan': ('KAMPUS KADEMANGAN', '', ''),
    'Ekowisata Kranggan': ('Ekowisata Kranggan', 'Jl. Lkr. Selatan, Kranggan, Kec. Setu, Kota Tangerang Selatan, Banten 15312', 'https://maps.app.goo.gl/uiE8ZVqs1HdfqgGx79'),
    'ISCI': ('ISCI International Sports Club of Indonesia', 'MQR5+7QV, Jl. Ciputat Raya No.2, Cireundeu, Kec. Ciputat Tim., Kota Tangerang Selatan, Banten 15419', 'https://maps.app.goo.gl/qQ3EMptE2tKRrHTLA'),
    'Lap. Kera Sakti': ('LAP bola KERA SAKTI', 'JMVH+X5X, Setu, Kec. Setu, Kota Tangerang Selatan, Banten 15314', 'https://maps.app.goo.gl/p7nrscJXdThXzkKJCJ6'),
    'Lap. Kera Sakti (Perempuan)': ('LAP bola KERA SAKTI', 'JMVH+X5X, Setu, Kec. Setu, Kota Tangerang Selatan, Banten 15314', 'https://maps.app.goo.gl/p7nrscJXdThXzkKJCJ6'),
    'Dwantara': ('Dewantara Sport Center', 'Victor, Jl. Buaran raya No.62, RT.02/RW.01, Buaran, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/RErVTQTrN1e8Ndj97'),
    'Kec. Pondok Aren': ('KEC PONDOK AREN', 'Jl. Graha Raya Bintaro No.1, Parigi Baru, Tangerang, Kota Tangerang Selatan, Banten 15228', 'https://maps.app.goo.gl/xAtFfqcbW3L85YbB6'),
    'Candra Wijaya': ('CANDRA WIJAYA badminton center', 'Jl. Jelupang Raya No.15, Jelupang, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15323', 'https://maps.app.goo.gl/pM2LEMEGYdJohFw9'),
    'Lap. KONI': ('LAP KONI', 'Jl. Bintaro Utama Sektor 3A, Pd. Karya, Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15225', 'https://maps.app.goo.gl/cniL29LoeK3Euxs8'),
    'J Flower': ('JFlowers Billiard BSD City', 'Lengkong Wetan, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/BcsuE3UU3Jwd2ig7'),
    'Sawarna': ('SAWARNA', '', ''),
    'Road Race Dirlantas': ('DIRLANTAS', '', ''),
    'Case Track Serpong Paradise': ('SERPONG PARADISE', '', ''),
    'RDM': ('RDM', 'Perumahan Serua Makmur Blok 28 No. 7, Serua, Ciputat, Tangerang Selatan, Banten', ''),
    'Lap. Rempas': ('Lap. Rempas', 'Jl. Kp. No.25, Babakan, Kec. Setu, Kota Tangerang Selatan, Banten 15315', 'https://maps.app.goo.gl/qkbandAMq8RzGgHw5'),
    'Aula Kec. Pondok Aren': ('AULA KEC PONDOK AREN', '', ''),
    'Situ Pondok Jagung': ('SITU PONDOK JAGUNG', 'Jl. Rawa Putus, Pd. Jagung Tim., Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15326', 'https://maps.app.goo.gl/U9cqTNgatvCqrA3'),
    'Bexchange Mall': ('BEXCANGE MALL', 'Bintaro Jaya Sektor 7, Jl. Lkr. Jaya, Pd. Jaya, Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15220', 'https://maps.app.goo.gl/AGtXccTuxA7xJU6'),
    'UIN': ('UIN', '', ''),
    'UMJ': ('UMJ', '', ''),
    'ITC BSD': ('ITC BSD', 'Jl. Pahlawan Seribu No.12, Lengkong Wetan, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/uCNGWU2zeTr5pLuH7'),
    'MS Arena': ('MS Sports Arena', 'Gading Ocean Walk, Jl. Pahlawan Seribu Blok CBD LOT No.VI A, Lengkong Gudang, Kec. Serpong, Kota Tangerang Selatan, Banten 15320', 'https://maps.app.goo.gl/dbzLPK911n2vGLjC6'),
    'WTC Mall Arhanud': ('WTC MALL ARHANUD', 'Jl. Raya Serpong Kilometer 7, Pd. Jagung, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15326', 'https://maps.app.goo.gl/UoTzNeFyY9n1vLnd6'),
    'Ciater Permai': ('CIATER PERMAI', '', ''),
    'Gedung UMKM': ('GEDUNG UMKM', 'Jl. Sunburst CBD, Lengkong Gudang, Kec. Serpong, Kota Tangerang Selatan, Banten 15321', 'https://maps.app.goo.gl/qZQQdRsa2ofAaXk9'),
    'British School': ('BRITISH SCHOOL', 'Jl. Jombang Raya No.9, Pd. Pucung, Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15227', 'https://maps.app.goo.gl/qZFRtt12o2wkYm1HLA'),
    'MD Sport': ('MD SPORT BULUTANGKIS DAN FUTSAL', 'MP8Q+7MP, Jl. Sinar Pamulang Permai, Pamulang Bar., Kec. Pamulang, Kota Tangerang Selatan, Banten 15417', 'https://maps.app.goo.gl/rnRbSu1LQB2tmw1R6'),
    'Plaza Pemkot': ('PLAZA PEMKOT', 'Jl. Adi Sengkong Blok A No.8, Serua, Kec. Ciputat, Kota Tangerang Selatan, Banten 15414', 'https://maps.app.goo.gl/uYFGrGaqH6Fhww6'),
    'Blandongan': ('BLANDONGAN', '', ''),
    'WTC': ('WTC', '', ''),
    'Loka Padel': ('LOKAL PADEL', 'Loka Padel, Jl. Tandon Ciater, Ciater, Serpong Sub-District, South Tangerang City, Banten 15310', 'https://maps.app.goo.gl/Jq1VzTDVDg84N87'),
    'Lokal Padel': ('LOKAL PADEL', 'Loka Padel, Jl. Tandon Ciater, Ciater, Serpong Sub-District, South Tangerang City, Banten 15310', 'https://maps.app.goo.gl/Jq1VzTDVDg84N87'),
    'GOR Ciputat': ('GOR CIPUTAT', 'Jl. Pemuda No.2, Ciputat, Kec. Ciputat, Kota Tangerang Selatan, Banten 15411', 'https://maps.app.goo.gl/hPbtkk8YU5EXZrX8'),
    'GIS': ('GIS', 'Jl. Raya Puspitek No.10, Buaran, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/teJ7T8BGETdz3Rq8'),
    'Damai Indah Golf BSD': ('DAMAI INDAH GOLF BSD', 'Jl. Bukit Golf I BSD Sektor VI, Lengkong Karya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/eHfVp2hDcV5Puzh45'),
    'Kodiklat TNI': ('KODIKLAT TNI', 'Jl. Kediklat Tni Ampera, Buaran, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/umnxVKqTDKaHKYSA'),
    'GOR BRIN': ('GOR BRIN', 'Blok M 15314, Jl. Garuda 4 Blok A-5 No.10, Bakti Jaya, Setu, South Tangerang City, Banten 15315', 'https://maps.app.goo.gl/qdajTiZuMTAGBFqp8'),
    'Teras Kota': ('TERAS KOTA', 'CBD Lot JI. Pahlawan Seribu No.VII B, Lengkong Gudang, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/yQurDtEkwUth729'),
    'Mini VW Teras Kota': ('TERAS KOTA', 'CBD Lot JI. Pahlawan Seribu No.VII B, Lengkong Gudang, Kec. Serpong, Kota Tangerang Selatan, Banten 15310', 'https://maps.app.goo.gl/yQurDtEkwUth729'),
}

file_path = r'c:\Users\irsya\codingan\kkpo\database\seeds\JadwalPertandinganSeeder.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace venues in $jadwals array
for old_v, (new_v, addr, gmap) in mapping.items():
    # Only replace exact strings inside 'venue' => '...'
    # E.g. 'venue' => 'PCC' -> 'venue' => 'PCC'
    # Use regex for precise match
    pattern = r"'venue' => '" + re.escape(old_v) + r"'"
    content = re.sub(pattern, f"'venue' => '{new_v}'", content)

# Generate venue map PHP array
venue_map_php = "$venue_mapping = [\n"
unique_venues = {}
for old_v, (new_v, addr, gmap) in mapping.items():
    unique_venues[new_v] = (addr, gmap)

for v_name, (addr, gmap) in unique_venues.items():
    addr_escaped = addr.replace("'", "\\'")
    gmap_escaped = gmap.replace("'", "\\'")
    venue_map_php += f"            '{v_name}' => ['alamat' => '{addr_escaped}', 'gmap' => '{gmap_escaped}'],\n"
venue_map_php += "        ];"

# Replace the data preparation logic
old_logic = """        $data = [];
        foreach ($jadwals as $j) {
            $venueName = $j['venue'];
            $alamat = $venueName === '-' ? '' : 'Kawasan ' . $venueName . ', Tangerang Selatan';
            $gmap = $venueName === '-' ? '' : 'https://maps.google.com/?q=' . urlencode($venueName . ' Tangerang Selatan');"""

new_logic = f"""        {venue_map_php}
        
        $data = [];
        foreach ($jadwals as $j) {{
            $venueName = $j['venue'];
            $alamat = '';
            $gmap = '';
            if (isset($venue_mapping[$venueName])) {{
                $alamat = $venue_mapping[$venueName]['alamat'];
                $gmap = $venue_mapping[$venueName]['gmap'];
            }}"""

content = content.replace(old_logic, new_logic)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Done updating JadwalPertandinganSeeder.php")
