<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;

class ChannelDescriptionValidator implements ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult
    {
        $description = $candidate->getChannel()->getDescription();
        if(BasicValidations::isNullOrBlank($description)) {
            return ValidationResult::invalid("RSS channel description cannot be empty");
        }
        return ValidationResult::ok();
    }
}