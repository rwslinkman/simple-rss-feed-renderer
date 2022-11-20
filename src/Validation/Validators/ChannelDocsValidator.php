<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelDocsValidator extends ChannelLinkValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        if($candidate->getChannel()->getDocs() === null) {
            return ValidationResult::ok();
        }

        $docs = $candidate->getChannel()->getDocs();
        if(BasicValidations::isNullOrBlank($docs)) {
            return ValidationResult::invalid("Channel docs link cannot be empty");
        }
        if(!BasicValidations::isUrlValid($docs)) {
            return ValidationResult::invalid("Channel docs link must be a valid URL");
        }
        return ValidationResult::ok();
    }
}