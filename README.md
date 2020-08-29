# Yii2 peoples finder
Library for search peoples via social networks. Now supported only ok.ru.

For license information check the [LICENSE-file](https://github.com/execut/yii2-peoples-finder/blob/master/LICENSE.md).

[![Latest Stable Version](https://poser.pugx.org/execut/yii2-peoples-finder/v/stable.png)](https://packagist.org/packages/execut/yii2-peoples-finder)
[![Total Downloads](https://poser.pugx.org/execut/yii2-peoples-finder/downloads.png)](https://packagist.org/packages/execut/yii2-peoples-finder)
[![Build Status](https://travis-ci.com/execut/yii2-peoples-finder.svg?branch=master)](https://travis-ci.com/execut/yii2-peoples-finder)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require execut/yii2-peoples-finder
```

or add

```
"execut/yii2-peoples-finder": "dev-master"
```

to the require section of your `composer.json` file.

Define your console environment variables from your browser social networks cookies.
For ok.ru:
```bash
ODNOKLASSNIKI_AUTHCODE=AUTHCODE cookie
ODNOKLASSNIKI_JSESSION=JSESSIONID cookie
```

Usage
----

Run console command and get report:
```bash
./yii peoplesFinder "people name" "GEDCOM file path"
```
Where:
people name - Finded people full name in format like "Anna Sergeevna Efremova (Pushkina)" (Pushkina - maiden name) or "Anna Efremova" or "Anna Sergeevna Efremova".
GEDCOM file path - path to family tree file to find a person by his family in friends.

See [GEDCOM standard](https://en.wikipedia.org/wiki/GEDCOM) for more information.