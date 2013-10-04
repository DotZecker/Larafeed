<?php namespace DotZecker\Larafeed;

use URL;
use View;
use Config;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

    public $authors;

    public $entries;

    protected $contentTypes = array(
        'atom' => 'application/atom+xml',
        'rss'  => 'application/rss+xml'
    );

    public $format = 'atom';


    public function __construct($format = null)
    {
        if ($format == 'rss') $this->format = $format;

        $this->authors = new Collection();
        $this->entries = new Collection();
    }

    public function make($format = null)
    {
        return new Larafeed($format);
    }

    public function Entry(array $data = array())
    {
        return new Entry($data);
    }

    public function setEntry(Entry $entry)
    {
        $entry->format = $this->format;
        $entry->prepare();

        $this->entries->push($entry);
    }

    public function addEntry(array $data = array())
    {
        $entry = new Entry($data);

        if ($entry->isValid())
            $this->setEntry($entry);
    }

    public function addAuthor($author)
    {
        if ( ! is_array($author)) $author = array('name' => $author);

        $this->authors->push((object) $author);
    }

    public function render()
    {
        $this->prepare();

        return Response::make(View::make("larafeed::{$this->format}", array('feed' => $this)), 200, array(
                'Content-Type' => "{$this->getContentType()}; charset={$this->charset}"
        ));

    }

    protected function prepare()
    {
        // Feed validation

        if ( ! is_null($this->pubDate)) {
            $method = 'to' . strtolower($this->format) . 'String';
            $this->pubDate = Carbon::parse($this->pubDate)->{$method}();
        }

        // Fill the empty attributes
        $this->autoFill();

        // We ensure that it's plain text
        $this->title = strip_tags($this->title);
        $this->description = strip_tags($this->description);
    }

    protected function autoFill()
    {
        if (is_null($this->lang)) $this->lang = Config::get('app.locale');

        if (is_null($this->link)) $this->link = URL::to('/');

        if (is_null($this->feedLink)) $this->feedLink = URL::full();

        if (is_null($this->pubDate)) {
            $method = 'to' . strtolower($this->format) . 'String';
            $this->pubDate = Carbon::parse('now')->{$method}();
        }

    }

    public function getContentType()
    {
        return $this->contentTypes[$this->format];
    }

}
