<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use JetBrains\PhpStorm\Pure;

class ValidationReport
{
    /**
     * @var array|ValidationResult[]
     */
    private array $results;

    public function __construct()
    {
        $this->results = array();
    }

    public function addResult(ValidationResult $result)
    {
        $this->results[] = $result;
    }

    #[Pure] public function hasInvalidResults(): bool
    {
        foreach ($this->results as $result) {
            if (!$result->isValid()) {
                return true;
            }
        }
        return false;
    }

    #[Pure] public function getInvalidResults(): array
    {
        $invalid = array();
        foreach ($this->results as $result) {
            if (!$result->isValid()) {
                $invalid[] = $result;
            }
        }
        return $invalid;
    }
}