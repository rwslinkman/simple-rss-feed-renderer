<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\InvalidRssException;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationReport;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDescriptionValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLinkValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTitleValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemMinimalValidator;

class RssValidator
{
    /**
     * @var array|Validator[]
     */
    private array $validations = array();

    /**
     * @var array|ItemValidator[]
     */
    private array $itemValidations = array();

    #[Pure] public function __construct() {
        $this->validations[] = new ChannelTitleValidator();
        $this->validations[] = new ChannelLinkValidator();
        $this->validations[] = new ChannelDescriptionValidator();
        $this->itemValidations[] = new ItemMinimalValidator();
    }

    /**
     * @throws InvalidRssException
     */
    public function validate(RssFeed $candidate) {
        $report = new ValidationReport();
        // Metadata validator
        foreach($this->validations as $validator) {
            $result = $validator->validate($candidate);
            $report->addResult($result);
        }
        // Item validation
        foreach($candidate->getChannel()->getItems() as $index => $itemCandidate) {
            foreach($this->itemValidations as $validator) {
                $result = $validator->validate($itemCandidate, $index);
                $report->addResult($result);
            }
        }

        // Conclusion
        if($report->hasInvalidResults()) {
            $invalidResults = $report->getInvalidResults();
            throw new InvalidRssException($invalidResults);
        }
    }
}