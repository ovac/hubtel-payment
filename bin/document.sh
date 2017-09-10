#!/bin/sh
bin/ci.sh

echo ""
# get sami if it does not exist.
[ -e sami.phar ] && echo "Sami found\r\n" || curl -O http://get.sensiolabs.org/sami.phar | php;

# get couscous if it does not exist.
[ -e couscous.phar ] && echo "Couscous found\r\n" || curl -O http://couscous.io/couscous.phar | php;

echo "Generating Documentation\r\n";

# Run the sami generator
php sami.phar update ./sami.config.php -v;

# Run the couscous static site generator
php couscous.phar generate --target=./build/couscous;

# clone the project and climb into the directory and switch to the gh-pages branch
git clone https://www.github.com/ovac/hubtel-payment;

cd hubtel-payment;

git checkout gh-pages;

# Remove all files from the github pages folder
shopt -s extglob;
shopt -s dotglob nullglob;
rm -rf !(*.git);

# Make a directory for the sami generated doc and test coverage
mkdir -p ./api;
mkdir -p ./coverage;
touch .nojekyll;

# copy all files from the couscous generated folder into the empty github-pages branch folder
mv  -v ../build/couscous/* ./;

# copy all files from the sami generated folder into the api folder
mv  -v ../build/sami/* ./api/;

# copy all files from the coverage generated folder into the coverage folder
mv  -v ../build/coverage/* ./coverage/;

# Add all and commit to github if deploy was enabled
git add --all . && git add **/.* && git commit -m 'Documentation Updated' && git push origin gh-pages;

rm -rf ../hubtel-payment;
