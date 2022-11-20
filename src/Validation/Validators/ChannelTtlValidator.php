<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelTtlValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $ttl = $candidate->getChannel()->getTtl();
        if($ttl === null || $ttl > 0) {
            return ValidationResult::ok();
        }
        return ValidationResult::invalid("Channel time-to-live must be a positive number");
    }
}