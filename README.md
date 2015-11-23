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

In command line publish view:
```
php artisan vendor:publish
```
Feel free to modify it, it's now in `\resources\views\packages\filterable\filtering.blade.php`

---

Now in your model:
``` php
use Ravaelles\Filterable\Filterable as Filterable;
(..)
class MyModelName extends Model {
	use Filterable; // Add trait
```

---

It's time to define filters to be used (variable `$filters`). We will define example filters that will almost definitely
In your controller, e.g. in index method:
``` php
$filters = [

    // First filter
    'status' => [ // Db field name
        'Status' => [ // Field name to be shown for user
            1 => "Created", // [Values => Display names] for select element
            2 => "Awaiting signature",
            3 => "Canceled",
            4 => "Signed",
        ]
    ],
    
    // Second filter
    'template_id' => [
        'Template' => [0 => "No", 1 => "Yes"]
        // 'Template' => Template::lists('name', 'id')->all() // You could use something like this
    ],
    
    // You can add more filters here
];

$users = User::with('blabla', 'blabla')
	->filterable($filters)
	->paginate(10);
```

---

Finally, in your view e.g. index.blade.php add this:
``` php
@include ('Filterable::filtering')
```

---

You should be now able to use this package and dynamically filter the records.

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
