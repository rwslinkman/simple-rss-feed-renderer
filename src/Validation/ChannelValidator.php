<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;

interface ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult;
}