{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
{!! '<' . '?xml-stylesheet type="text/xsl" href="' . asset('sitemap-index-style.xsl') . '"?' . '>' !!}
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($sitemaps as $sitemap)
        <sitemap>
            <loc>{{ $sitemap['url'] }}</loc>
            <lastmod>{{ $sitemap['lastmod'] }}</lastmod>
        </sitemap>
    @endforeach
</sitemapindex>
