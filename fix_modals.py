import os

filepath = 'resources/views/nakes_jaga/index.blade.php'
with open(filepath, 'r') as f:
    lines = f.readlines()

# The modals are from line 78 to 295 (0-indexed 77 to 295).
# Wait, let's just find the indices dynamically to be safe.
start_idx = -1
end_idx = -1
create_idx = -1

for i, line in enumerate(lines):
    if '<!-- Detail Modal -->' in line and start_idx == -1:
        start_idx = i
    if '@endforeach' in line and start_idx != -1 and end_idx == -1:
        end_idx = i
    if '<!-- Create Modal -->' in line:
        create_idx = i

if start_idx != -1 and end_idx != -1 and create_idx != -1:
    modals = lines[start_idx:end_idx]
    
    # Remove modals from their original location
    del lines[start_idx:end_idx]
    
    # Recalculate create_idx since lines were deleted
    create_idx = create_idx - (end_idx - start_idx)
    
    # Insert new loop before Create Modal
    new_block = ['@foreach($nakes as $person)\n'] + modals + ['@endforeach\n']
    
    lines = lines[:create_idx] + new_block + lines[create_idx:]
    
    with open(filepath, 'w') as f:
        f.writelines(lines)
    print("Fixed!")
else:
    print(f"Could not find markers. Start: {start_idx}, End: {end_idx}, Create: {create_idx}")
