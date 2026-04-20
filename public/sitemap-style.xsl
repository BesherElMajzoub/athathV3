<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" lang="ar">
<head>
    <title>خريطة الموقع XML — <xsl:value-of select="sitemap:urlset/sitemap:url[1]/sitemap:loc" /></title>
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
            --orange: #fb923c;
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
            max-width: 1200px;
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
        .stats {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        .stat-badge {
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0.5rem 1.25rem;
            border-radius: 99px;
            font-size: 0.85rem;
            color: var(--accent);
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--surface);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        thead th {
            background: var(--bg);
            color: var(--accent);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem;
            text-align: right;
            border-bottom: 2px solid var(--border);
        }
        tbody tr {
            transition: background 0.15s ease;
        }
        tbody tr:hover {
            background: rgba(56, 189, 248, 0.05);
        }
        tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 0.85rem 1.25rem;
            font-size: 0.9rem;
            vertical-align: middle;
        }
        td:first-child {
            font-weight: 500;
        }
        td a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.15s;
            word-break: break-all;
        }
        td a:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }
        .priority-high { color: var(--green); font-weight: 600; }
        .priority-med { color: var(--orange); font-weight: 600; }
        .priority-low { color: var(--text-muted); }
        .changefreq { color: var(--purple); font-size: 0.85rem; }
        .lastmod { color: var(--text-muted); font-size: 0.85rem; font-family: monospace; }
        .image-badge {
            display: inline-block;
            background: rgba(167, 139, 250, 0.15);
            color: var(--purple);
            font-size: 0.75rem;
            padding: 0.2rem 0.6rem;
            border-radius: 99px;
            margin-top: 0.25rem;
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        .row-num {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-family: monospace;
        }
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .header { padding: 1.5rem 1rem; }
            .header h1 { font-size: 1.25rem; }
            td, th { padding: 0.6rem 0.75rem; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🗺️ خريطة الموقع XML</h1>
        <p>هذا ملف XML Sitemap يُستخدم لمساعدة محركات البحث في فهرسة محتوى الموقع بشكل أفضل</p>
        <div class="stats">
            <span class="stat-badge">
                📄 عدد الروابط: <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/>
            </span>
            <span class="stat-badge">
                🖼️ عدد الصور: <xsl:value-of select="count(sitemap:urlset/sitemap:url/image:image)"/>
            </span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>الرابط</th>
                <th>الأولوية</th>
                <th>تكرار التحديث</th>
                <th>آخر تعديل</th>
            </tr>
        </thead>
        <tbody>
            <xsl:for-each select="sitemap:urlset/sitemap:url">
                <tr>
                    <td class="row-num"><xsl:value-of select="position()"/></td>
                    <td>
                        <a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                        <xsl:if test="image:image">
                            <br/>
                            <span class="image-badge">🖼️ <xsl:value-of select="count(image:image)"/> صورة</span>
                        </xsl:if>
                    </td>
                    <td>
                        <xsl:choose>
                            <xsl:when test="sitemap:priority &gt;= 0.8">
                                <span class="priority-high"><xsl:value-of select="sitemap:priority"/></span>
                            </xsl:when>
                            <xsl:when test="sitemap:priority &gt;= 0.5">
                                <span class="priority-med"><xsl:value-of select="sitemap:priority"/></span>
                            </xsl:when>
                            <xsl:otherwise>
                                <span class="priority-low"><xsl:value-of select="sitemap:priority"/></span>
                            </xsl:otherwise>
                        </xsl:choose>
                    </td>
                    <td class="changefreq"><xsl:value-of select="sitemap:changefreq"/></td>
                    <td class="lastmod"><xsl:value-of select="sitemap:lastmod"/></td>
                </tr>
            </xsl:for-each>
        </tbody>
    </table>

    <div class="footer">
        تم إنشاء خريطة الموقع تلقائياً • XML Sitemap
    </div>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
