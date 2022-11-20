<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemMinimalValidator implements ItemValidator
{
    public function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $isTitleEmpty = BasicValidations::isNullOrBlank($candidate->getTitle());
        $isDescrEmpty = BasicValidations::isNullOrBlank($candidate->getDescription());
        if($isTitleEmpty && $isDescrEmpty) {
            return ValidationResult::invalid("RSS item $itemIndex must have either a title or description");
        }
        return ValidationResult::ok();
    }
}