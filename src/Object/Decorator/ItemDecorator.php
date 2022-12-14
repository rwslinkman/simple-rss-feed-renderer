<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object\Decorator;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use SimpleXMLElement;

class ItemDecorator implements ObjectDecorator
{
    private RssItem $source;

    /**
     * @param RssItem $source
     */
    public function __construct(RssItem $source)
    {
        $this->source = $source;
    }

    public function decorate(SimpleXMLElement $element): void
    {
        if($this->source->getTitle() !== null) {
            $element->addChild("title", $this->source->getTitle());
        }
        if($this->source->getLink() !== null){
            $element->addChild("link", $this->source->getLink());
        }
        if($this->source->getDescription() !== null) {
            $element->addChild("description", $this->source->getDescription());
        }
        if($this->source->getAuthor() !== null) {
            $element->addChild("author", $this->source->getAuthor());
        }
        if($this->source->getCategory() !== null) {
            $element->addChild("category", $this->source->getCategory());
        }
        if($this->source->getComments() !== null) {
            $element->addChild("comments", $this->source->getComments());
        }
        if($this->source->getEnclosure() !== null) {
            $enclosureElement = $element->addChild("enclosure");
            $propertyDecorator = new AttributedPropertyDecorator($this->source->getEnclosure());
            $propertyDecorator->decorate($enclosureElement);
        }
        if($this->source->getGuid() != null) {
            $guidElement = $element->addChild("guid");
            $propertyDecorator = new AttributedPropertyDecorator($this->source->getGuid());
            $propertyDecorator->decorate($guidElement);
        }
        if($this->source->getPubDate() !== null) {
            $element->addChild("pubDate", $this->source->getPubDate());
        }
    }
}