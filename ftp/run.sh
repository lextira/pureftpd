#!/bin/bash

if [ "$LOCAL_CERT" = "true" ] && [ ! -f /etc/ssl/private/certs.pem ]
then
   echo "--- Make key for localhost ---"
   mkdir -p /etc/ssl/private
   openssl req -x509 -keyout /etc/ssl/private/certs.pem -out /etc/ssl/private/certs.pem \
    -newkey rsa:2048 -nodes -sha256 \
    -subj '/CN=localhost' -extensions EXT -config <( \
     printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth")
fi

echo "--- Start pure-ftpd ---"
/usr/local/sbin/pure-ftpd /etc/pureftpd/pureftpd.conf