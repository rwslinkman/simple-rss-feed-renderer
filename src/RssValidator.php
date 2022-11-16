<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\InvalidRssException;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationReport;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDescriptionValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLinkValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTitleValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemDataValidator;

class RssValidator
{
    /**
     * @var array|Validator[]
     */
    private array $validations = array();

    #[Pure] public function __construct() {
        $this->validations[] = new ChannelTitleValidator();
        $this->validations[] = new ChannelLinkValidator();
        $this->validations[] = new ChannelDescriptionValidator();
        $this->validations[] = new ItemDataValidator();
    }

    /**
     * @throws InvalidRssException
     */
    public function validate(RssFeed $candidate) {
        $report = new ValidationReport();
        foreach($this->validations as $validator) {
            $result = $validator->validate($candidate);
            $report->addResult($result);
        }

        if($report->hasInvalidResults()) {
            $invalidResults = $report->getInvalidResults();
            throw new InvalidRssException($invalidResults);
        }
    }
}