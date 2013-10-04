<?xml version="1.0" encoding="{{ $feed->charset }}" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>{{ $feed->link }}</id>
    <title type="text" xml:lang="{{ $feed->lang }}">{{ $feed->title }}</title>
    <subtitle type="text" xml:lang="{{ $feed->lang }}">{{ $feed->description }}</subtitle>
    <updated>{{ $feed->pubDate }}</updated>
    <link rel="alternate" type="text/html" href="{{ $feed->link }}" ></link>
    <link rel="self" type="application/atom+xml" href="{{ $feed->feedLink }}" ></link>

    @if (isset($feed->logo))
        <logo>{{ $feed->logo }}</logo>
    @endif

    @if (isset($feed->icon))
        <icon>{{ $feed->icon }}</icon>
    @endif

    @if (isset($feed->rights))
        <rights>{{ $feed->rights }}</rights>
    @endif

    @foreach($feed->authors as $author)
        <author>
            <name>{{ $author->name }}</name>

            @if (isset($author->email))
                <email>{{ $author->email }}</email>
            @endif

            @if (isset($author->uri))
                <uri>{{ $author->uri }}</uri>
            @endif
        </author>
    @endforeach

    @foreach($feed->entries as $entry)
        <entry>
            <id>{{ $entry->link }}</id>
            <title type="text" xml:lang="{{ $feed->lang }}">{{ $entry->title }}</title>
            <published>{{ $entry->pubDate }}</published>

            @if (isset($entry->updated))
                <updated>{{ $entry->updated }}</updated>
            @endif
            <author>
                <name>{{ $entry->author }}</name>
            </author>
            <link rel="alternate" type="text/html" hreflang="{{ $feed->lang }}"  href="{{ $entry->link }}"></link>
            <summary type="text" xml:lang="{{ $feed->lang }}">{{ $entry->summary }}</summary>
            <content type="html" xml:lang="{{ $feed->lang }}"><![CDATA[{{ $entry->content }}]]></content>
        </entry>
    @endforeach
</feed>
