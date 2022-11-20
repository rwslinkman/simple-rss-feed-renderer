<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemCategoryValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $category = $candidate->getCategory();
        if($category === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($category)) {
            return ValidationResult::invalid("Category of RSS item $itemIndex cannot be empty when provided");
        }
        return ValidationResult::ok();
    }
}