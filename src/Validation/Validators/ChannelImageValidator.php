<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\BasicValidations;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ChannelValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\ValidationResult;

class ChannelImageValidator implements ChannelValidator
{

    function validate(RssFeed $candidate): ValidationResult
    {
        $channelImage = $candidate->getChannel()->getImage();
        if($channelImage === null) {
            return ValidationResult::ok();
        }

        // Required attribute URL
        $imageUrl = $channelImage->getUrl();
        if(BasicValidations::isNullOrBlank($imageUrl)) {
            return ValidationResult::invalid("The channel image URL cannot be empty when the image is provided");
        }
        if(!BasicValidations::isUrlValid($imageUrl)) {
            return ValidationResult::invalid("The channel image URL must be a valid link to a GIF, JPEG or PNG image");
        }
        $extFound = $this->validateExtensions($imageUrl);
        if(!$extFound) {
            return ValidationResult::invalid("The channel image URL must be a valid link to a GIF, JPEG or PNG image");
        }

        // Required attribute Title
        $imageTitle = $channelImage->getTitle();
        if(BasicValidations::isNullOrBlank($imageTitle)) {
            return ValidationResult::invalid("The channel image title cannot be empty when the image is provided");
        }

        // Required attribute Link
        $imageLink = $channelImage->getLink();
        if(BasicValidations::isNullOrBlank($imageLink)) {
            return ValidationResult::invalid("The channel image link cannot be empty when provided");
        }
        if(!BasicValidations::isUrlValid($imageLink)) {
            return ValidationResult::invalid("The channel image link must be a valid URL to the page where the image is displayed");
        }

        // Optional attribute width
        $imageWidth = $channelImage->getWidth();
        if($imageWidth !== null) {
            if($imageWidth <= 0) {
                return ValidationResult::invalid("The channel image width must be a positive number");
            }
            if($imageWidth > 144) {
                return ValidationResult::invalid("The channel image has a maximum width of 144");
            }
        }

        // Optional attribute height
        $imageHeight = $channelImage->getHeight();
        if($imageHeight !== null) {
            if($imageHeight <= 0) {
                return ValidationResult::invalid("The channel image height must be a positive number");
            }
            if($imageHeight > 400) {
                return ValidationResult::invalid("The channel image has a maximum height of 400");
            }
        }

        // Optional attribute description
        $imageDescription = $channelImage->getDescription();
        if($imageDescription !== null) {
            if(BasicValidations::isNullOrBlank($imageDescription)) {
                return ValidationResult::invalid("The channel image description cannot be empty when provided");
            }
        }

        return ValidationResult::ok();
    }

    /**
     * @param string $imageUrl
     * @return bool
     */
    private function validateExtensions(string $imageUrl): bool
    {
        $validExtensions = array('png', 'jpg', 'jpeg', 'gif');
        $extFound = false;
        foreach ($validExtensions as $ext) {
            if (str_ends_with($imageUrl, $ext)) {
                $extFound = true;
                break;
            }
        }
        return $extFound;
    }
}