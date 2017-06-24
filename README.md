# Filtering eloquent records for Laravel 5.*

[![Software License][ico-license]](LICENSE.md)

Package to handle filtering of records in Laravel 5.*. Allows easy defining of filtering and includes blade template command.

## Install

Via Composer

``` bash
$ composer require ravaelles/filterable
```

## Usage

**(1)** &nbsp; Open `config/app.php` and add to the end of providers this entry:
```
\Ravaelles\Filterable\FilterableServiceProvider::class,
```

---

**(2)** &nbsp; Now open command line in root of your project and publish a view:
```
php artisan vendor:publish
```
Feel free to modify it, it's now in `resources\views\packages\filterable\filtering.blade.php`

---

**(3)** &nbsp; Notice that `filtering.blade.php` uses `@push('scripts')` operator. 
It appends all the javascript scripts to the end of the html, when jQuery has already been loaded to avoid `jQuery is not defined` error. 
To make it work, please add `@stack('scripts')` part just after you load your last script using `<script>` tag. Notice the `@stack` blade operator is available since about Laravel 5.2.20.

---

**(4)** &nbsp; Now in your model add this trait:
``` php
use Ravaelles\Filterable\Filterable as Filterable;
(..)
class MyModelName extends Model 
{
    use Filterable; // Add trait
```
Every model that you want to be filterable will need this trait.

---

**(5)** &nbsp; It's time to define filters to be used (variable `$filters`). We will define some example filters so you can see how it works.
In your controller, just where you retrieve the records, add this:
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
        // 'Template' => Template::orderBy('id', -1)->pluck('name', 'id')->all() // Or use something like this
    ],
    
    // You can add more filters here
    //'field_name' => [
    //     'Display name' => ["black" => "Black tea", "green" => "Green tea"]
    //],
];

$users = User::orderBy('id')
	->filterable($filters)
	->paginate(10);
```

Notice that you can apply your own, custom `where` clauses just before the `->filterable` part.

---

**(6)** &nbsp; Finally, in your view add this line which will automatically display the filters using selects:
``` php
@include('vendor.filterable.filtering')
```
Feel free to modify this file as you wish.
---

**(7)** &nbsp; You are now able to use this package and dynamically filter the records! :)

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
