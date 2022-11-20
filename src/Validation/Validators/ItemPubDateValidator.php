<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemPubDateValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $pubDate = $candidate->getPubDate();
        if($pubDate === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($pubDate)) {
            return ValidationResult::invalid("PubDate of RSS item $itemIndex cannot be empty when provided");
        }

        if(!BasicValidations::isDateFormatValid($pubDate)) {
            return ValidationResult::invalid("PubDate of RSS item $itemIndex must be formatted according to RSS datetime format");
        }
        return ValidationResult::ok();
    }
}