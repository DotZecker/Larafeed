<?php namespace DotZecker\Larafeed;

use Carbon\Carbon;

class Entry
{
    public $title;
    public $link;
    public $author;
    public $pubDate;
    public $updated;
    public $summary;
    public $content;
    public $format = 'atom';

    /**
     * Fill attributes
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Validate, auto-fill and sanitize the entry
     *
     * @return void
     */
    public function prepare()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        if (null !== $this->pubDate) {
            $this->pubDate = Carbon::parse($this->pubDate)->{$dateFormatMethod}();
        }

        if (null !== $this->updated) {
            $this->updated = Carbon::parse($this->updated)->{$dateFormatMethod}();
        }

        $this->title = strip_tags($this->title);

        $this->autoFill();
    }

    /**
     * Fill the attributes that can be auto-generated
     *
     * @return void
     */
    public function autoFill()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        if (null === $this->pubDate) {
            $this->pubDate = Carbon::parse('now')->{$dateFormatMethod}();
        }

        if (null === $this->summary) {
            $summary = strip_tags($this->content);

            $this->summary = substr($summary, 0, 144) . '...';
        }
    }
}
