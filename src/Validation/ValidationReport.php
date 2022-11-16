<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

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

    public function addResult(ValidationResult $result) {
        $this->results[] = $result;
    }

    public function hasInvalidResults(): bool {
        foreach($this->results as $result) {
            if(!$result->isValid()) {
                return true;
            }
        }
        return false;
    }

    public function getResults(): array {
        return $this->results;
    }

    public function getInvalidResults() {
        $invalid = array();
        foreach($this->results as $result) {
            if (!$result->isValid()) {
                $invalid[] = $result;
            }
        }
        return $invalid;
    }
}