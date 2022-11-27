<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Object\Decorator;

use SimpleXMLElement;

interface ObjectDecorator
{
    public function decorate(SimpleXMLElement $element): void;
}