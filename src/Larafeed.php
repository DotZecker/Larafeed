<?php

namespace DotZecker\Larafeed;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig_Loader_Filesystem;

final class Larafeed
{
    const DEFAULT_LOCALE = 'en';

    public $charset = 'utf-8';
    public $lang;
    public $title;
    public $description;
    public $pubDate; // Subtitle
    public $link;
    public $feedLink;
    public $logo;
    public $icon;
    public $rights;
    public $authors;
    public $entries;
    public $format  = 'atom';

    private $twig;

    private $contentTypes = [
        'atom' => 'application/atom+xml',
        'rss'  => 'application/rss+xml',
    ];

    public function __construct($format = null, array $data = [])
    {
        if ($format === 'rss') {
            $this->format = $format;
        }

        foreach ($data as $attribute => $value) {
            $this->{$attribute} = $value;
        }

        $this->authors = new ArrayCollection();
        $this->entries = new ArrayCollection();

        $loader     = new Twig_Loader_Filesystem(__DIR__ . '/views/');
        $this->twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/../cache']);
    }

    /**
     * Return new instance of Larafeed
     *
     * @param string $format
     * @param array  $data
     *
     * @return self
     */
    public static function make($format = null, array $data = [])
    {
        return new Larafeed($format, $data);
    }

    /**
     * Return new Entry instance
     *
     * @param array $data
     *
     * @return Entry
     */
    public function Entry(array $data = [])
    {
        return new Entry($data);
    }

    /**
     * Prepare and push the entry to the feed (if it's valid)
     *
     * @param Entry $entry
     *
     * @return void
     */
    public function setEntry(Entry $entry)
    {
        $entry->format = $this->format;
        $entry->prepare();

        if ($entry->isValid()) {
            $this->entries->add($entry);
        }
    }

    /**
     * Create a new instance of Entry and try to set it
     *
     * @param array $data
     */
    public function addEntry(array $data = [])
    {
        $entry = new Entry($data);

        $this->setEntry($entry);
    }

    /**
     * Add an Author to the feed
     *
     * @param mixed $author It can be an array with name, email and uri,
     *                      or just and string with the name.
     */
    public function addAuthor($author)
    {
        if (!is_array($author)) {
            $author = ['name' => $author];
        }

        $this->authors->add((object) $author);
    }

    /**
     * Prepare the feed and if it's valid, renders it
     *
     * @return Response
     */
    public function render()
    {
        $this->prepare();

        $view = $this->twig->render(sprintf('%s.twig.html', $this->format), ['feed' => $this]);

        // Launch the Atom/RSS view, with 200 status
        return Response::create(
            $view,
            200,
            [
                'Content-Type' => "{$this->getContentType()}; charset={$this->charset}",
            ]
        );
    }

    private function prepare()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        // Set the good date format to the publication date
        if (null !== $this->pubDate) {
            $this->pubDate = Carbon::parse($this->pubDate)->{$dateFormatMethod}();
        }

        // Fill the empty attributes
        $this->autoFill();

        // We ensure that it's plain text
        $this->title       = strip_tags($this->title);
        $this->description = strip_tags($this->description);
    }

    private function autoFill()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        // Set the 'now' date
        if (null === $this->pubDate) {
            $this->pubDate = Carbon::parse('now')->{$dateFormatMethod}();
        }

        // Set laravel's default lang
        if (null === $this->lang) {
            $this->lang = self::DEFAULT_LOCALE;
        }
    }

    private function getContentType()
    {
        return $this->contentTypes[$this->format];
    }
}
