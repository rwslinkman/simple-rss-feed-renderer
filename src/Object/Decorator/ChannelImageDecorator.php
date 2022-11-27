<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object\Decorator;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannelImage;
use SimpleXMLElement;

class ChannelImageDecorator implements ObjectDecorator
{
    private RssChannelImage $source;

    /**
     * @param RssChannelImage $source
     */
    public function __construct(RssChannelImage $source)
    {
        $this->source = $source;
    }

    public function decorate(SimpleXMLElement $element): void {
        $element->addChild("url", $this->source->getUrl());
        $element->addChild("title", $this->source->getTitle());
        $element->addChild("link", $this->source->getLink());
        if($this->source->getWidth() != null) {
            $element->addChild("width", $this->source->getWidth());
        }
        if($this->source->getHeight() != null) {
            $element->addChild("height", $this->source->getHeight());
        }
        if($this->source->getDescription() != null) {
            $element->addChild("description", $this->source->getDescription());
        }
    }
}