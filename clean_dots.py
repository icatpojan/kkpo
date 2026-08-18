import re

def clean_dots(filepath, is_kronologis=False):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Add .ans class if not exists
    if '.ans {' not in content:
        content = content.replace('</style>', '    .ans { border-bottom: 1px dotted #000; }\n    </style>')

    # 2. For Form 1 & 2: remove stacked dots in elements that have class="ans"
    # Actually, the stacked dots might just be literal dots like ....... inside a td.
    # We can use regex to replace literal dots of length >= 5 with &nbsp; inside any td that has class ans.
    # But wait, some literal dots are NOT in td with class ans! e.g., "sebutkan ............"
    # Let's just find any sequence of dots length >= 5 that are alone in a td, or inside text, and replace them.
    # Wait, replacing all dots with <span class="ans" style="display:inline-block; min-width:150px;">&nbsp;</span>
    # For form 1 and 2, "sebutkan ...................." is in the HTML like:
    # sebutkan .....................<br>
    
    # Let's replace \.\.\.\.\.\.+ with <span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span>
    # EXCEPT inside pdf_kronologis, where we just replace them with &nbsp; because we'll add border to data-col.
    
    if is_kronologis:
        # In kronologis, add border-bottom to data-col
        content = content.replace('.data-col {', '.data-col {\n            border-bottom: 1px dotted #000;')
        # Replace ....+ with &nbsp; if it's alone, or just &nbsp; inside data-col
        # e.g. <td class="data-col">.....................</td> -> <td class="data-col">&nbsp;</td>
        # What if it has Bayu Saputra? <td class="data-col">{{ ->nama }}</td> -> keep it.
        # What about {{ ->nik ?: '...........' }} ?
        content = re.sub(r"'\.\.\.\.\.\.+?'", "'&nbsp;'", content)
        content = re.sub(r">\.\.\.\.\.\.+?<", ">&nbsp;<", content)
        # Any other dots?
        content = re.sub(r"\.\.\.\.\.\.+", "&nbsp;", content)

    else:
        # Form 1 & 2
        # Remove literal dots inside {{ ... ?: '....' }}
        content = re.sub(r"'\.\.\.\.\.\.+?'", "''", content)
        
        # Remove literal dots that are standing alone inside a td
        content = re.sub(r">\s*\.\.\.\.\.\.+\s*<", ">&nbsp;<", content)
        
        # Replace inline dots like sebutkan ............. with a span
        content = re.sub(r"(\bsebutkan\s*|\bnegara\s*|\bKab\s*:\s*|\bTanggal\s*:\s*|\bNama\s*:\s*|\bJabatan\s*:\s*)\.\.\.\.\.\.+", 
                         r'\1<span class="ans" style="display:inline-block; min-width: 150px;">&nbsp;</span>', content)
                         
        content = re.sub(r"\(\.\.\.\.\.\.\.\.\.\.\.\.\.\.\)", r'(<span class="ans" style="display:inline-block; min-width: 40px;">&nbsp;</span>)', content)
        content = re.sub(r"\.\.\.\.\.\.+", r'<span class="ans" style="display:inline-block; min-width: 100px;">&nbsp;</span>', content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

clean_dots('resources/views/data_cedera/pdf_tahap1.blade.php')
clean_dots('resources/views/data_cedera/pdf_tahap2.blade.php')
clean_dots('resources/views/data_cedera/pdf_kronologis.blade.php', True)
print("Cleaned")
