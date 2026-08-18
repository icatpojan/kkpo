import re

def fix_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find <td class="ans" AND any text following it up to </td>
    # Let's fix the missing > bracket.
    # It currently looks like <td class="ans"&nbsp;-</td>
    # or <td class="w-70 ans"{{ ->kontingen ?: 'KONI TANGERANG SELATAN' }}</td>
    # So we need to insert a > right after the attributes.
    # The attributes will end with a quote " or ans"
    
    # regex to fix: <td([^>]*?ans[^>]*?)((?:&nbsp;|\{\{|[A-Z0-9\-])[^<]*)</td>
    # wait, it's easier to just do:
    # replace <td class="ans" with <td class="ans">
    # replace <td class="w-70 ans" with <td class="w-70 ans">
    
    content = re.sub(r'<td class="ans"([^>]*?)', r'<td class="ans">\1', content)
    content = re.sub(r'<td class="w-70 ans"([^>]*?)', r'<td class="w-70 ans">\1', content)
    
    # Wait, if there are things like <td class="ans"&nbsp;
    # It would replace it with <td class="ans">&nbsp;
    content = content.replace('<td class="ans"&nbsp;', '<td class="ans">&nbsp;')
    content = content.replace('<td class="w-70 ans"&nbsp;', '<td class="w-70 ans">&nbsp;')
    
    content = content.replace('<td class="ans"{{', '<td class="ans">{{')
    content = content.replace('<td class="w-70 ans"{{', '<td class="w-70 ans">{{')

    content = content.replace('<td class="ans"-', '<td class="ans">-')
    content = content.replace('<td class="w-70 ans"-', '<td class="w-70 ans">-')

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

fix_file('resources/views/data_cedera/pdf_tahap1.blade.php')
fix_file('resources/views/data_cedera/pdf_tahap2.blade.php')
print("Fixed")
