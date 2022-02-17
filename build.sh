#!/bin/bash

mkdir ./src
mkdir ./tmp
curl -L https://github.com/zendframework/zf1/releases/download/release-1.12.20/ZendFramework-1.12.20-minimal.zip -o ./tmp/zend.zip
unzip ./tmp/zend.zip -d ./tmp/zend
cp -ap ./tmp/zend/ZendFramework-1.12.20-minimal/library/Zend ./src
php ./bin/remove-includes.php -d ./src
php ./vendor/bin/php-cs-fixer fix ./src --rules=@Symfony,ereg_to_preg --allow-risky=yes
rm -rf ./tmp