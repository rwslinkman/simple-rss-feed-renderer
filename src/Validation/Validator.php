<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;

interface Validator
{
    function validate(RssFeed $candidate): ValidationResult;
}