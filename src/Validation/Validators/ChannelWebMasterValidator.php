<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelWebMasterValidator implements ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult
    {
        $webMaster = $candidate->getChannel()->getWebMaster();
        if($webMaster === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($webMaster)) {
            return ValidationResult::invalid("Webmaster cannot be empty when provided");
        }
        if (filter_var($webMaster, FILTER_VALIDATE_EMAIL) === false) {
            return ValidationResult::invalid("Value for channel's webmaster must be an e-mail address");
        }
        return ValidationResult::ok();
    }
}