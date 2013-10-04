Larafeed
========
[![Total Downloads](https://poser.pugx.org/dotzecker/larafeed/downloads.png)](https://packagist.org/packages/dotzecker/larafeed)

Feed (Atom and RSS) generator for Laravel 4


## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `dotzecker/larafeed`.

    "require": {
        "laravel/framework": "4.0.*",
        "dotzecker/larafeed": "dev-master"
    },

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'DotZecker\Larafeed\LarafeedServiceProvider'

Finally, you have to add the alias in the aliases array.

    'Feed' => 'DotZecker\Larafeed\Facades\Larafeed'

## Usage


## Credits

This package is inspired by [laravel4-feed](http://roumen.it/projects/laravel4-feed).


## License

Larafeed is licenced under the MIT license.
