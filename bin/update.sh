cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )/../";
git fetch
git pull
composer install
bin/atomino mig:migrate
bin/clear-cache.sh
bin/publish.sh