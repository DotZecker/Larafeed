<?php namespace DotZecker\Larafeed;

class Larafeed {

    public $charset = 'utf-8';

    public $lang;

    public $title;

    public $subtitle; // Description

    public $updatedTime; // Pubdate

    public $link;

    public $rssLink;

    public $logo;

    public $icon;

    public $rights;

    public $authors = array();

    public $items = array();

    protected $contentTypes = array(
        'atom' => 'application/atom+xml',
        'rss'  => 'application/rss+xml'
    );

    public $contentType = 'atom';


    public function make()
    {
        return new Larafeed();
    }


}
