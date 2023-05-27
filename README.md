# ContaoToolbox


## Classes
```
DCAField::Text('tl_contao_server', 'name');
DCAField::Text('tl_contao_server', 'ip');
DCAField::Text('tl_contao_server', 'description');
```



## Commands

### Init
Erstellen des Grundgerustes fuer den Generator
```
./vendor/bin/contao-console contaotoolbox:dcabuilder:init
```
erstellt folgende Struktur im YAML Format:
```
basepath: 'change me'
active: true
projects:
changeme: { project: change/me, active: true, description: 'the description' }
```


