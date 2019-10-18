<?php
declare(strict_types=1);
namespace Ydin\Format\Sitemap;


class SitemapFactory
{

    public function __construct(SitemapIndex $sitemapIndex, SitemapUrl $sitemapUrl)
    {
        $this->sitemapIndex = $sitemapIndex;
        $this->sitemapUrl = $sitemapUrl;
    }

    /**
     * 用來產生 sitemap index
     * 這些 url 會連到另外的 sitemap xml
     *
     * @return SitemapIndex
     */
    public function buildSitemapIndex()
    {
        return clone $this->sitemapIndex;
    }

    /**
     * 用來產生 讓 browser bot 用來 index 的 url
     *
     * @return SitemapUrl
     */
    public function buildSitemapUrl()
    {
        return clone $this->sitemapUrl;
    }

}