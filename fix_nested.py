import re

def fix_nested_ans(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find <td ... class="ans"...> ... </td>
    # and remove any <span class="ans"...> and </span> inside it.
    
    def remove_spans(match):
        outer = match.group(0)
        # remove <span class="ans"...>
        outer = re.sub(r'<span class="ans"[^>]*>', '', outer)
        # remove </span>
        outer = outer.replace('</span>', '')
        return outer
        
    content = re.sub(r'<td[^>]*ans[^>]*>.*?</td>', remove_spans, content, flags=re.DOTALL)
    
    # Also fix Nama Ahli Waris missing ans
    content = content.replace('<td class="w-70">&nbsp;</td>', '<td class="w-70 ans">&nbsp;</td>')

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

fix_nested_ans('resources/views/data_cedera/pdf_tahap2.blade.php')
fix_nested_ans('resources/views/data_cedera/pdf_tahap1.blade.php')
print("Fixed nested ans")
