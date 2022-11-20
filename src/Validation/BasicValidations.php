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
}