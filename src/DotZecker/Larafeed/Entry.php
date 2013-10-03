<?php namespace DotZecker\Larafeed;

class Entry {

    public $title;

    public $link;

    public $author;

    public $pubDate;

    public $content; // Description


    public function __construct($title = null, $link = null, $author = null, $pubDate = null, $content = null)
    {
        if ( ! is_null($title))   $this->title   = $title;
        if ( ! is_null($link))    $this->link    = $link;
        if ( ! is_null($author))  $this->author  = $author;
        if ( ! is_null($pubDate)) $this->pubDate = $pubDate;
        if ( ! is_null($content)) $this->content = $content;
    }
}
