Larafeed
========
[![Total Downloads](https://poser.pugx.org/dotzecker/larafeed/downloads.png)](https://packagist.org/packages/dotzecker/larafeed)

Feed (Atom and RSS) generator for PHP


## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `dotzecker/larafeed`.

    "require": {
        "dotzecker/larafeed": "1.5"
    },

Next, update Composer from the Terminal:

    composer update


# TODO: Complete readme to explain laravel service provider and facade are optional...

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'DotZecker\Larafeed\LarafeedServiceProvider'

Finally, you have to add the alias in the aliases array.

    'Feed' => 'DotZecker\Larafeed\Facades\Larafeed'


## Usage
It is very intuitive of use, first, we need to instantiate the class (Note that the first argument is the format: atom or rss).
```php
$feed = Feed::make('atom', array(
    'title' => 'My cool blog about my super afro hair',
    'link'  => URL::to('/'),
    'logo'  => asset('images/logo.png'),
    'icon'  => asset('favicon.ico'),
    'description' => "I'm super awesome and I like to code, do you?"
));
```

Or, if you prefer, you can fill it attribute by attribute:
```php
$feed = Feed::make('atom');
$feed->title = 'My cool blog about my super afro hair';
$feed->link  = URL::to('/');
$feed->description = "I don't say 'Hello World', the World says 'Hello Rafa' to me!";
```


Then, you can add author(s)
```php
// Only with the name
$feed->addAuthor('Rafael Antonio');

// With full info
$feed->addAuthor(array('name' => 'Rafa', 'email' => 'mail@mail.foo', 'uri' => 'http://rafa.im'));
```


Now it's turn to add the entries. Surely, in your application, it will be inside of a `foreach` loop.
```php
$feed->addEntry(array(
    'title'   => 'Mi primer post',
    'link'    => URL::to('/mi-primer-post'),
    'author'  => 'Rafael Antonio Gómez Casas',
    'pubDate' => '2013-03-15',
    'content' => 'Hola, este es mi primer post, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, quos, reprehenderit, nemo minus consectetur ipsum molestias cumque voluptatum deserunt impedit totam ab aspernatur rem voluptatibus dolore optio distinctio sequi vero harum neque qui suscipit libero deleniti minima repellat recusandae delectus beatae dignissimos corporis quaerat et nesciunt inventore architecto voluptates voluptatem.'
));
```


Or you can fill it attribute by attribute:
```php
$entry = $feed->entry();
$entry->title = 'My super title';
$entry->content = '¿Qué tal? :P Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, aperiam!';
// $entry->...
$feed->setEntry($entry); // We "inject" the entry
```


Finally, we return the generated feed
```php
return $feed->render();
```

## Credits

This package is inspired by [laravel4-feed](http://roumen.it/projects/laravel4-feed).


## License

Larafeed is licenced under the MIT license.
