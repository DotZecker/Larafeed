{{ '<?xml version="1.0" encoding="' . $feed->charset . '" ?>'."\n" }}
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>{{ $feed->title }}</title>
        <link>{{ $feed->link }}</link>
        <description>{{ $feed->description }}</description>
        <atom:link href="{{ $feed->feedLink }}" rel="self"></atom:link>

        @if (isset($feed->logo))
            <image>
                <title>{{ $feed->title }}</title>
                <link>{{ $feed->link }}</link>
                <url>{{ $feed->logo }}</url>
            </image>
        @endif

        <language>{{ $feed->lang }}</language>
        <lastBuildDate>{{ $feed->pubDate }}</lastBuildDate>

        @foreach($feed->entries as $item)
            <item>
                <title>{{ $item->title }}</title>
                <link>{{ $item->link }}</link>
                <guid isPermaLink="true">{{ $item->link }}</guid>
                <description><![CDATA[{{ $item->content }}]]></description>
                <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">{{ $item->author }}</dc:creator>
                <pubDate>{{ $item->pubDate}}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
