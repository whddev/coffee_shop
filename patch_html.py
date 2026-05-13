import re

with open('beragam-rasa.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Load paths
with open('indonesia_paths.txt', 'r', encoding='utf-8') as f:
    indo_paths = f.read()

with open('westjava_paths.txt', 'r', encoding='utf-8') as f:
    west_paths = f.read()

indo_regex = re.compile(r'<svg class="indonesia-map"[^>]*>.*?</svg>', re.DOTALL)
west_regex = re.compile(r'<svg class="west-java-map"[^>]*>.*?</svg>', re.DOTALL)

indo_svg = f'<svg class="indonesia-map" viewBox="0 0 1000 400" xmlns="http://www.w3.org/2000/svg">\n{indo_paths}\n</svg>'
west_svg = f'<svg class="west-java-map" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">\n{west_paths}\n</svg>'

html = indo_regex.sub(indo_svg, html)
html = west_regex.sub(west_svg, html)

hero_html = '''
    <style>
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=2000') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            color: #FFFFFF;
            position: relative;
        }
        .navbar {
            padding: 30px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar__brand-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navbar__logo-icon { width: 36px; height: 36px; fill: white; }
        .navbar__brand-text { display: flex; flex-direction: column; color: white; }
        .brand-title { font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .brand-subtitle { font-size: 10px; font-weight: 400; opacity: 0.8; text-transform: uppercase; }
        
        .navbar__links {
            display: flex;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        .navbar__links a {
            color: #FFFFFF;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .lang-toggle {
            font-size: 11px;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.5);
            padding: 6px 12px;
            color: #FFF;
            text-decoration: none;
            text-transform: uppercase;
        }
        .hero__content {
            margin-top: auto;
            padding: 0 60px 80px;
            max-width: 800px;
        }
        .hero__text {
            font-size: 38px;
            font-weight: 700;
            line-height: 1.3;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            font-family: 'Inter', sans-serif;
        }
    </style>
    <section class="hero" id="hero-1">
        <nav class="navbar">
            <div class="navbar__brand-area">
                <svg class="navbar__logo-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12,2 C15,2 18,5 18,8 C18,12 12,18 12,22 C12,18 6,12 6,8 C6,5 9,2 12,2 Z" fill="none" stroke="white" stroke-width="2"/>
                    <circle cx="12" cy="10" r="3" fill="none" stroke="white" stroke-width="2"/>
                </svg>
                <div class="navbar__brand-text">
                    <span class="brand-title">Beragam Rasa Indonesia</span>
                    <span class="brand-subtitle">Solusi Bisnis Kopi Anda</span>
                </div>
            </div>
            <ul class="navbar__links">
                <li><a href="#">Temukan Rasa Indonesia</a></li>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Produk & Layanan</a></li>
                <li><a href="#">Keberlanjutan</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
            <a href="#" class="lang-toggle">EN / ID</a>
        </nav>
        <div class="hero__content">
            <h1 class="hero__text">Temukan beragam rasa Indonesia, diperoleh secara berkelanjutan dari para petani nusantara.</h1>
        </div>
    </section>
'''

body_idx = html.find('<body>')
if body_idx != -1:
    html = html[:body_idx+6] + '\n' + hero_html + html[body_idx+6:]

with open('beragam-rasa.html', 'w', encoding='utf-8') as f:
    f.write(html)
