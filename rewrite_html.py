import re

# Load SVG paths
with open('indonesia_paths.txt', 'r', encoding='utf-8') as f:
    indo_paths = f.read()

with open('westjava_paths.txt', 'r', encoding='utf-8') as f:
    west_paths = f.read()

html = f"""<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beragam Rasa Indonesia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        * {{ box-sizing: border-box; margin: 0; padding: 0; }}
        :root {{
            --primary: #B55A2A;
            --cream: #F5EEDD;
            --black: #1A1A1A;
            --white: #FFFFFF;
            --gray: #F0F0F0;
        }}
        body {{ font-family: 'Inter', sans-serif; background: var(--white); color: var(--black); }}

        /* HERO SECTION */
        .hero {{
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=2000') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            color: var(--white);
            position: relative;
        }}
        .navbar {{
            padding: 30px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }}
        .navbar__brand-area {{
            display: flex;
            align-items: center;
            gap: 15px;
        }}
        .navbar__logo-icon {{ width: 36px; height: 36px; fill: white; }}
        .navbar__brand-text {{ display: flex; flex-direction: column; color: white; }}
        .brand-title {{ font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; font-family: 'Space Mono', monospace; }}
        .brand-subtitle {{ font-size: 10px; font-weight: 400; opacity: 0.8; text-transform: uppercase; font-family: 'Space Mono', monospace; letter-spacing: 1px; }}
        
        .navbar__links {{
            display: flex;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }}
        .navbar__links a {{
            color: #FFFFFF;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }}
        .lang-toggle {{
            font-size: 11px;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.5);
            padding: 6px 12px;
            color: #FFF;
            text-decoration: none;
            text-transform: uppercase;
        }}
        .hero__content {{
            margin-top: auto;
            padding: 0 60px 80px;
            max-width: 800px;
        }}
        .hero__text {{
            font-size: 38px;
            font-weight: 700;
            line-height: 1.3;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            font-family: 'Inter', sans-serif;
        }}

        /* PETA RASA SECTION */
        .map-section {{ padding: 80px 40px; text-align: center; background: var(--color-white, #FFFFFF); font-family: 'Inter', sans-serif; }}
        .map-title {{ font-size: 32px; font-weight: 700; color: #6D6254; margin-bottom: 30px; letter-spacing: -0.5px; }}

        .toggle-container {{ margin-bottom: 50px; display: inline-flex; border: 1px solid #A44C40; border-radius: 40px; overflow: hidden; }}
        .toggle-btn {{ 
            padding: 10px 30px; 
            border: none; 
            background: transparent; 
            font-size: 11px; 
            font-weight: 700; 
            cursor: pointer; 
            text-transform: uppercase;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
            color: #A44C40;
            letter-spacing: 1px;
        }}
        .toggle-btn.active {{ background: #A44C40; color: #FFFFFF; }}

        .map-wrapper {{ max-width: 900px; margin: 0 auto 50px; position: relative; min-height: 400px; display: flex; align-items: center; justify-content: center; }}
        .indonesia-map, .west-java-map {{ width: 100%; height: auto; max-height: 400px; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.05)); }}
        
        .hidden {{ display: none !important; }}

        /* Map Paths */
        .map-path {{ stroke: #FFF; stroke-width: 0.5; stroke-linejoin: round; transition: fill 0.5s ease; }}
        
        /* Island Colors for Kopi (Indonesia) */
        .kopi-sumatra-n {{ fill: #6A2B20; }}
        .kopi-sumatra-m {{ fill: #B5564A; }}
        .kopi-sumatra-s {{ fill: #745749; }}
        .kopi-java-w {{ fill: #A44C40; }}
        .kopi-java-c {{ fill: #572E19; }}
        .kopi-java-e {{ fill: #D28660; }}
        .kopi-bali {{ fill: #3B4E38; }}
        .kopi-kalimantan {{ fill: #EAE6D6; }}
        .kopi-sulawesi {{ fill: #1B2455; }}
        .kopi-maluku {{ fill: #432646; }}
        .kopi-papua {{ fill: #EAE6D6; }}
        
        /* Colors for Gula Aren (West Java) */
        .gula-highlight {{ fill: #C47C59; }}
        .gula-normal {{ fill: #EAE6D6; }}

        /* STATS */
        .stats-container {{ display: flex; justify-content: center; align-items: flex-start; gap: 40px; max-width: 1000px; margin: 0 auto; padding-top: 0; }}
        .stat-item {{ flex: 1; text-align: center; display: flex; flex-direction: column; align-items: center; }}
        .stat-value {{ font-family: 'Bebas Neue', sans-serif; font-size: 42px; font-weight: 400; line-height: 1.1; margin-bottom: 12px; color: #6D6254; letter-spacing: 1px; }}
        .stat-desc {{ font-family: 'Inter', sans-serif; font-size: 12px; line-height: 1.6; color: #999; max-width: 250px; margin: 0 auto; }}
        .stat-divider {{ width: 1px; background: #E0E0E0; height: 60px; margin-top: 10px; }}
    </style>
</head>
<body>

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
            <h1 class="hero__text">Temukan beragam rasa Indonesia,<br>diperoleh secara berkelanjutan dari<br>para petani nusantara.</h1>
        </div>
    </section>

    <section class="map-section">
        <h2 class="map-title">Peta Rasa Indonesia</h2>
        
        <div class="toggle-container">
            <button class="toggle-btn active" id="btn-kopi">KOPI</button>
            <button class="toggle-btn" id="btn-gula">GULA AREN</button>
        </div>

        <div class="map-wrapper" id="map-kopi">
            <svg class="indonesia-map" viewBox="0 0 1000 400" xmlns="http://www.w3.org/2000/svg">
                {indo_paths}
            </svg>
        </div>

        <div class="map-wrapper hidden" id="map-gula">
            <svg class="west-java-map" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">
                {west_paths}
            </svg>
        </div>

        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-value" id="stat-weight">218.400 KG</div>
                <div class="stat-desc" id="desc-weight">Biji kopi Arabika dan Robusta dipanen dari berbagai daerah pada 2025.</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-value" id="stat-area">540 HA</div>
                <div class="stat-desc" id="desc-area">Area penanaman di seluruh Indonesia.</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-value" id="stat-farmers">364 PETANI<br>TERBERDAYAKAN</div>
                <div class="stat-desc" id="desc-farmers">1 kepala keluarga menggarap 1 Ha lahan,<br>menghasilkan 600 kg biji kopi per tahun.</div>
            </div>
        </div>
    </section>

    <script>
        const btnKopi = document.getElementById('btn-kopi');
        const btnGula = document.getElementById('btn-gula');
        
        const mapKopi = document.getElementById('map-kopi');
        const mapGula = document.getElementById('map-gula');

        const statWeight = document.getElementById('stat-weight');
        const statArea = document.getElementById('stat-area');
        const statFarmers = document.getElementById('stat-farmers');
        
        const descWeight = document.getElementById('desc-weight');
        const descArea = document.getElementById('desc-area');
        const descFarmers = document.getElementById('desc-farmers');

        const dataKopi = {{
            weight: "218.400 KG",
            area: "540 HA",
            farmers: "364 PETANI<br>TERBERDAYAKAN",
            descWeight: "Biji kopi Arabika dan Robusta dipanen dari berbagai daerah pada 2025.",
            descArea: "Area penanaman di seluruh Indonesia.",
            descFarmers: "1 kepala keluarga menggarap 1 Ha lahan,<br>menghasilkan 600 kg biji kopi per tahun."
        }};

        const dataGula = {{
            weight: "80.555 KG",
            area: "284 HA",
            farmers: "56 PETANI<br>TERBERDAYAKAN",
            descWeight: "Gula aren dipanen dari Jawa Barat pada 2025.",
            descArea: "Area penanaman di seluruh Jawa Barat.",
            descFarmers: "1 kepala keluarga menggarap 2 kg gula aren batok."
        }};

        function updateUI(data) {{
            statWeight.innerHTML = data.weight;
            statArea.innerHTML = data.area;
            statFarmers.innerHTML = data.farmers;
            descWeight.innerHTML = data.descWeight;
            descArea.innerHTML = data.descArea;
            descFarmers.innerHTML = data.descFarmers;
        }}

        btnKopi.addEventListener('click', () => {{
            btnKopi.classList.add('active');
            btnGula.classList.remove('active');
            mapKopi.classList.remove('hidden');
            mapGula.classList.add('hidden');
            updateUI(dataKopi);
        }});

        btnGula.addEventListener('click', () => {{
            btnGula.classList.add('active');
            btnKopi.classList.remove('active');
            mapGula.classList.remove('hidden');
            mapKopi.classList.add('hidden');
            updateUI(dataGula);
        }});

        // Initialize
        updateUI(dataKopi);
    </script>
</body>
</html>
"""

with open('beragam-rasa.html', 'w', encoding='utf-8') as f:
    f.write(html)
