# pureftp-api

## Requirements
* Docker: https://docs.docker.com/install/linux/docker-ce/debian/#install-docker-ce
* Docker-Compose: https://docs.docker.com/compose/install/

## Install for Production

Clone the repository 
```
git clone https://github.com/lextira/pureftpd.git
```

Create a new folder and copy these files/directories from your git repo:
Its recommended to store all these configurations as well as all uploaded data (FTP_DIR), Database-Data (DB_DIR) and Certificates (TLS_CERT_DIR) on a persistent drive to keep them save.
```
cp -r config-example/ /.../pureftpd/config/
cp .env.example /.../pureftpd/.env
cp production.docker-compose.yml /.../pureftpd/docker-compose.yml
```

Adjust the `.env`-file to your environment. 

Get the initial certificates (from letsencrypt staging environment). This must succeed before you can continue!
```
source .env && docker run -ti --rm -v $TLS_CERT_DIR:/etc/letsencrypt/ -p 80:80 webdevops/certbot \
/usr/bin/certbot certonly --staging --force-renewal --noninteractive --agree-tos --standalone --preferred-challenges http -d $CERTBOT_DOMAIN -m $CERTBOT_EMAIL
```

Start the application
```
docker-compose up -d web ftp
```

Finally, create the database structure
```
docker-compose exec web /usr/bin/php artisan migrate --force
```

Your server is now up and running. You should create a cronjob for renewing the certificates.
```
docker-compose run --rm certbot && docker-compose restart web ftp
```
 * by default, in the `docker-compose.yml` file, the "--staging" and "--force-renewal" lines are active. When you are ready for certificates, you must remove these lines. But only do this, if the challenges are successful, as otherwise you would run into rate limitations of let's encrypt very fast.


## Manage the server

Once done the installation, you surely want to add some ftp accounts. This package supports accounts for multiple domains on a single server, but most of the time you will need only one.

For the initial setup, you need to log in the web-server, which has a CLI to manage the application.
```
docker-compose exec web /bin/bash
```

Now let's create the first domain:
```
php artisan ftp:domain:add example.com
```

You can also manually create a user. Once you've done this, you should be able to log in with your ftp client.
```
php artisan ftp:account:add example.com john --pass Secret
```

You may also want an API-key, so you can manage accounts through the API. Every virtual domain can have multiple keys.
```
php artisan ftp:key:generate example.com "This key is for mypage.com"
```

Now your server is up and running and ready to work. You can find the API-documentation on `your-ftp.domain.com/api/documentation`. If you prefer management trough CLI, simply type `php artisan ftp` to get the full list of commands. Help is available via `php artisan ftp:[command] --help`.



## Install for Development

```
docker run --rm -v $(pwd)/src:/app composer/composer install --ignore-platform-reqs

docker-compose -f docker-compose.development.yml up
```