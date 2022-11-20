<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

class ValidationResult
{
    private bool $isValid;
    private ?string $errorMessage;

    public static function ok(): ValidationResult {
        return new ValidationResult(true);
    }

    public static function invalid(string $error): ValidationResult {
        return new ValidationResult(false, $error);
    }

    /**
     * @param bool $isValid
     * @param string|null $errorMessage
     */
    public function __construct(bool $isValid, string $errorMessage = null)
    {
        $this->isValid = $isValid;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}