#  Chief admin package

[![Latest Version](https://img.shields.io/github/release/thinktomorrow/chief-sitestructure.svg?style=flat-square)](https://github.com/thinktomorrow/chief-sitestructure/releases)
[![Build Status](https://img.shields.io/travis/thinktomorrow/chief-sitestructure/master.svg?style=flat-square)](https://travis-ci.org/thinktomorrow/chief)
[![Quality Score](https://img.shields.io/scrutinizer/g/thinktomorrow/chief-sitestructure.svg?style=flat-square)](https://scrutinizer-ci.com/g/thinktomorrow/chief-sitestructure)
[![StyleCI](https://styleci.io/repos/33916850/shield)](https://styleci.io/repos/33916850)
[![Total Downloads](https://img.shields.io/packagist/dt/thinktomorrow/chief-sitestructure.svg?style=flat-square)](https://packagist.org/packages/thinktomorrow/chief-sitestructure)

# Chief sitestructure

This add-on adds sitestructure and breadcrumb features to chief.

# Versions

Since this is an add-on for Thinktomorrow/chief that package is required.

This add-on also relies on certain features in chief so it's only supported from 0.4.6 onwards.

# Installation

```bash
composer require thinktomorrow/chief-sitestructure
```

Run migrations, this will create the site_structure table.

```bash
php artisan migrate
```


# Usage

To start using breadcrumbs for pages first add the `BreadcrumbAssistant` to the relevant PageManager.

```php
    protected $assistants = [
        UrlAssistant::class,
        ArchiveAssistant::class,
        PublishAssistant::class,
        BreadcrumbAssistant::class,
    ];
```

The assistant will add a field to each page to select the parent page.

Next up is creating the view for the breadcrumbs. The following is an example of a breadcrumb view.
Offline pages are automaticly filtered out of the breadcrumb structure.

```blade
@foreach(breadcrumbs($page) as $crumb)
    @if($loop->last)
        <svg width="12" height="12" class="mr-2"><use xlink:href="#icon--chevron-right"></use></svg>
        <span class="text-sm" title="{{ $crumb->label }}" aria-current="page">
            {{ $crumb->label }}
        </span>
    @else
        <svg width="12" height="12" class="mr-2"><use xlink:href="#icon--chevron-right"></use></svg>
        <a href="{{ $crumb->url }}" class="font-medium text-primary-500 hover:underline mr-2 text-sm">{{ $crumb->label }}</a>
    @endif
@endforeach
```
