<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelLanguageValidator implements \nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $language = $candidate->getChannel()->getLanguage();
        if($language == null) {
            return ValidationResult::ok();
        }

        $primaryLanguage = substr($language, 0, 2);
        $secondaryLanguage = substr($language, 3, 5);
        $dash = substr(2, 3);
        echo $primaryLanguage;
        echo $secondaryLanguage;
        echo $dash;
    }
}