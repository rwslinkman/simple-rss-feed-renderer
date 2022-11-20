<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemDescriptionValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $description= $candidate->getDescription();
        if($description === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($description)) {
            return ValidationResult::invalid("Description of RSS item $itemIndex cannot be empty when provided");
        }
        return ValidationResult::ok();
    }
}