cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )/../";
mkdir -p var/data/attachments
mkdir -p var/etc
touch var/etc/version
mkdir var/log
mkdir var/public
mkdir var/tmp
mkdir var/vhost