docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs

docker rmi laravelsail/php81-composer

if [ -e ./sail ];
then
    echo "sail - Simbolic link exists.";
else
    ln -s vendor/bin/sail sail;
fi
