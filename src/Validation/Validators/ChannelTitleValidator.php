<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validator;

class ChannelTitleValidator implements Validator
{
    #[Pure] public function validate(RssFeed $candidate): ValidationResult {
        $title = $candidate->getChannel()->getTitle();
        if(BasicValidations::isNullOrBlank($title)) {
            return ValidationResult::invalid("Channel title cannot be empty");
        }
        return ValidationResult::ok();
    }
}