<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelGeneratorValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $generator = $candidate->getChannel()->getGenerator();
        if($generator === null) {
            return ValidationResult::ok();
        }

        if(trim($generator) === '') {
            return ValidationResult::invalid("Channel generator cannot be empty when provided");
        }
        return ValidationResult::ok();
    }
}