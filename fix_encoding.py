import re
import codecs

# Read the generated seeder
file_path = "c:\\Users\\irsya\\codingan\\kkpo\\database\\seeds\\JadwalPertandinganSeeder.php"
try:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
except UnicodeDecodeError:
    with open(file_path, "r", encoding="latin1") as f:
        content = f.read()

# Replace any kind of em-dash or weird characters
content = content.replace("—", "-")
content = content.replace("\x97", "-")
content = content.replace("\u2014", "-")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)
