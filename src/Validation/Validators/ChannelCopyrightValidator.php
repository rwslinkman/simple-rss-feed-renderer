<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelCopyrightValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $copyright = $candidate->getChannel()->getCopyright();
        if($copyright === null) {
            return ValidationResult::ok();
        }

        if(trim($copyright) === "") {
            return ValidationResult::invalid("Copyright cannot be empty when provided");
        }

        return ValidationResult::ok();
    }
}