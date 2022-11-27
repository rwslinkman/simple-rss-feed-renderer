<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

use SimpleXMLElement;

class RssChannel
{
    // https://www.rssboard.org/rss-specification#requiredChannelElements
    private string $title;
    private string $description;
    private string $link;
    private array $items = array();
    // https://www.rssboard.org/rss-specification#optionalChannelElements
    private ?string $language = null;
    private ?string $copyright = null;
    private ?string $managingEditor = null;
    private ?string $webMaster = null;
    private ?string $pubDate = null;
    private ?string $lastBuildDate = null;
    private ?string $category = null;
    private ?string $generator = null;
    private ?string $docs = null;
//    private object $cloud;
    private ?int $ttl = null;
    private ?RssChannelImage $image = null;
//    private string $rating;
//    private object $textInput;
    private ?array $skipHours = null;
    private ?array $skipDays = null;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    /**
     * @param string|null $copyright
     */
    public function setCopyright(?string $copyright): void
    {
        $this->copyright = $copyright;
    }

    /**
     * @return string|null
     */
    public function getManagingEditor(): ?string
    {
        return $this->managingEditor;
    }

    /**
     * @param string|null $managingEditor
     */
    public function setManagingEditor(?string $managingEditor): void
    {
        $this->managingEditor = $managingEditor;
    }

    /**
     * @return string|null
     */
    public function getWebMaster(): ?string
    {
        return $this->webMaster;
    }

    /**
     * @param string|null $webMaster
     */
    public function setWebMaster(?string $webMaster): void
    {
        $this->webMaster = $webMaster;
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

    /**
     * @return string|null
     */
    public function getLastBuildDate(): ?string
    {
        return $this->lastBuildDate;
    }

    /**
     * @param string|null $lastBuildDate
     */
    public function setLastBuildDate(?string $lastBuildDate): void
    {
        $this->lastBuildDate = $lastBuildDate;
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
    public function getGenerator(): ?string
    {
        return $this->generator;
    }

    /**
     * @param string|null $generator
     */
    public function setGenerator(?string $generator): void
    {
        $this->generator = $generator;
    }

    /**
     * @return string|null
     */
    public function getDocs(): ?string
    {
        return $this->docs;
    }

    /**
     * @param string|null $docs
     */
    public function setDocs(?string $docs): void
    {
        $this->docs = $docs;
    }

    /**
     * @return int|null
     */
    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    /**
     * @param int|null $ttl
     */
    public function setTtl(?int $ttl): void
    {
        $this->ttl = $ttl;
    }

    /**
     * @return array|null
     */
    public function getSkipHours(): ?array
    {
        return $this->skipHours;
    }

    /**
     * @param array|null $skipHours
     */
    public function setSkipHours(?array $skipHours): void
    {
        $this->skipHours = $skipHours;
    }

    /**
     * @return array|null
     */
    public function getSkipDays(): ?array
    {
        return $this->skipDays;
    }

    /**
     * @param array|null $skipDays
     */
    public function setSkipDays(?array $skipDays): void
    {
        $this->skipDays = $skipDays;
    }

    /**
     * @return RssChannelImage|null
     */
    public function getImage(): ?RssChannelImage
    {
        return $this->image;
    }

    /**
     * @param RssChannelImage|null $image
     */
    public function setImage(?RssChannelImage $image): void
    {
        $this->image = $image;
    }

    /**
     * @param RssItem $item
     * @return void
     */
    public function addItem(RssItem $item)
    {
        $this->items[] = $item;
    }

    /** @return RssItem[] */
    public function getItems(): array {
        return $this->items;
    }
}