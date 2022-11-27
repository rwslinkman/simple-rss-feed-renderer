<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ItemEnclosureValidator implements ItemValidator
{

    function validate(RssItem $candidate, int $itemIndex): ValidationResult
    {
        $enclosure = $candidate->getEnclosure();
        if($enclosure === null) {
            return ValidationResult::ok();
        }

        if($enclosure->getValue() !== null) {
            return ValidationResult::invalid("The enclosure of RSS item $itemIndex cannot have a value");
        }

        $attributes = $enclosure->getAttributeMap();
        $attrNames = array_keys($attributes);
        if(count($attrNames) > 0) {
            $remainingAttrNames = $attrNames;
            if(!in_array("url", $remainingAttrNames)) {
                return ValidationResult::invalid("The enclosure 'url' attribute of RSS item $itemIndex has to be a valid URL");
            }
            else {
                $url = $attributes["url"];
                if(BasicValidations::isNullOrBlank($url) || !BasicValidations::isUrlValid($url)) {
                    return ValidationResult::invalid("The enclosure 'url' attribute of RSS item $itemIndex has to be a valid URL");
                }
                $remainingAttrNames = array_diff($remainingAttrNames, array("url"));
            }

            if(!in_array("length", $remainingAttrNames)) {
                return ValidationResult::invalid("The enclosure 'length' attribute of RSS item $itemIndex has to be a positive number");
            } else {
                $length = $attributes["length"];
                if(!is_numeric($length) || $length <= 0) {
                    return ValidationResult::invalid("The enclosure 'length' attribute of RSS item $itemIndex has to be a positive number");
                }
                $remainingAttrNames = array_diff($remainingAttrNames, array("length"));
            }

            if(!in_array("type", $attrNames)) {
                return ValidationResult::invalid("The enclosure 'type' attribute of RSS item $itemIndex has to be a valid mime type");
            } else {
                $type = $attributes["type"];
                if(BasicValidations::isNullOrBlank($type)) {
                    return ValidationResult::invalid("The enclosure 'type' attribute of RSS item $itemIndex has to be a valid mime type");
                }
                $remainingAttrNames = array_diff($remainingAttrNames, array("type"));
            }

            if(count($remainingAttrNames) > 0) {
                return ValidationResult::invalid("The enclosure of RSS item $itemIndex can only have url, length and type attributes");
            }
        }
        return ValidationResult::ok();
    }
}