Larafeed
========
[![Total Downloads](https://poser.pugx.org/dotzecker/larafeed/downloads.png)](https://packagist.org/packages/dotzecker/larafeed)

Feed (Atom and RSS) generator for any framework


## Installation

In order to install it via composer execute:

    composer require dotzecker/larafeed

## Usage
It is very intuitive of use, first, we need to instantiate the class (Note that the first argument is the format: atom or rss).
````php
use DotZecker\Larafeed\Larafeed as Feed;

$feed = Feed::make('atom', [
    'title'       => 'My cool blog about my super afro hair',
    'link'        => 'http://rafa.im',
    'feedLink'    => 'http://rafa.im/blog/feed',
    'logo'        => 'http://rafa.im/images/logo.png',
    'icon'        => 'http://rafa.im/favicon.ico',
    'description' => "I'm super awesome and I like to code, do you?"
]);
````

Or, if you prefer, you can fill it attribute by attribute:
````php
use DotZecker\Larafeed\Larafeed as Feed;

$feed = Feed::make('atom');

$feed->title       = 'My cool blog about my super afro hair';
$feed->link        = 'http://rafa.im';
$feed->description = "I don't say 'Hello World', the World says 'Hello Rafa' to me!";
````

Then, you can add author(s)
````php
// Only with the name
$feed->addAuthor('Rafael Antonio');

// With full info
$feed->addAuthor(['name' => 'Rafa', 'email' => 'mail@mail.foo', 'uri' => 'http://rafa.im']);
````

Now it's turn to add the entries. Surely, in your application, it will be inside of a `foreach` loop.
````php
$feed->addEntry([
    'title'   => 'Mi primer post',
    'link'    => 'http://rafa.im/blog/p/los-labels-y-la-usabilidad',
    'author'  => 'Rafael Antonio Gómez Casas',
    'pubDate' => '2013-03-15',
    'content' => 'Hola, este es mi primer post, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, quos, reprehenderit, nemo minus consectetur ipsum molestias cumque voluptatum deserunt impedit totam ab aspernatur rem voluptatibus dolore optio distinctio sequi vero harum neque qui suscipit libero deleniti minima repellat recusandae delectus beatae dignissimos corporis quaerat et nesciunt inventore architecto voluptates voluptatem.'
]);
````

Or you can fill it attribute by attribute:
````php
$entry = $feed->entry();

$entry->title   = 'My super title';
$entry->content = '¿Qué tal? :P Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, aperiam!';
// $entry->...
$feed->setEntry($entry); // We "inject" the entry
````

Finally, we return the generated feed (this will return us a `Symfony\Component\HttpFoundation\Response`)
````php
return $feed->render();
````

## License

Larafeed is licenced under the MIT license.
