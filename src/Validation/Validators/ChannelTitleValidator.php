<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;

class ChannelTitleValidator implements ChannelValidator
{
    #[Pure] public function validate(RssFeed $candidate): ValidationResult {
        $title = $candidate->getChannel()->getTitle();
        if(BasicValidations::isNullOrBlank($title)) {
            return ValidationResult::invalid("Channel title cannot be empty");
        }
        return ValidationResult::ok();
    }
}