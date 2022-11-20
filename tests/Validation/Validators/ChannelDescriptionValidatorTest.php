<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDescriptionValidator;
use PHPUnit\Framework\TestCase;

class ChannelDescriptionValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenValidDescription_whenValidate_thenShouldReturnValid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();

        $validator = new ChannelDescriptionValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyDescription_whenValidate_thenShouldReturnInvalid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();
        $validator = new ChannelDescriptionValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel description cannot be empty", $result->getErrorMessage());
    }
}
