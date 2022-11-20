<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelDescriptionValidator implements ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult
    {
        $description = $candidate->getChannel()->getDescription();
        if(BasicValidations::isNullOrBlank($description)) {
            return ValidationResult::invalid("Channel description cannot be empty");
        }
        return ValidationResult::ok();
    }
}