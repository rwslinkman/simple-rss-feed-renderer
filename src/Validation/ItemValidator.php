<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;

interface ItemValidator
{
    function validate(RssItem $candidate, int $itemIndex): ValidationResult;
}