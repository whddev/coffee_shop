import re
with open('beragam-rasa.html', 'r', encoding='utf-8') as f:
    html = f.read()
with open('westjava_kabupaten_paths.txt', 'r', encoding='utf-8') as f:
    paths = f.read()

new_svg = f'<svg class="west-java-map" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">\n{paths}\n</svg>'
html = re.sub(r'<svg class="west-java-map"[^>]*>.*?</svg>', new_svg, html, flags=re.DOTALL)

with open('beragam-rasa.html', 'w', encoding='utf-8') as f:
    f.write(html)
