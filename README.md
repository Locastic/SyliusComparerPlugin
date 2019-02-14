<h1 align="center">
    <a href="http://www.locastic.com" target="_blank">
        <img src="https://raw.githubusercontent.com/Locastic/SyliusComparerPlugin/master/LocasticSyliusComparePlugin.png" />
    </a>
    <br />
    <a href="https://packagist.org/packages/locastic/sylius-comparer-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/locastic/sylius-comparer-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/locastic/sylius-comparer-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/Locastic/sylius-comparer-plugin.svg" />
    </a>
    <a href="https://travis-ci.org/Locastic/SyliusComparerPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/Locastic/SyliusComparerPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Locastic/SyliusComparerPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/Locastic/SyliusComparerPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/locastic/sylius-comparer-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/locastic/sylius-comparer-plugin/downloads" />
    </a>
        <br/>
    <br/>
    <p align="center"><img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="200"></p>
</h1>

# Demo

To Do 

## Overview

Locastic comparer is Sylius Plugin for comparing store products. This plugin allows you to easily embody action of comparing products before adding them into cart in Sylius. 


## Installation
```bash
$ composer require locastic/sylius-comparer-plugin
```
    
Add plugin dependencies to your AppKernel.php file:
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new \Locastic\SyliusComparerPlugin\LocasticSyliusComparerPlugin(),
    ]);
}
```

## Usage

Inside Sylius shop add links to access comparer, and link to add shop product to comparer. Accessing comparer through link allows user to see comparer page with table of compared products and theirs attributes. Also, user has option of removing single product from comparer, or adding it further to shop cart.

## Testing
```bash
$ composer install
$ yarn install
$ yarn run gulp
$ (cd tests/Application && bin/console assets:install web -e test)
$ (cd tests/Application && bin/console doctrine:database:create)
$ (cd tests/Application && bin/console doctrine:schema:create -e test)
$ (cd tests/Application && bin/console sylius:fixtures:load)
$ (cd tests/Application && bin/console server:run 127.0.0.1:8080 -d web -e test)
$ open http://localhost:8080
$ bin/behat
$ bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.

## Support

Want us to help you with this plugin or any Sylius project? Write us an email on info@locastic.com
