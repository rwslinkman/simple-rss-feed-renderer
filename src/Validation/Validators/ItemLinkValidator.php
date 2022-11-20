<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemLinkValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $link = $candidate->getLink();
        if($link === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($link)) {
            return ValidationResult::invalid("Link of RSS item $itemIndex cannot be empty when provided");
        }
        if(!BasicValidations::isUrlValid($link)) {
            return ValidationResult::invalid("Link of RSS item $itemIndex must be a valid URL");
        }

        return ValidationResult::ok();
    }
}