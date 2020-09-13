# Yii2 peoples finder
Library for search peoples via social networks. Now supported only ok.ru and vk.com.

For license information check the [LICENSE-file](https://github.com/execut/yii2-people-finder/blob/master/LICENSE.md).

[![Latest Stable Version](https://poser.pugx.org/execut/yii2-people-finder/v/stable.png)](https://packagist.org/packages/execut/yii2-people-finder)
[![Total Downloads](https://poser.pugx.org/execut/yii2-people-finder/downloads.png)](https://packagist.org/packages/execut/yii2-people-finder)
[![Build Status](https://travis-ci.com/execut/yii2-people-finder.svg?branch=master)](https://travis-ci.com/execut/yii2-people-finder)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require execut/yii2-people-finder
```

or add

```
"execut/yii2-people-finder": "dev-master"
```

to the require section of your `composer.json` file.

Define your console environment variables from your browser social networks cookies.
For ok.ru:
```bash
ODNOKLASSNIKI_AUTHCODE=AUTHCODE cookie
ODNOKLASSNIKI_JSESSION=JSESSIONID cookie
```
For vk:
```bash
VK_ACCESS_TOKEN=vk access token (get it via url from first command run)
```

Usage
----

**1. Run console command:**
```bash
./yii peopleFinder "Test User" "GEDCOM file path"
```
Where:
Test User - Finded people full name in format like "Anna Sergeevna Efremova (Pushkina)" (Pushkina - maiden name) or "Anna Efremova" or "Anna Sergeevna Efremova".
GEDCOM file path - path to family tree file to find a person by his family in friends.

**2. And get CSV report like this:**
```
Id;Name;Name;Friends;
7006;Test User;0;0;. Total friends: 1000
63750;Test User;0;0;Test User. Total friends: 0
3569;Test User;0;0;. Total friends: 478
```
Columns description:
1. Id - social network identity
1. Name - humman name
1. Name - name compare quality
1. Friends - a list of matching friends with those found in your GEDCOM file

See [GEDCOM standard](https://en.wikipedia.org/wiki/GEDCOM) for more information.