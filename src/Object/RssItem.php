<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

use SimpleXMLElement;

class RssItem
{
    // Required attributes
    private string $title;
    private string $link;
    private string $description;
    // Optional attributes
    private ?string $author;
    private ?string $category;
    private ?string $comments;
//    private object $enclosure;
//    private object $guid;
    private ?string $pubDate;
//    private object $source;

    public function decorate(SimpleXMLElement $rssItem)
    {
        $rssItem->addChild("title", $this->getTitle());
        $rssItem->addChild("link", $this->getLink());
        $rssItem->addChild("description", $this->getDescription());
        $rssItem->addChild("pubDate", $this->getPubDate());
    }

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
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
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
}