<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLinkValidator;
use PHPUnit\Framework\TestCase;

class ChannelLinkValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenValidLink_whenValidate_thenShouldReturnValid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();

        $validator = new ChannelLinkValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyLink_whenValidate_thenShouldReturnInvalid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->build();
        $validator = new ChannelLinkValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel link cannot be empty", $result->getErrorMessage());
    }

    function testGivenInvalidLink_whenValidate_thenShouldReturnInvalid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("this-is-not-a-link")
            ->build();
        $validator = new ChannelLinkValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel link must be a valid URL", $result->getErrorMessage());
    }
}
