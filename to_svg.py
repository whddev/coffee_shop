import json

with open('indonesia.json', encoding='utf-8') as f:
    data = json.load(f)

min_x, max_x = 95.0, 141.5
min_y, max_y = -11.0, 6.0

width, height = 1000, 400

def transform(lon, lat):
    x = (lon - min_x) / (max_x - min_x) * width
    y = height - ((lat - min_y) / (max_y - min_y) * height)
    return x, y

out = ''
for feature in data['features']:
    geom = feature['geometry']
    props = feature['properties']
    prov = props.get('Propinsi', '').upper()
    
    cls = 'map-path '
    if 'SUMATERA' in prov or 'ACEH' in prov or 'RIAU' in prov or 'JAMBI' in prov or 'BENGKULU' in prov or 'LAMPUNG' in prov or 'BANGKA' in prov:
        if 'ACEH' in prov or 'UTARA' in prov:
            cls += 'kopi-sumatra-n'
        elif 'BARAT' in prov or 'RIAU' in prov:
            cls += 'kopi-sumatra-m'
        else:
            cls += 'kopi-sumatra-s'
    elif 'JAWA' in prov or 'BANTEN' in prov or 'YOGYAKARTA' in prov or 'JAKARTA' in prov:
        if 'JAWA BARAT' in prov or 'BANTEN' in prov or 'JAKARTA' in prov:
            cls += 'kopi-java-w'
        elif 'TENGAH' in prov or 'YOGYAKARTA' in prov:
            cls += 'kopi-java-c'
        else:
            cls += 'kopi-java-e'
    elif 'BALI' in prov or 'NUSA' in prov:
        cls += 'kopi-bali'
    elif 'KALIMANTAN' in prov:
        cls += 'kopi-kalimantan'
    elif 'SULAWESI' in prov or 'GORONTALO' in prov:
        cls += 'kopi-sulawesi'
    elif 'MALUKU' in prov:
        cls += 'kopi-maluku'
    elif 'PAPUA' in prov or 'IRIAN' in prov:
        cls += 'kopi-papua'
    else:
        cls += 'kopi-kalimantan'

    coords = geom['coordinates']
    if geom['type'] == 'Polygon':
        coords = [coords]
        
    for poly in coords:
        for ring in poly:
            path = 'M '
            for pt in ring:
                x, y = transform(pt[0], pt[1])
                path += f'{x:.1f},{y:.1f} L '
            path = path[:-3] + ' Z'
            out += f'<path class="{cls}" d="{path}" />\n'

with open('indonesia_paths.txt', 'w', encoding='utf-8') as f:
    f.write(out)

# Now for Gula Aren map, which is West Java only.
out_west = ''
for feature in data['features']:
    geom = feature['geometry']
    props = feature['properties']
    prov = props.get('Propinsi', '').upper()
    
    if 'JAWA BARAT' in prov:
        # We want a more zoomed in view of West Java
        # Let's use the same paths but scale it up
        coords = geom['coordinates']
        if geom['type'] == 'Polygon':
            coords = [coords]
        for poly in coords:
            for ring in poly:
                path = 'M '
                for pt in ring:
                    # Specific bounding box for West Java
                    wx = (pt[0] - 106.0) / (109.0 - 106.0) * 800
                    wy = 400 - ((pt[1] - -8.0) / (-5.5 - -8.0) * 400)
                    path += f'{wx:.1f},{wy:.1f} L '
                path = path[:-3] + ' Z'
                out_west += f'<path class="map-path gula-highlight" d="{path}" />\n'

with open('westjava_paths.txt', 'w', encoding='utf-8') as f:
    f.write(out_west)
