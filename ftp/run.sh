#!/bin/bash

echo "Concatiante CertFile..."
cat /etc/ssl/private/privkey.pem > /etc/ssl/private/pureftpd.pem
cat /etc/ssl/private/fullchain.pem >> /etc/ssl/private/pureftpd.pem

echo "Start rsylog deamon in background..."
rsyslogd &

echo "Start pure-ftpd..."
/usr/local/sbin/pure-ftpd /etc/pureftpd/pureftpd.conf