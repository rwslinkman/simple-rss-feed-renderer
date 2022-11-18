<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;

interface ChannelValidator
{
    function validate(RssFeed $candidate): ValidationResult;
}