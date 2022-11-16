<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

use SimpleXMLElement;

class RssItem
{
    private string $title;
    private string $url;
    private string $description;
    private string $pubDate;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    /**
     * @param string $pubDate
     */
    public function setPubDate(string $pubDate): void
    {
        $this->pubDate = $pubDate;
    }

    public function decorate(SimpleXMLElement $rssItem)
    {
        $rssItem->addChild("title", $this->getTitle());
        $rssItem->addChild("link", $this->getUrl());
        $rssItem->addChild("pubDate", $this->getPubDate());
        $rssItem->addChild("description", $this->getDescription());
    }
}