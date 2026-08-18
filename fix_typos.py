import re
with open('database/seeds/JadwalPertandinganSeeder.php', 'r') as f:
    content = f.read()

replacements = {
    "'cabor' => 'Sepak Bola Putra'": "'cabor' => 'Sepak Bola'",
    "'cabor' => 'Sepak Bola Putri'": "'cabor' => 'Sepak Bola'",
    "'cabor' => 'Biliard'": "'cabor' => 'Billiard'",
    "'cabor' => 'Arum Jeram'": "'cabor' => 'Arung Jeram'",
    "'cabor' => 'Gymnastic'": "'cabor' => 'Senam'",
    "'cabor' => 'Bermotor'": "'cabor' => 'Balap Motor'",
    "'cabor' => 'Panjat Tebing'": "'cabor' => 'Panjat Tebing'"
}

for old, new in replacements.items():
    content = content.replace(old, new)

with open('database/seeds/JadwalPertandinganSeeder.php', 'w') as f:
    f.write(content)
