{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
{!! '<' . '?xml-stylesheet type="text/xsl" href="' . asset('sitemap-style.xsl') . '"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($urls as $url)
        <url>
            <loc>{{ $url['loc'] }}</loc>
            @isset($url['lastmod'])
                <lastmod>{{ $url['lastmod'] }}</lastmod>
            @endisset
            @isset($url['changefreq'])
                <changefreq>{{ $url['changefreq'] }}</changefreq>
            @endisset
            @isset($url['priority'])
                <priority>{{ $url['priority'] }}</priority>
            @endisset
            @isset($url['images'])
                @foreach ($url['images'] as $image)
                    <image:image>
                        <image:loc>{{ $image['loc'] }}</image:loc>
                        @isset($image['title'])
                            <image:title>{{ $image['title'] }}</image:title>
                        @endisset
                        @isset($image['caption'])
                            <image:caption>{{ $image['caption'] }}</image:caption>
                        @endisset
                    </image:image>
                @endforeach
            @endisset
        </url>
    @endforeach
</urlset>
