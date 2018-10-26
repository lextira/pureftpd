# pureftp-api

## Requirements
* Docker: https://docs.docker.com/install/linux/docker-ce/debian/#install-docker-ce
* Docker-Compose: https://docs.docker.com/compose/install/

## Install for Production

Clone the repository ```git clone https://github.com/lextira/pureftpd.git```

Create a new folder and copy these files/directories from your git repo:
Its recommended to store all these configurations as well as all uploaded data (FTP_DIR), Database-Data (DB_DIR) and Certificates (TLS_CERT_DIR) on a persistent drive to keep them save.
```
cp -r config-example/ /.../pureftpd/config/
cp .env.example /.../pureftpd/.env
cp production.docker-compose.yml /.../pureftpd/docker-compose.yml
```

Adjust the `.env`-file to your environment. 

Get the initial certificates (from letsencrypt staging environment). This must succeed before you can continue!
```source .env && docker run -ti --rm -v $TLS_CERT_DIR:/etc/letsencrypt/ -p 80:80 webdevops/certbot \
    /usr/bin/certbot certonly --staging --force-renewal --noninteractive --agree-tos --standalone --preferred-challenges http -d $CERTBOT_DOMAIN -m $CERTBOT_EMAIL ```

Start the application
```docker-compose up -d web ftp```

Update your certificates. You should create a cronjob for this, which runs at least once per week.
```docker-compose run --rm certbot && docker-compose restart web ftp```
 * by default, in the compose file, the "--staging" and "--force-renewal" lines are active. once you want real certificates, you must remove them. Only do this, if the challenges are successful, as otherwise you would run into rate limitations of let's encrypt very fast.

Finally, create the database structure
```docker-compose exec web /usr/bin/php artisan migrate --force```


## Install for Development

docker run --rm -v $(pwd)/src:/app composer/composer install --ignore-platform-reqs

docker-compose -f docker-compose.development.yml up