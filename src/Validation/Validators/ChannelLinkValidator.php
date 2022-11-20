<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelLinkValidator implements ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult
    {
        $link = $candidate->getChannel()->getLink();
        if(BasicValidations::isNullOrBlank($link)) {
            return ValidationResult::invalid("Channel link cannot be empty");
        }
        if(!BasicValidations::isUrlValid($link)) {
            return ValidationResult::invalid("Channel link must be a valid URL");
        }
        return ValidationResult::ok();
    }
}