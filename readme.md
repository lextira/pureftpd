## pureftp-api

Containers
- api: Handles HTTP API Requests
    
- mysql: Hold Login Information \
    Persistent Volume: Mysql DB
    
- pureftp: Handles FTP Connections \
    Persistent Volume: User Files

## Installation
*recommended: order persistent drive and attach on boot

order new instance (with the persistent drive attached)

log in instance

if the persistent disk wasn't used before, format it. maybe you need to replace /dev/sdb with another path
`sudo mkfs.ext4 -m 0 -F -E lazy_itable_init=0,lazy_journal_init=0,discard /dev/sdb`

then, mount the drive persistently in /etc/fstab
```
# get the uuid
sudo blkid /dev/sdb
#add line in /etc/fstab
UUID=[UUID_VALUE] /mnt/disks/[MNT_DIR] ext4 discard,defaults 0 2
```


install docker & docker compose
https://docs.docker.com/install/linux/docker-ce/debian/#install-docker-ce


docker run --rm -v $(pwd)/src:/app composer/composer install --ignore-platform-reqs