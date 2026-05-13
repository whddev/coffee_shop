import json

out = ''
for f in ['banten.json', 'jakarta.json', 'jawa_barat.json']:
    with open(f, encoding='utf-8') as file:
        data = json.load(file)
        for feat in data['features']:
            name = feat['properties']['name']
            geom = feat['geometry']
            coords = geom['coordinates']
            if geom['type'] == 'Polygon':
                coords = [coords]
            
            path = 'M '
            for poly in coords:
                for ring in poly:
                    for pt in ring:
                        # bounding box approx: 105.0 to 109.0, -8.0 to -5.5
                        wx = (pt[0] - 105.0) / (109.0 - 105.0) * 800
                        wy = 400 - ((pt[1] - -8.0) / (-5.5 - -8.0) * 400)
                        path += f'{wx:.1f},{wy:.1f} L '
                    path = path[:-3] + ' Z '
            
            cls = 'gula-normal'
            if name in ['SUKABUMI', 'CIANJUR', 'BANDUNG', 'GARUT', 'TASIKMALAYA', 'BANDUNG BARAT']:
                cls = 'gula-highlight'
            out += f'<path class="map-path {cls}" d="{path}" data-name="{name}" />\n'

with open('westjava_kabupaten_paths.txt', 'w', encoding='utf-8') as out_file:
    out_file.write(out)
