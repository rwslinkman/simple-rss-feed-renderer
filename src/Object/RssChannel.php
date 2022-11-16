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
    private string $language;
    private string $copyright;
    private string $managingEditor;

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

    public function decorate(SimpleXMLElement $rssChannel)
    {
        $rssChannel->addChild("title", $this->getTitle());
        $rssChannel->addChild("link", $this->getLink());
        $rssChannel->addChild("description", $this->getDescription());

        $channelAtom = $rssChannel->addChild("atom:atom:link"); //add atom node
        $channelAtom->addAttribute("href", "https://rwslinkman.nl"); //add atom node attribute
        $channelAtom->addAttribute("rel", "self");
        $channelAtom->addAttribute("type", "application/rss+xml");
    }
}