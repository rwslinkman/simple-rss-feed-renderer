<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelWebMasterValidator;
use PHPUnit\Framework\TestCase;

class ChannelWebMasterValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoWebMaster_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelWebMasterValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidWebMaster_whenValidte_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithWebMaster("editor@channel.com");
        $validator = new ChannelWebMasterValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyWebMaster_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithWebMaster("");
        $validator = new ChannelWebMasterValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Webmaster cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesWebMaster_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithWebMaster("   ");
        $validator = new ChannelWebMasterValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Webmaster cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenNonEmailWebMaster_whenValidte_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithWebMaster("someone's name");
        $validator = new ChannelWebMasterValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Value for channel's webmaster must be an e-mail address", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithWebMaster($webMaster): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->withChannelWebMaster($webMaster)
            ->build();
    }
}
