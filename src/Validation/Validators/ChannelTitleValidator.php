<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validator;

class ChannelTitleValidator implements Validator
{
    public function validate(RssFeed $candidate): ValidationResult {
        $title = $candidate->getChannel()->getTitle();
        if($title === null || trim($title) === '') {
            return ValidationResult::invalid("Channel title cannot be empty");
        }
        return ValidationResult::ok();
    }
}