<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelCategoryValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $category = $candidate->getChannel()->getCategory();
        if($category === null) {
            return ValidationResult::ok();
        }

        if(trim($category) === '') {
            return ValidationResult::invalid("Channel category cannot be empty when provided");
        }
        return ValidationResult::ok();
    }
}