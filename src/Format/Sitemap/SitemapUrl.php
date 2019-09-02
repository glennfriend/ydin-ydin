<?php

namespace Cor\SitemapNow\Library\Format;

class SitemapUrl
{

    protected $maps = [];

    protected $baseUrl = 'http://localhost';

    protected $priority = '0.8';

    protected $changefreq = 'monthly';

    /**
     * @param $url
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
    }

    /**
     * @param $priority
     */
    public function setBasePriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param $str
     */
    public function setBaseChangefreq($changefreq)
    {
        $this->changefreq = $changefreq;
    }

    /**
     * @param $path
     * @param array $options
     */
    public function add($path, array $options=[])
    {
        $priority = $this->priority;
        $changefreq = $this->changefreq;
        $lastmod = date('c');

        if (isset($options['priority'])) {
            $priority = $options['priority'];
        }

        if (isset($options['changefreq'])) {
            $changefreq = $options['changefreq'];
        }

        if (isset($options['lastmod'])) {
            $lastmod = $options['lastmod'];
        }

        $this->maps[] = [
            'path'       => $path,
            'priority'   => $priority,
            'changefreq' => $changefreq,
            'lastmod'    => $lastmod,
        ];
    }

    /**
     * 沒有資料就 "不會" redner
     *
     * @return string
     */
    public function render()
    {
        if (! $this->maps) {
            return '';
        }

        return $this->alwaysRender();
    }

    /**
     * 即使沒有資料, 也要 render
     *
     * @return string
     */
    public function renderAlways()
    {
        $content = '';

        foreach ($this->maps as $map) {

            $path = '/' . ltrim($map['path'], '/');

            $content .= "    <url>\n";
            $content .= "        <loc>{$this->baseUrl}{$path}</loc>\n";
            $content .= "        <lastmod>{$map['lastmod']}</lastmod>\n";

            if ($map['changefreq']) {
                $content .= "        <changefreq>{$map['changefreq']}</changefreq>\n";
            }
            if ($map['priority']) {
                $content .= "        <priority>{$map['priority']}</priority>\n";
            }

            $content .= "    </url>\n";
        }

        return $this->applyLayout($content);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    protected function applyLayout($content)
    {
        return <<<"EOD"
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
{$content}
</urlset>
EOD;
    }

}

/*

    [Example]

        use SitemapNow\Library\Format\SitemapFactory;


        public function __construct(SitemapFactory $sitemapFactory)
        {
            $this->sitemapFactory = $sitemapFactory;
        }

        public function index()
        {
            $map = $this->sitemapFactory->buildSitemapUrl();
            $map->setBaseUrl('https://localhost/people-search');
            $map->setBaseChangefreq('monthly');
            $map->setBasePriority('1.0');

            $map->add('/product/book/happy-king');
            $map->add('/product/book/baby-food');
            $map->add('/product/clothes/yellow');
            $map->add('/product/clothes/red');

            echo $map->render();
        }

*/