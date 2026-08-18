import sys

# User's provided markdown data
data = """
## 13 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Cricket | Lap. Rempas | Nakes |
| 2 | Hoki | Dwantara | Nakes |
| 3 | Menembak | WTC Mall Arhanud | — |
| 4 | Sepak Bola Putri | Lap. Kera Sakti | Nakes |
| 5 | Sepak Bola Putra | Kodiklat TNI | Nakes |
| 6 | Pentathlon | Damai Indah Golf BSD | Nakes |

## 14 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Bermotor | Road Race Dirlantas | Nakes |
| 2 | Bermotor | Case Track Serpong Paradise | Nakes |
| 3 | Bermotor | Mini VW Teras Kota | Nakes |
| 4 | Cricket | Lap. Rempas | Nakes |
| 5 | Hoki | Dwantara | Nakes |
| 6 | Menembak | WTC Mall Arhanud | — |
| 7 | Panahan | ISCI | — |
| 8 | Pentathlon | Damai Indah Golf BSD | Nakes |
| 9 | Sepak Bola Putri | Lap. Kera Sakti | Nakes |
| 10 | Sepak Bola Putra | Kodiklat TNI | Nakes |
| 11 | Softball | Griya Hijau Alam Sutera | Nakes |

## 16 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Catur | Blandongan | — |
| 2 | Cricket | Lap. Rempas | Nakes |
| 3 | Hoki | Dwantara | Nakes |
| 4 | Menembak | WTC Mall Arhanud | — |
| 5 | Panahan | ISCI | — |
| 6 | Squash | ISCI | Nakes |
| 7 | Panjat Tebing | PCC | Nakes |
| 8 | Pentathlon | Damai Indah Golf BSD | Nakes |
| 9 | Sepak Bola Putri | Lap. Kera Sakti (Perempuan) | Nakes |
| 10 | Sepak Bola Putra | Kodiklat TNI | Nakes |
| 11 | Softball | Griya Hijau Alam Sutera | Nakes |

# 17 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Anggar | UMJ | Nakes |
| — | Drumband | Kodiklat TNI | Nakes |
| 2 | Atletik | Kodiklat TNI | Nakes |
| 3 | Barongsai | Plaza Pemkot | — |
| 4 | Biliard | J Flower | — |
| 5 | Bola Basket | MS Arena | Nakes |
| 6 | Bola Tangan | GIS | Nakes |
| 7 | Bola Voli | UIN | Nakes |
| 8 | Bowling | WTC | — |
| — | Catur | Blandongan | — |
| 9 | Bridge | Blandongan | — |
| 10 | Bulu Tangkis | Candra Wijaya | Nakes |
| 12 | Cricket | Lap. Rempas | Nakes |
| 13 | Dance Sport | Bexchange Mall | — |
| 14 | Dayung | Situ Pondok Jagung | Nakes |
| 16 | Esport | Gedung UMKM | — |
| 17 | Futsal | PCC | Nakes |
| 18 | Golf | Pondok Cabe Golf | Nakes |
| 19 | Gymnastic | British School | Nakes |
| 20 | Hoki | Dwantara | Nakes |
| 21 | Judo | Teras Kota | Nakes |
| 22 | Karate | Teras Kota | Nakes |
| — | Tinju | Teras Kota | Nakes |
| 23 | Kempo | Kodiklat TNI | Nakes |
| — | Sepak Bola Putra | Kodiklat TNI | Nakes |
| 24 | Kurash | GOR BRIN | Nakes |
| 25 | Menembak | WTC Mall Arhanud | — |
| 26 | Muaythai | WTC | Nakes |
| 27 | Panahan | ISCI | — |
| 28 | Panjat Tebing | PCC | Nakes |
| 29 | Pencak Silat | GOR BRIN | Nakes |
| 30 | Petanque | Kec. Pondok Aren | — |
| 31 | Pickleball | RDM | Nakes |
| 32 | Sambo | MD Sport | Nakes |
| 33 | Selam | Damai Indah Golf BSD | Nakes |
| 34 | Selancar | Sawarna | Nakes |
| 35 | Sepak Bola Putri | Lap. Kera Sakti | Nakes |
| — | Tenis Meja | Loka Padel | Nakes |
| 36 | Sepak Takraw | Loka Padel | Nakes |
| 37 | Sepatu Roda | Ciater Permai | Nakes |
| 38 | Softball | Griya Hijau Alam Sutera | Nakes |
| 39 | Squash | ISCI | Nakes |
| 40 | Tenis Lapangan | Lap. KONI | Nakes |
| 43 | Woodball | GOR BRIN | Nakes |
| 44 | Wushu | Plaza Pemkot | Nakes |

# 18 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Anggar | UMJ | — |
| 2 | Atletik | Kodiklat TNI | — |
| 3 | Kempo | Kodiklat TNI | — |
| 4 | Drumband | Kodiklat TNI | — |
| 5 | Barongsai | Plaza Pemkot | — |
| 6 | Biliard | J Flower | — |
| 7 | Bola Basket | MS Arena | — |
| 8 | Bola Tangan | GIS | — |
| 9 | Bola Voli | UIN | — |
| 10 | Bowling | WTC | — |
| 11 | Muaythai | WTC | — |
| 12 | Menembak | WTC Mall Arhanud | — |
| 13 | Bridge | Blandongan | — |
| 14 | Catur | Blandongan | — |
| 15 | Bulu Tangkis | Candra Wijaya | — |
| 16 | Cricket | Lap. Rempas | — |
| 17 | Dance Sport | Bexchange Mall | — |
| 18 | Dayung | Situ Pondok Jagung | — |
| 19 | Esport | Gedung UMKM | — |
| 20 | Futsal | PCC | — |
| 21 | Panjat Tebing | PCC | — |
| 22 | Golf | Pondok Cabe Golf | — |
| 23 | Gymnastic | British School | — |
| 24 | Hoki | Dwantara | — |
| 25 | Judo | Teras Kota | — |
| 26 | Karate | Teras Kota | — |
| 27 | Tinju | Teras Kota | — |
| 28 | Kurash | GOR BRIN | — |
| 29 | Woodball | GOR BRIN | — |
| 30 | Pencak Silat | GOR BRIN | — |
| 31 | Panahan | ISCI | — |
| 32 | Squash | ISCI | — |
| 33 | Petanque | Kec. Pondok Aren | — |
| 34 | Pickleball | RDM | — |
| 35 | Sambo | MD Sport | — |
| 36 | Selam | Damai Indah Golf BSD | — |
| 37 | Selancar | Sawarna | — |
| 38 | Sepak Bola | Lap. Kera Sakti | — |
| 39 | Sepak Takraw | Loka Padel | — |
| 40 | Tenis Meja | Loka Padel | — |
| 41 | Sepatu Roda | Ciater Permai | — |
| 42 | Softball | Griya Hijau Alam Sutera | — |
| 43 | Tenis Lapangan | Lap. KONI | — |
| 44 | Wushu | Plaza Pemkot | — |

# 19 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Anggar | UMJ | — |
| 2 | Angkat Berat | Aula Kec. Pondok Aren | — |
| 3 | Angkat Besi | ITC BSD | — |
| 4 | Arum Jeram | Ekowisata Kranggan | — |
| 5 | Atletik | Kodiklat TNI | — |
| 6 | Drumband | Kodiklat TNI | — |
| 7 | Kempo | Kodiklat TNI | — |
| 8 | Sepak Bola Putra | Kodiklat TNI | — |
| 9 | Barongsai | Plaza Pemkot | — |
| 10 | Biliard | J Flower | — |
| 11 | Bola Basket | MS Arena | — |
| 12 | Bola Tangan | GIS | — |
| 13 | Bola Voli | UIN | — |
| 14 | Bowling | WTC | — |
| 15 | Bridge | Blandongan | — |
| 16 | Catur | Blandongan | — |
| 17 | Bulu Tangkis | Candra Wijaya | — |
| 18 | Cricket | Lap. Rempas | — |
| 19 | Dayung | Situ Pondok Jagung | — |
| 20 | Esport | Gedung UMKM | — |
| 21 | Futsal | PCC | — |
| 22 | Rugby | PCC | — |
| 23 | Panjat Tebing | PCC | — |
| 24 | Golf | Pondok Cabe Golf | — |
| 25 | Gymnastic | British School | — |
| 26 | Hoki | Dwantara | — |
| 27 | Karate | Teras Kota | — |
| 28 | Tinju | Teras Kota | — |
| 29 | Muaythai | WTC | — |
| 30 | Panahan | ISCI | — |
| 31 | Pencak Silat | GOR BRIN | — |
| 32 | Petanque | Kec. Pondok Aren | — |
| 33 | Pickleball | RDM | — |
| 34 | Selancar | Sawarna | — |
| 35 | Sepak Bola Putri | Lap. Kera Sakti | — |
| 36 | Tenis Meja | Loka Padel | — |
| 37 | Sepak Takraw | Loka Padel | — |
| 38 | Sepatu Roda | Ciater Permai | — |
| 39 | Softball | Griya Hijau Alam Sutera | — |
| 40 | Squash | ISCI | — |
| 41 | Tenis Lapangan | Lap. KONI | — |
| 42 | Woodball | GOR BRIN | — |
| 43 | Wushu | Plaza Pemkot | — |

# 20 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Anggar | UMJ | — |
| 2 | Angkat Berat | Aula Kec. Pondok Aren | — |
| 3 | Angkat Besi | ITC BSD | — |
| 4 | Renang | Damai Indah Golf BSD | — |
| 5 | Arum Jeram | Ekowisata Kranggan | — |
| 6 | Barongsai | Plaza Pemkot | — |
| 7 | Wushu | Plaza Pemkot | — |
| 8 | Biliard | J Flower | — |
| 9 | Bola Basket | MS Arena | — |
| 10 | Bola Tangan | GIS | — |
| 11 | Bola Voli | UIN | — |
| 12 | Bowling | WTC | — |
| 13 | Bridge | Blandongan | — |
| 14 | Catur | Blandongan | — |
| 15 | Bulu Tangkis | Candra Wijaya | — |
| 16 | Cricket | Lap. Rempas | — |
| 17 | Dayung | Situ Pondok Jagung | — |
| 18 | Sepak Bola Putra | Kodiklat TNI | — |
| 19 | Drumband | Kodiklat TNI | — |
| 20 | Esport | Gedung UMKM | — |
| 21 | Floorball | GIS | — |
| 22 | Futsal | PCC | — |
| 23 | Rugby | PCC | — |
| 24 | Golf | Pondok Cabe Golf | — |
| 25 | Gulat | MD Sport | — |
| 26 | Gymnastic | British School | — |
| 27 | Hoki | Dwantara | — |
| 28 | MMA | GOR Ciputat | — |
| 29 | Panahan | ISCI | — |
| 30 | Squash | ISCI | — |
| 31 | Panjat Tebing | PCC | — |
| 32 | Pencak Silat | GOR BRIN | — |
| 33 | Tarung Derajat | GOR BRIN | — |
| 34 | Woodball | GOR BRIN | — |
| 35 | Petanque | Kec. Pondok Aren | — |
| 36 | Selancar | Sawarna | — |
| 37 | Sepak Bola | Lap. Kera Sakti | — |
| 38 | Tenis Meja | Loka Padel | — |
| 39 | Sepak Takraw | Loka Padel | — |
| 40 | Sepatu Roda | Ciater Permai | — |
| 41 | Softball | Griya Hijau Alam Sutera | — |
| 42 | Taekwondo | — | — |
| 43 | Tenis Lapangan | Lap. KONI | — |

# 21 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Angkat Besi | ITC BSD | — |
| 2 | Renang | Damai Indah Golf BSD | — |
| 3 | Arum Jeram | Ekowisata Kranggan | — |
| 4 | Barongsai | Plaza Pemkot | — |
| 5 | Bermotor | Road Race Dirlantas | — |
| 6 | Bermotor | Case Track Serpong Paradise | — |
| 7 | Bermotor | Mini VW Teras Kota | — |
| 8 | Biliard | J Flower | — |
| 9 | Bola Basket | MS Arena | — |
| 10 | Bola Tangan | GIS | — |
| 11 | Floorball | GIS | — |
| 12 | Bridge | Blandongan | — |
| 13 | Catur | Blandongan | — |
| 14 | Bulu Tangkis | Candra Wijaya | — |
| 15 | Cricket | Lap. Rempas | — |
| 16 | Dayung | Situ Pondok Jagung | — |
| 17 | Drumband | Kodiklat TNI | — |
| 18 | Sepak Bola Putra | Kodiklat TNI | — |
| 19 | Gateball | Kampus Kademangan | — |
| 20 | Golf | Pondok Cabe Golf | — |
| 21 | Gulat | MD Sport | — |
| 22 | Gymnastic | British School | — |
| 23 | Hoki | Dwantara | — |
| 24 | MMA | GOR Ciputat | — |
| 25 | Jujitsu | GOR Ciputat | — |
| 26 | Panahan | ISCI | — |
| 27 | Squash | ISCI | — |
| 28 | Rugby | PCC | — |
| 29 | Panjat Tebing | PCC | — |
| 30 | Futsal | PCC | — |
| 31 | Petanque | Kec. Pondok Aren | — |
| 32 | Sepak Bola Putri | Lap. Kera Sakti | — |
| 33 | Sepatu Roda | Ciater Permai | — |
| 34 | Softball | Griya Hijau Alam Sutera | — |
| 35 | Taekwondo | — | — |
| 36 | Tarung Derajat | GOR BRIN | — |
| 37 | Woodball | GOR BRIN | — |
| 38 | Pencak Silat | GOR BRIN | — |
| 39 | Tenis Lapangan | Lap. KONI | — |
| 40 | Tenis Meja | Lokal Padel | — |

# 22 November

| No | Cabang Olahraga | Venue | Team Nakes |
|---:|---|---|---|
| 1 | Renang | Damai Indah Golf BSD | — |
| 2 | Arum Jeram | Ekowisata Kranggan | — |
| 3 | Bermotor | Road Race Dirlantas | — |
| 4 | Bermotor | Case Track Serpong Paradise | — |
| 5 | Bermotor | Teras Kota | — |
| 6 | Bina Raga | Teras Kota | — |
| 7 | Bola Tangan | GIS | — |
| 8 | Bridge | Blandongan | — |
| 9 | Catur | Blandongan | — |
| 10 | Bulu Tangkis | Candra Wijaya | — |
| 11 | Cricket | Lap. Rempas | — |
| 12 | Dayung | Situ Pondok Jagung | — |
| 13 | Drumband | Kodiklat TNI | — |
| 14 | Floorball | GIS | — |
| 15 | Gateball | Kampus Kademangan | — |
| 16 | Gulat | MD Sport | — |
| 17 | Hoki | Dwantara | — |
| 18 | MMA | GOR Ciputat | — |
| 19 | Panahan | ISCI | — |
| 20 | Squash | ISCI | — |
| 21 | Panjat Tebing | PCC | — |
| 22 | Rugby | PCC | — |
| 23 | Futsal | PCC | — |
| 24 | Sepak Bola | Lap. Kera Sakti | — |
| 25 | Sepatu Roda | Ciater Permai | — |
| 26 | Softball | Griya Hijau Alam Sutera | — |
| 27 | Tarung Derajat | GOR BRIN | — |
| 28 | Woodball | GOR BRIN | — |
"""

import re

lines = data.strip().split('\n')
current_date = ""

php_array = "[\n"

for line in lines:
    date_match = re.search(r'#+\s+(\d+)\s+November', line)
    if date_match:
        current_date = f"2026-11-{date_match.group(1).zfill(2)}"
        continue
    
    if line.startswith('|') and 'Cabang Olahraga' not in line and '---' not in line:
        parts = [p.strip() for p in line.split('|')]
        if len(parts) >= 5:
            cabor = parts[2]
            venue = parts[3]
            nakes = parts[4]
            if cabor and cabor != '—':
                cabor = cabor.replace("'", "\\'")
                venue = venue.replace("'", "\\'")
                if nakes == '—':
                    nakes = ""
                else:
                    nakes = nakes.replace("'", "\\'")
                
                php_array += f"            ['tanggal' => '{current_date}', 'cabor' => '{cabor}', 'venue' => '{venue}', 'nakes' => '{nakes}'],\n"

php_array += "        ]"

with open('c:\\Users\\irsya\\codingan\\kkpo\\jadwal_temp.php', 'w') as f:
    f.write(php_array)
