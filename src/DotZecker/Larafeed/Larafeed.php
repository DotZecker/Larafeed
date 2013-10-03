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

    public function addEntry(Entry $entry)
    {
        if ($entry->isCorrect()) $this->entries[] = $entry->autoComplete();
    }

    public function render()
    {
        // @todo: Feed validation

        // Fill the empty attributes
        $this->autoComplete();

        return Response::make(
            View::make('larafeed::' . $this->contentType, array('feed' => $this)),
            200,
            array('Content-Type' => $this->getContentType() . '; charset=' . $this->charset)
        );

    }

    public function autoComplete()
    {
        if (is_null($this->lang)) $this->lang = Config::get('application.language');

        if (is_null($this->link)) $this->link = URL::to('/'); // We assume that is home

        if (is_null($this->pubdate)) {
            $method = 'to' . strtolower($this->contentType) . 'String';
            $this->pubDate = Carbon::parse('now')->{$method}();
        }
    }

    public function getContentType()
    {
        return $this->contentTypes[$this->contentType];
    }

}
