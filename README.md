# Filtering eloquent records for Laravel 5.1

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Package to handle filtering of records in Laravel 5.*. Allows easy defining of filtering and includes blade template command.

## Install

Via Composer

``` bash
$ composer require ravaelles/filterable
```

## Usage

In your model:
``` php
use Ravaelles\Filterable\Filterable as Filterable;
(..)
class MyModelName extends Model {
	use Filterable; // Add trait
```

In your controller:
``` php
$filters = [
    'status' => [
        'Status' => [
            Agreement::STATUS_CREATED => "Created",
            Agreement::STATUS_AWAITING_SIGNATURE => "Awaiting signature",
            Agreement::STATUS_CANCELED => "Canceled",
            Agreement::STATUS_SIGNED => "Signed",
        ]
    ],
    'template_id' => [
        'Template' => Template::lists('name', '_id')->all()
    ],
];

$users = User::with('blabla', 'blabla')
	->filterable($filters)
	->paginate(10);
```

In your view:
``` php
@include ('Filterable::filtering')
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/league/filterable.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ravaelles/filterable/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ravaelles/filterable.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/ravaelles/filterable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/league/filterable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/league/filterable
[link-travis]: https://travis-ci.org/ravaelles/filterable
[link-scrutinizer]: https://scrutinizer-ci.com/g/ravaelles/filterable/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/ravaelles/filterable
[link-downloads]: https://packagist.org/packages/league/filterable
[link-author]: https://github.com/Ravaelles
[link-contributors]: ../../contributors
