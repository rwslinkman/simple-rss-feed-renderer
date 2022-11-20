<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelGeneratorValidator;
use PHPUnit\Framework\TestCase;

class ChannelGeneratorValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoGenerator_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelGeneratorValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidGenerator_whenValidate_whenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithGenerator("Facts");
        $validator = new ChannelGeneratorValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyGenerator_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithGenerator("");
        $validator = new ChannelGeneratorValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel generator cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesGenerator_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithGenerator("   ");
        $validator = new ChannelGeneratorValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel generator cannot be empty when provided", $result->getErrorMessage());
    }

    /**
     * @return RssFeed
     */
    private function buildRssFeedChannelWithGenerator($generator): RssFeed
    {
        $feed = $this->buildRssFeedChannel();
        $feed->getChannel()->setGenerator($generator);
        return $feed;
    }
}
