<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validator;

class ItemDataValidator implements Validator
{
    public function validate(RssFeed $candidate): ValidationResult {
        $candidateItems = $candidate->getChannel()->getItems();
    }
}