<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object\Decorator;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannel;
use SimpleXMLElement;

class ChannelDecorator implements ObjectDecorator
{
    private RssChannel $source;

    /**
     * @param RssChannel $source
     */
    public function __construct(RssChannel $source)
    {
        $this->source = $source;
    }

    public function decorate(SimpleXMLElement $element): void {
        $element->addChild("title", $this->source->getTitle());
        $element->addChild("link", $this->source->getLink());
        $element->addChild("description", $this->source->getDescription());

        $channelAtom = $element->addChild("atom:atom:link"); //add atom node
        $channelAtom->addAttribute("href", $this->source->getLink()); //add atom node attribute
        $channelAtom->addAttribute("rel", "self");
        $channelAtom->addAttribute("type", "application/rss+xml");

        if($this->source->getLanguage() != null) {
            $element->addChild("language", $this->source->getLanguage());
        }
        if($this->source->getCopyright() != null) {
            $element->addChild("copyright", $this->source->getCopyright());
        }
        if($this->source->getManagingEditor() != null) {
            $element->addChild("managingEditor", $this->source->getManagingEditor());
        }
        if($this->source->getWebMaster() != null) {
            $element->addChild("webMaster", $this->source->getWebMaster());
        }
        if($this->source->getPubDate() != null) {
            $element->addChild("pubDate", $this->source->getPubDate());
        }
        if($this->source->getLastBuildDate() != null) {
            $element->addChild("lastBuildDate", $this->source->getLastBuildDate());
        }
        if($this->source->getCategory() != null) {
            $element->addChild("category", $this->source->getCategory());
        }
        if($this->source->getGenerator() != null) {
            $element->addChild("generator", $this->source->getGenerator());
        }
        if($this->source->getDocs() != null) {
            $element->addChild("docs", $this->source->getDocs());
        }
        if($this->source->getTtl() != null) {
            $element->addChild("ttl", $this->source->getTtl());
        }
        if($this->source->getImage() != null) {
            $rssChannelImage = $element->addChild("image");
            $imageDecorator = new ChannelImageDecorator($this->source->getImage());
            $imageDecorator->decorate($rssChannelImage);
        }
        if($this->source->getSkipHours() !== null) {
            $channelSkipHoursElement = $element->addChild("skipHours");
            foreach($this->source->getSkipHours() as $skipHour) {
                $channelSkipHoursElement->addChild("hour", $skipHour);
            }
        }
        if($this->source->getSkipDays() !== null) {
            $channelSkipDaysElement = $element->addChild("skipDays");
            foreach($this->source->getSkipDays() as $skipDay) {
                $channelSkipDaysElement->addChild("day", $skipDay);
            }
        }
    }
}