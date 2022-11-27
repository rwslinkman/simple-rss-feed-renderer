<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemGuidValidator implements ItemValidator
{
    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $guid = $candidate->getGuid();
        if($guid === null) {
            return ValidationResult::ok();
        }

        if(BasicValidations::isNullOrBlank($guid->getValue())) {
            return ValidationResult::invalid("Value of property 'guid' in RSS item $itemIndex cannot be empty when provided");
        }


        $attributes = $guid->getAttributeMap();
        $attrNames = array_keys($attributes);
        if(count($attrNames) > 0) {
            if(in_array("isPermalink", $attrNames)) {
                $isPermalinkAttr = $attributes['isPermalink'];
                if(!is_bool($isPermalinkAttr)) {
                    return ValidationResult::invalid("isPermalink attribute of 'guid' of RSS item $itemIndex must be boolean");
                }
            }

            $remainingAttrNames = array_diff($attrNames, array("isPermalink"));
            if(count($remainingAttrNames) > 0) {
                return ValidationResult::invalid("Property 'guid' of RSS item $itemIndex can only have isPermalink attribute");
            }
        }
        return ValidationResult::ok();
    }
}