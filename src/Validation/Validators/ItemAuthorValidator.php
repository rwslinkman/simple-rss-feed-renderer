<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemAuthorValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $author = $candidate->getAuthor();
        if($author === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($author)) {
            return ValidationResult::invalid("Author of RSS item $itemIndex cannot be empty when provided");
        }

        if (filter_var($author, FILTER_VALIDATE_EMAIL) === false) {
            return ValidationResult::invalid("Author of RSS item $itemIndex has to be a valid e-mail address");
        }

        return ValidationResult::ok();
    }
}