import re

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Add .ans class to CSS
    if '.ans {' not in content:
        content = content.replace('</style>', '    .ans { border-bottom: 1px dotted #000; }\n    </style>')

    # 2. Change BPJS logo
    logo_str = '<img src=\"{{ public_path(\'img/logo-bpjs.png\') }}\" style=\"max-height: 45px;\">'
    content = re.sub(r'<td[^>]*>\s*BPJS<br>Ketenagakerjaan\s*</td>', f'<td style="width: 25%;">{logo_str}</td>', content)

    # 3. Add ans class to answer cells. An answer cell is the td right after <td>:</td>
    # The pattern looks for <td>:</td> followed by \s* <td>...</td>
    # and replaces it with <td>:</td> \n <td class="ans">...</td>
    def replace_td(match):
        inner_td = match.group(1)
        # If it already has class ans, skip
        if 'ans' in inner_td:
            return match.group(0)
        
        # Replace - with &nbsp;
        if inner_td.strip() == '-' or inner_td.strip() == '':
            inner_td = '&nbsp;'
            
        # If it has classes already, append ans. If not, add class="ans"
        if 'class=' in inner_td:
            inner_td = re.sub(r'class="([^"]*)"', r'class="\1 ans"', inner_td, count=1)
        else:
            inner_td = f'class="ans"{inner_td}'
            
        return f'<td>:</td>\n                    <td {inner_td}'

    content = re.sub(r'<td>:</td>\n\s*<td([^>]*)>', replace_td, content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

process_file('resources/views/data_cedera/pdf_tahap1.blade.php')
process_file('resources/views/data_cedera/pdf_tahap2.blade.php')
print("Done")
