<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemEnclosureValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $enclosure = $candidate->getEnclosure();
        if($enclosure === null) {
            return ValidationResult::ok();
        }

        if($enclosure->getValue() !== null) {
            return ValidationResult::invalid("The enclosure of RSS item $itemIndex cannot have a value");
        }

        // TODO: Validate attributeMap (url, length, type)
        return ValidationResult::ok();
    }
}