<?php namespace DotZecker\Larafeed;

use URL;
use View;
use Config;
use Response;
use Carbon\Carbon;

class Larafeed {

    public $charset = 'utf-8';

    public $lang;

    public $title;

    public $description; // Subtitle

    public $pubDate;

    public $link;

    public $feedLink;

    public $logo;

    public $icon;

    public $rights;

    public $authors = array();

    public $entries = array();

    protected $contentTypes = array(
        'atom' => 'application/atom+xml',
        'rss'  => 'application/rss+xml'
    );

    public $contentType = 'atom';


    public function __construct($contentType = null)
    {
        if ($contentType == 'rss') $this->contentType = $contentType;
    }

    public function make($contentType = null)
    {
        return new Larafeed($contentType);
    }

    public function Entry($title = null, $link = null, $author = null, $pubDate = null, $content = null)
    {
        return new Entry($title, $link, $author, $pubDate, $content, $this->contentType);
    }

    public function setEntry(Entry $entry)
    {
        $this->entries[] = $entry->autoComplete($this->contentType);
    }

    public function addEntry($title = null, $link = null, $author = null, $pubDate = null, $content = null)
    {
        $entry = new Entry($title, $link, $author, $pubDate, $content, $this->contentType);
        $this->entries[] = $entry->autoComplete($this->contentType);
    }

    public function addAuthor($name, $email = null, $uri = null)
    {
        $author = array('name' => $name);
        if ( ! is_null($email)) $author['email'] = $email;
        if ( ! is_null($uri))   $author['uri']   = $uri;

        $this->authors[] = (object) $author;
    }

    public function render()
    {
        // @todo: Feed validation

        // Fill the empty attributes
        $this->autoComplete();

        return Response::make(View::make("larafeed::{$this->contentType}", array('feed' => $this)), 200, array(
                'Content-Type' => "{$this->getContentType()}; charset={$this->charset}"
        ));

    }

    protected function autoComplete()
    {
        if (is_null($this->lang)) $this->lang = Config::get('app.locale');
        if (is_null($this->link)) $this->link = URL::to('/'); // We assume that is home
        if (is_null($this->feedLink)) $this->feedLink = URL::full();
        if (is_null($this->pubDate)) {
            $method = 'to' . strtolower($this->contentType) . 'String';
            $this->pubDate = Carbon::parse('now')->{$method}();
        }
        $this->title = strip_tags($this->title);
        $this->description = strip_tags($this->description);


    }

    public function getContentType()
    {
        return $this->contentTypes[$this->contentType];
    }

}
