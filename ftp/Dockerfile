FROM debian:stretch-slim

# tell debian we want as less interaction as possible
ENV DEBIAN_FRONTEND noninteractive

# install packages
RUN apt-get update && \
    apt-get -y install wget build-essential && \
    apt-get -y install libssl-dev && \
    apt-get -y install libmariadb-dev && \
# download, configure and compile pure-ftpd
    mkdir /usr/src/pure-ftpd && cd /usr/src/pure-ftpd && \
    wget https://download.pureftpd.org/pub/pure-ftpd/releases/pure-ftpd-1.0.49.tar.gz && \
    tar xvzpf pure-ftpd-1*.tar.gz && \
    cd pure-ftpd-1* && \
    ./configure --with-mysql --with-tls --with-altlog && \
    make && make install-strip && \
# add a dedicated group for the ftp user
    groupadd -g 1000 ftp && useradd -u 1000 -g 1000 ftp && \
# create a dummy certificate, as the ftp server fails without it.
    mkdir -p /etc/ssl/private && \
    printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth" > /etc/ssl/openssl.cnf && \
    openssl req -x509 -keyout /etc/ssl/private/privkey.pem -out /etc/ssl/private/fullchain.pem -newkey rsa:2048 -nodes -sha256 -subj '/CN=localhost' -extensions EXT -config /etc/ssl/openssl.cnf

# setup run/init file
COPY run.sh /run.sh
RUN chmod u+x /run.sh

# data and config volume
VOLUME ["/ftp/data", "/etc/pureftpd"]

# startup
CMD /run.sh

EXPOSE 20-21 30000-30009