<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemTitleValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $title = $candidate->getTitle();
        if($title === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($title)) {
            return ValidationResult::invalid("Title of RSS item $itemIndex cannot be empty when provided");
        }
        return ValidationResult::ok();
    }
}