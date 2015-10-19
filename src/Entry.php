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
     * Validate, autofill and sanitize the entry
     *
     * @return void
     */
    public function prepare()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        // Set the good date format to the publication date
        if (null !== $this->pubDate) {
            $this->pubDate = Carbon::parse($this->pubDate)->{$dateFormatMethod}();
        }

        // Set the good date format to the publication last updated date
        if (null !== $this->updated) {
            $this->updated = Carbon::parse($this->updated)->{$dateFormatMethod}();
        }

        // Remove tags (In case it had)
        $this->title = strip_tags($this->title);

        // Fill the attributes that can be auto-generated
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

        // Set the 'now' date
        if (null === $this->pubDate) {
            $this->pubDate = Carbon::parse('now')->{$dateFormatMethod}();
        }

        // Generate the summary
        if (null === $this->summary) {
            $summary = strip_tags($this->content);

            // @todo: Get lenght by config
            $this->summary = substr($summary, 0, 144) . '...';
        }
    }
}
