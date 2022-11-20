<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelManagingEditorValidator implements ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult
    {
        $managingEditor = $candidate->getChannel()->getManagingEditor();
        if($managingEditor === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($managingEditor)) {
            return ValidationResult::invalid("Managing editor cannot be empty when provided");
        }
        if (filter_var($managingEditor, FILTER_VALIDATE_EMAIL) === false) {
            return ValidationResult::invalid("Value for channel's managing editor must be an e-mail address");
        }
        return ValidationResult::ok();
    }
}