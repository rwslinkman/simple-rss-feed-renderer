<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelSkipDaysValidator implements ChannelValidator
{
    private array $validSkipDayOptions = array(
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday"
    );

    function validate(RssFeed $candidate): ValidationResult
    {
        $skipDays = $candidate->getChannel()->getSkipDays();
        if($skipDays === null) {
            return ValidationResult::ok();
        }

        if(count($skipDays) === 0) {
            return ValidationResult::invalid("The skipDays property of the RSS channel cannot be empty when provided");
        }

        if(BasicValidations::doesArrayHaveDuplicates($skipDays)) {
            return ValidationResult::invalid("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)");
        }

        foreach($skipDays as $candidateDay) {
            if(!in_array($candidateDay, $this->validSkipDayOptions)) {
                return ValidationResult::invalid("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)");
            }
        }

        return ValidationResult::ok();
    }
}