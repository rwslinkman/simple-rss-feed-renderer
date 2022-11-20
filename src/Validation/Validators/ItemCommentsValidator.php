<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemCommentsValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $comments = $candidate->getComments();
        if($comments === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($comments)) {
            return ValidationResult::invalid("Comments of RSS item $itemIndex cannot be empty when provided");
        }
        if(!BasicValidations::isUrlValid($comments)) {
            return ValidationResult::invalid("Comments of RSS item $itemIndex must be a valid URL of a page for comments relating to the item");
        }

        return ValidationResult::ok();
    }
}