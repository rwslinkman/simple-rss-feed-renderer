<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTitleValidator;
use PHPUnit\Framework\TestCase;

class ChannelTitleValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenValidTitle_whenValidate_thenShouldReturnValid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();

        $validator = new ChannelTitleValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyTitle_whenValidate_thenShouldReturnInvalid() {
        $feed = (new FeedBuilder())
            ->withChannelDescription("Fun facts")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();
        $validator = new ChannelTitleValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel title cannot be empty", $result->getErrorMessage());
    }
}
