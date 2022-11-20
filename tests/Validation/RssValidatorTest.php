<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation;

use Exception;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\InvalidRssException;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\RssValidator;
use PHPUnit\Framework\TestCase;

class RssValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenEmptyRssFeed_whenValidate_thenShouldReturnValidResult() {
        $feed = $this->buildRssFeedChannel();
        $validator = new RssValidator();

        try {
            $validator->validate($feed);
            $this->assertTrue(true);
        } catch(Exception) {
            $this->fail("Unexpected validation error thrown!");
        }
    }

    function testGivenInvalidRssFeed_whenValidate_thenShouldThrowException() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelTitle("")->build();
        $validator = new RssValidator();

        try {
            $validator->validate($feed);
            $this->fail("Successfully validated invalid RSS feed!");
        } catch(InvalidRssException $e) {
            $this->assertEquals("The RSS feed contains invalid data", $e->getMessage());
            $errors = $e->getValidationErrors();
            $this->assertNotNull($errors);
            $this->assertCount(1, $errors);
        }
    }
}
