<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use SimpleXMLElement;

class RssChannel
{
    private string $title;
    private string $description;
    private string $url;
    private array $items = array();


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
    public function getUrl(): string
    {
        return $this->url;
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
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function addItem(RssItem $item)
    {
        $this->items[] = $item;
    }

    /** @return RssItem[] */
    public function getItems(): array {
        return $this->items;
    }

    public function decoreate(SimpleXMLElement $rssChannel)
    {
        $rssChannel->addChild("title", $this->getTitle());
        $rssChannel->addChild("link", $this->getUrl());
        $rssChannel->addChild("description", $this->getDescription());

        $channelAtom = $rssChannel->addChild("atom:atom:link"); //add atom node
        $channelAtom->addAttribute("href", "https://rwslinkman.nl"); //add atom node attribute
        $channelAtom->addAttribute("rel", "self");
        $channelAtom->addAttribute("type", "application/rss+xml");
    }
}