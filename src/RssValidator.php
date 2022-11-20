<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use JetBrains\PhpStorm\Pure;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\InvalidRssException;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ItemValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationReport;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelCopyrightValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDescriptionValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLanguageValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLastBuildDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLinkValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelManagingEditorValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelPubDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTitleValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelWebMasterValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemMinimalValidator;

class RssValidator
{
    /**
     * @var array|ChannelValidator[]
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
        $this->validations[] = new ChannelLanguageValidator();
        $this->validations[] = new ChannelCopyrightValidator();
        $this->validations[] = new ChannelManagingEditorValidator();
        $this->validations[] = new ChannelWebMasterValidator();
        $this->validations[] = new ChannelPubDateValidator();
        $this->validations[] = new ChannelLastBuildDateValidator();
        // TODO: Validator for $category
        // TODO: Validator for $generator
        // TODO: Validator for $docs
        // TODO: Validator for $image
        $this->itemValidations[] = new ItemMinimalValidator();
        // TODO: Validators for item attributes
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