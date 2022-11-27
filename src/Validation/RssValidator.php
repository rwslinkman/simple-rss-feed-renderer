<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelCategoryValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelCopyrightValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDescriptionValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDocsValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelGeneratorValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelImageValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLanguageValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLastBuildDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLinkValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelManagingEditorValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelPubDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTitleValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTtlValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelWebMasterValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemAuthorValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemCategoryValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemCommentsValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemDescriptionValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemEnclosureValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemGuidValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemLinkValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemMinimalValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemPubDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemTitleValidator;

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

    public function __construct() {
        $this->validations[] = new ChannelTitleValidator();
        $this->validations[] = new ChannelLinkValidator();
        $this->validations[] = new ChannelDescriptionValidator();
        $this->validations[] = new ChannelLanguageValidator();
        $this->validations[] = new ChannelCopyrightValidator();
        $this->validations[] = new ChannelManagingEditorValidator();
        $this->validations[] = new ChannelWebMasterValidator();
        $this->validations[] = new ChannelPubDateValidator();
        $this->validations[] = new ChannelLastBuildDateValidator();
        $this->validations[] = new ChannelCategoryValidator();
        $this->validations[] = new ChannelGeneratorValidator();
        $this->validations[] = new ChannelDocsValidator();
        $this->validations[] = new ChannelTtlValidator();
        $this->validations[] = new ChannelImageValidator();
        // Item validations
        $this->itemValidations[] = new ItemMinimalValidator();
        $this->itemValidations[] = new ItemTitleValidator();
        $this->itemValidations[] = new ItemLinkValidator();
        $this->itemValidations[] = new ItemDescriptionValidator();
        $this->itemValidations[] = new ItemAuthorValidator();
        $this->itemValidations[] = new ItemCategoryValidator();
        $this->itemValidations[] = new ItemGuidValidator();
        $this->itemValidations[] = new ItemEnclosureValidator();
        $this->itemValidations[] = new ItemCommentsValidator();
        $this->itemValidations[] = new ItemPubDateValidator();
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