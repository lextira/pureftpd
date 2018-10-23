#!/bin/bash

if [ "$LOCAL_CERT" = "true" ] && [ ! -f /etc/ssl/private/pureftpd.pem ]
then
   echo "--- Make key for localhost ---"
   mkdir -p /etc/ssl/private
   openssl req -x509 -keyout /etc/ssl/private/pureftpd.pem -out /etc/ssl/private/pureftpd.pem \
    -newkey rsa:2048 -nodes -sha256 \
    -subj '/CN=localhost' -extensions EXT -config <( \
     printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth")
else
    echo "--- Concatiante CertFile ---"
    cat /etc/ssl/private/privkey.pem > /etc/ssl/private/pureftpd.pem
    cat /etc/ssl/private/fullchain.pem >> /etc/ssl/private/pureftpd.pem
fi

echo "--- Start pure-ftpd ---"
/usr/local/sbin/pure-ftpd /etc/pureftpd/pureftpd.conf