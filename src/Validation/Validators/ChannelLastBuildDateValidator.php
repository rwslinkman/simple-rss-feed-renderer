<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelLastBuildDateValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $lastBuildDate = $candidate->getChannel()->getLastBuildDate();
        if($lastBuildDate === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($lastBuildDate)) {
            return ValidationResult::invalid("lastBuildDate cannot be empty when provided");
        }

        if(!BasicValidations::isDateFormatValid($lastBuildDate)) {
            return ValidationResult::invalid("lastBuildDate must be formatted according to RSS datetime format");
        }
        return ValidationResult::ok();
    }
}