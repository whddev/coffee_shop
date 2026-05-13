import urllib.request
import re

req = urllib.request.Request('https://www.tuku.coffee/id', headers={'User-Agent': 'Mozilla/5.0'})
try:
    html = urllib.request.urlopen(req).read().decode('utf-8')
    print('\n'.join(re.findall(r'src=\"([^\"]+)\"', html)))
except Exception as e:
    print(e)
