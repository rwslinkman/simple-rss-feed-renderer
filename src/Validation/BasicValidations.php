<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

abstract class BasicValidations
{
    public static function isNullOrBlank($str): bool {
        return $str === null || trim($str) === '';
    }
}