# Loki

Laravel localization done right.

[![forthebadge](https://forthebadge.com/images/badges/powered-by-electricity.svg)](https://forthebadge.com)

## Overview

If you are building a multilingual website and you need URL management then this is the package for you. It integrates into existing Laravel functionality to support translated URLs and custom locales.

**It supports route caching out of the box.**

Before, I was using [mcamara/laravel-localization
](https://github.com/mcamara/laravel-localization) to handle this, but I really really needed route caching to work. So, I created this package and simplified the whole setup and integration process.

Whatever `mcamara/laravel-localization` package can do, Loki can do too, but better.

### Features

- [x] Simple installation
- [x] Easy configuration
- [x] Custom locales
- [x] Hide default locale
- [x] Translated routes
- [x] Language selector
- [x] Route caching

## Installation

From the command line:

```
composer require laravelista/loki
```

Then, add the `Bifrost` trait to your `RouteServiceProvider` class:

```
use Laravelista\Loki\Bifrost;

class RouteServiceProvider extends ServiceProvider
{
    use Bifrost;
}
```

Finally, delete the method `mapWebRoutes()` from `RouteServiceProvider`.

**That's it!** View the configuration chapter bellow to configure your preferences.

### Configuration

Publish the config file with:

```
php artisan vendor:publish --provider="Laravelista\Loki\ServiceProvider"
```

You will find it under `config/loki.php`.

#### `supportedLocales` [array]

Locale names (codes) can be whatever you want.

_example._ en-GB, hr-HR, en-US, english, croatian, german, de, fr, ...

```
'supportedLocales' => ['hr', 'en'],
```

#### `defaultLocale` [string]

The default application locale must be from one of the locales defined in `supportedLocales`.

```
'defaultLocale' => 'en',
```

#### `hideDefaultLocale` [boolean]

If you want to hide the default locale in your URL set this to true. (The default is `true`.)

_example._ If your default locale is set to `en` then requests to URLs starting with `/en` will be redirected to `/`.

```
'hideDefaultLocale' => true,
```

#### `useTranslatedUrls` [boolean]

This enables you to use localized routes. (The default is `false`.)

If you are using translated URLs for each locale then set this to `true`.

_example._ `/en/about-us` on `en` locale will be `/hr/o-nama` on `hr` locale.

```
'useTranslatedUrls' => true,
```

Once this option is set to  `true` you have to create a routes file for each locale with the prefix of the locale.

`routes/en.web.php`:

```
<?php

Route::get('/', 'SampleController@home')->name('home');
Route::get('contact', 'SampleController@contact')->name('contact');
Route::get('about', 'SampleController@about')->name('about');
```

`routes/hr.web.php`:

```
<?php

Route::get('/', 'SampleController@home')->name('home');
Route::get('kontakt', 'SampleController@contact')->name('contact');
Route::get('o-nama', 'SampleController@about')->name('about');
```

## Helpers

Use this helpers in your view files.

### `__url($path)`

Use this instead of `url($path)` in your application.

```
<a href="{{ __url('/about') }}">@lang('app.about')</a>
```

### `__route($name)`

Use this instead of `route($name)` in your application.

**Use this if you have set `useTranslatedUrls` config option to `true`.**

Be sure to give all your routes a name.

```
<a href="{{ __route('about') }}">@lang('app.about')</a>
```

### `__currentUrl($locale)`

Use this to get the current URL in the desired locale.

```
<a href="{{ __currentUrl('hr') }}">O nama</a>
<a href="{{ __currentUrl('en') }}">About us</a>
```

### `__currentRoute($locale)`

Use this to get the current route in the desired locale.

**Use this if you have set `useTranslatedUrls` config option to `true`.**

Be sure to give all your routes a name.

```
<a href="{{ __currentRoute('hr') }}">O nama</a>
<a href="{{ __currentRoute('en') }}">About us</a>
```

## Language switcher

Use this blade template snippet to enable users to change the language:

```
<ul>
    @foreach(config('loki.supportedLocales') as $locale)
        <li>
            <a rel="alternate" hreflang="{{ $locale }}" href="{{ __currentRoute($locale) }}">
                {{ $locale }}
            </a>
        </li>
    @endforeach
</ul>
```

_You can modify the template however you want._



