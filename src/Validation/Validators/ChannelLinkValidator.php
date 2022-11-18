<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;

class ChannelLinkValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $link = $candidate->getChannel()->getLink();
        if(BasicValidations::isNullOrBlank($link)) {
            return ValidationResult::invalid("RSS channel link cannot be empty");
        }
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return ValidationResult::invalid("RSS channel link must be a valid URL");
        }
        return ValidationResult::ok();
    }
}