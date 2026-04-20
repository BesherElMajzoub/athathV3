<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" lang="ar">
<head>
    <title>فهرس خرائط الموقع — Sitemap Index</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex,follow" />
    <style type="text/css">
        :root {
            --bg: #0f172a;
            --surface: #1e293b;
            --border: #334155;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --accent-hover: #7dd3fc;
            --green: #4ade80;
            --purple: #a78bfa;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            direction: rtl;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid var(--border);
            border-radius: 16px;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        .header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .stat-badge {
            display: inline-block;
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0.5rem 1.25rem;
            border-radius: 99px;
            font-size: 0.85rem;
            color: var(--accent);
            font-weight: 600;
            margin-top: 1rem;
        }
        .cards {
            display: grid;
            gap: 1rem;
        }
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        .card:hover {
            border-color: var(--accent);
            background: rgba(56, 189, 248, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 4px 24px rgba(56, 189, 248, 0.1);
        }
        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.25rem;
        }
        .card-url {
            font-size: 0.8rem;
            color: var(--text-muted);
            word-break: break-all;
            font-family: monospace;
        }
        .card-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-family: monospace;
            white-space: nowrap;
            margin-right: 1.5rem;
        }
        .card-arrow {
            color: var(--accent);
            font-size: 1.25rem;
            margin-right: 1rem;
            transition: transform 0.2s;
        }
        .card:hover .card-arrow {
            transform: translateX(-4px);
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .card { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            .card-date { margin-right: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🗺️ فهرس خرائط الموقع</h1>
        <p>يحتوي هذا الفهرس على جميع خرائط الموقع الفرعية التي تساعد محركات البحث في فهرسة المحتوى</p>
        <span class="stat-badge">
            📁 عدد الخرائط الفرعية: <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/>
        </span>
    </div>

    <div class="cards">
        <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
            <a class="card" href="{sitemap:loc}">
                <div>
                    <div class="card-title">
                        <xsl:choose>
                            <xsl:when test="contains(sitemap:loc, 'pages.xml')">📄 الصفحات الأساسية</xsl:when>
                            <xsl:when test="contains(sitemap:loc, 'services.xml')">🛠️ الخدمات</xsl:when>
                            <xsl:when test="contains(sitemap:loc, 'districts.xml')">📍 الأحياء والمناطق</xsl:when>
                            <xsl:when test="contains(sitemap:loc, 'blog.xml')">📝 المدونة والمقالات</xsl:when>
                            <xsl:when test="contains(sitemap:loc, 'programmatic.xml')">⚡ الصفحات البرمجية</xsl:when>
                            <xsl:otherwise>📋 خريطة فرعية</xsl:otherwise>
                        </xsl:choose>
                    </div>
                    <div class="card-url"><xsl:value-of select="sitemap:loc"/></div>
                </div>
                <div style="display:flex;align-items:center;">
                    <span class="card-date">آخر تحديث: <xsl:value-of select="sitemap:lastmod"/></span>
                    <span class="card-arrow">←</span>
                </div>
            </a>
        </xsl:for-each>
    </div>

    <div class="footer">
        تم إنشاء الفهرس تلقائياً • XML Sitemap Index
    </div>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
