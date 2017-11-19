# Déployer Disco sur le site de Campus Grenoble

- `git clone git@github.com:martinkirch/disco.git disco_tmp`
- `cd disco_tmp`
- `curl -s https://getcomposer.org/installer | php`
- `php composer.phar update`, et entrez en passant les paramètres MySQL/SMTP. Pour les autres paramètres, en cas de doute laissez les valeurs par défaut (et en mutualisé chez OVH, voir plus bas)
- éditer web/app.php : remplacer `/../` par `/../../disco_libs/`.
- transferts des fichiers :
    - attention `web/bundles` contient des liens symboliques: il faut les copier à la main.
    - supprimer `web/app_dev.php`, `app/cache/dev` et `app/logs/dev.log`.
    - dans le répertoire distant, créer un répertoire `disco_libs` à coté de `www` et y transférer `app`, `src` et `vendor`.
    - donner des droits d'écriture à tous sur `disco_libs/app/cache` et `disco_libs/app/logs`.
    - tranférer `web` dans `www` et le renommer en `disco`
- et voilà : http://www.campusgrenoble.org/disco/

## Paramètres en mutualisé OVH

mailer_transport: mail
upload_root_dir: ../../../../www/disco


