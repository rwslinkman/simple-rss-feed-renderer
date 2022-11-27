<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

use SimpleXMLElement;

class RssAttributedProperty
{
    private string $value = "";
    private array $attributeMap = array();

    public function decorate(SimpleXMLElement $guidElement)
    {
        $guidElement[0] = $this->value;
        foreach($this->getAttributeMap() as $attributeName => $attributeValue) {
            $guidElement->addAttribute($attributeName, var_export($attributeValue, true));
        }
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getAttributeMap(): array
    {
        return $this->attributeMap;
    }

    /**
     * @param array $attributeMap
     */
    public function setAttributeMap(array $attributeMap): void
    {
        $this->attributeMap = $attributeMap;
    }
}