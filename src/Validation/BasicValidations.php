<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use DateTime;
use DateTimeInterface;

abstract class BasicValidations
{
    public static function isNullOrBlank($str): bool {
        return $str === null || trim($str) === '';
    }

    public static function isDateFormatValid($candiDate): bool {
        $created = DateTime::createFromFormat(DateTimeInterface::RSS, $candiDate);
        return $created && $created->format(DateTimeInterface::RSS) === $candiDate;
    }

    public static function isUrlValid($candidate): bool {
        return !(filter_var($candidate, FILTER_VALIDATE_URL) === false);
    }

    public static function doesArrayHaveDuplicates($candidate): bool {
        return count($candidate) !== count(array_unique($candidate));
    }
}