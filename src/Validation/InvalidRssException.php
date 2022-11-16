<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use RuntimeException;

class InvalidRssException extends RuntimeException
{
    private array $validationErrors;

    /**
     * @param array $validationErrors
     */
    public function __construct(array $validationErrors)
    {
        parent::__construct("The RSS feed contains invalid data");
        $this->validationErrors = $validationErrors;
    }

    /**
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}