<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object\Decorator;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssAttributedProperty;
use SimpleXMLElement;

class AttributedPropertyDecorator
{
    private RssAttributedProperty $source;

    /**
     * @param RssAttributedProperty $source
     */
    public function __construct(RssAttributedProperty $source)
    {
        $this->source = $source;
    }

    public function decorate(SimpleXMLElement $guidElement)
    {
        if($this->source->getValue() !== null) {
            $guidElement[0] = $this->source->getValue();
        }
        foreach($this->source->getAttributeMap() as $attributeName => $attributeValue) {
            $decoratedValue = $this->convertAttributeValue($attributeValue);
            $guidElement->addAttribute($attributeName, $decoratedValue);
        }
    }

    private function convertAttributeValue($attributeValue) {
        $decoratedValue = $attributeValue;
        if(!is_string($attributeValue)) {
            $decoratedValue = var_export($attributeValue, true);
        }
        return $decoratedValue;
    }
}