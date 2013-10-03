<?php namespace DotZecker\Larafeed;

use Carbon\Carbon;

class Larafeed {

    public $charset = 'utf-8';

    public $lang;

    public $title;

    public $subtitle;    // Description

    public $pubDate;

    public $link;

    public $rssLink;

    public $logo;

    public $icon;

    public $rights;

    public $authors = array();

    public $entries = array();

    protected $types = array(
        'atom' => 'application/atom+xml',
        'rss'  => 'application/rss+xml'
    );

    public $type = 'atom';


    public function __construct($type = null)
    {
        if ($type == 'rss') $this->type = $type;
    }

    public function make($type = null)
    {
        return new Larafeed($type);
    }

    public function addEntry(Entry $entry)
    {
        if ($entry->isCorrect()) $this->entries[] = $entry;
    }

    public function render()
    {
        if (is_null($this->lang)) $this->lang = Config::get('application.language');

        if (is_null($this->link)) $this->link = URL::to('/'); // We assume that is home

        if (is_null($this->pubdate)) {
            $method = 'to' . strtolower($this->type) . 'String';
            $this->pubDate = Carbon::parse('now')->{$method}();
        }

        $feed = array(

        );

        // @todo: Feed validation

    }

}
