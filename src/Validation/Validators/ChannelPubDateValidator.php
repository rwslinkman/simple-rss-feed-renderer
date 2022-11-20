<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelPubDateValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $pubDate = $candidate->getChannel()->getPubDate();
        if($pubDate === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($pubDate)) {
            return ValidationResult::invalid("pubDate cannot be empty when provided");
        }

        if(!BasicValidations::isDateFormatValid($pubDate)) {
            return ValidationResult::invalid("pubDate must be formatted according to RSS datetime format");
        }
        return ValidationResult::ok();
    }
}