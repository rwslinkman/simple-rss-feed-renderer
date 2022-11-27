<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

use SimpleXMLElement;

class RssItem
{
    // Optional attributes
    private ?string $title = null;
    private ?string $link = null;
    private ?string $description = null;
    private ?string $author = null;
    private ?string $category = null;
    private ?string $comments = null;
//    private object $enclosure;
    private ?RssAttributedProperty $guid = null;
    private ?string $pubDate = null;
//    private object $source;

    public function decorate(SimpleXMLElement $rssItem)
    {
        $rssItem->addChild("title", $this->getTitle());
        $rssItem->addChild("link", $this->getLink());
        $rssItem->addChild("description", $this->getDescription());

        if($this->author !== null) {
            $rssItem->addChild("author", $this->getAuthor());
        }
        if($this->category !== null) {
            $rssItem->addChild("category", $this->getCategory());
        }
        if($this->comments !== null) {
            $rssItem->addChild("comments", $this->getComments());
        }
        if($this->guid != null) {
            $guidElement = $rssItem->addChild("guid");
            $this->getGuid()->decorate($guidElement);
        }

        $rssItem->addChild("pubDate", $this->getPubDate());
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     */
    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param string|null $comments
     */
    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return RssAttributedProperty|null
     */
    public function getGuid(): ?RssAttributedProperty
    {
        return $this->guid;
    }

    /**
     * @param RssAttributedProperty|null $guid
     */
    public function setGuid(?RssAttributedProperty $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * @return string|null
     */
    public function getPubDate(): ?string
    {
        return $this->pubDate;
    }

    /**
     * @param string|null $pubDate
     */
    public function setPubDate(?string $pubDate): void
    {
        $this->pubDate = $pubDate;
    }
}