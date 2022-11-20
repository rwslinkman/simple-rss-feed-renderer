<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelLanguageValidator implements ChannelValidator
{
    private string $languageRegex = "/^[a-z]{2}-[a-z]{2,}/";

    #[Pure] function validate(RssFeed $candidate): ValidationResult
    {
        $language = $candidate->getChannel()->getLanguage();
        if($language == null) {
            return ValidationResult::ok();
        }

        $matching = preg_grep($this->languageRegex, array($language));
        if(count($matching) == 0) {
            return ValidationResult::invalid("Language '$language' is not a valid language");
        }
        return ValidationResult::ok();
    }
}