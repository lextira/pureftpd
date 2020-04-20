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


## Configure for Production

### pureftpd-config
Open `/.../pureftpd/config/pureftpd/pureftpd.conf` with a text editor and make these changes. All of the changes are optional, but you should do the recommended ones. After you made all adjustments, you need to restart the ftp-server. You can do this with:
```
docker-compose restart ftp
```

#### Set passive address (recommended)
As pureftpd runs in a docker-container, it doesn't know it's public address. You can tell purefptd which public address to use with the `ForcePassiveIP`-line. Uncomment it and change it to the the public ip (the one your DNS entry points to).

```
ForcePassiveIP               1.2.3.4
```

## Upgrade in Production
It's easy to upgrade containers with short downtime. You can do it for all containers at once, but it's
recommended to do it step by step.

First, if you changed your docker-compose file to use fixed version for images, update those.

Then, pull the desired version and restart the container: `docker-compose pull {service} && docker-compose up --no-deps -d {service}
`

```
docker-compose pull web && docker-compose up --no-deps -d web

docker-compose pull ftp && docker-compose up --no-deps -d ftp

docker-compose pull db && docker-compose up --no-deps -d db
```

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
php artisan ftp:key:generate exapmple.com "This key is for mypage.com"
```

Now your server is up and running and ready to work. You can find the API-documentation on `your-ftp.domain.com/api/documentation`. If you prefer management trough CLI, simply type `php artisan ftp` to get the full list of commands. Help is available via `php artisan ftp:[command] --help`.



## Install for Development

```
docker run --rm -v $(pwd)/src:/app composer/composer install --ignore-platform-reqs

docker-compose -f development.docker-compose.yml up
```