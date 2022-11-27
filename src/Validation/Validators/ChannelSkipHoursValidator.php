<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelSkipHoursValidator implements ChannelValidator
{
    private array $validSkipHourOptions;

    public function __construct()
    {
        $this->validSkipHourOptions = array();
        for($i = 0; $i < 24; $i++) {
            $this->validSkipHourOptions[] = $i;
        }
    }

    function validate(RssFeed $candidate): ValidationResult
    {
        $skipHours = $candidate->getChannel()->getSkipHours();
        if($skipHours === null) {
            return ValidationResult::ok();
        }

        if(count($skipHours) === 0) {
            return ValidationResult::invalid("The skipHours property of the RSS channel cannot be empty when provided");
        }

        if(BasicValidations::doesArrayHaveDuplicates($skipHours)) {
            return ValidationResult::invalid("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23");
        }

        foreach($skipHours as $candidateHour) {
            if(!is_int($candidateHour) || !in_array($candidateHour, $this->validSkipHourOptions)) {
                return ValidationResult::invalid("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23");
            }
        }

        return ValidationResult::ok();
    }
}