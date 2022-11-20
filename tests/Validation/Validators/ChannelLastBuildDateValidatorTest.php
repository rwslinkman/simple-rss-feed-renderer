<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLastBuildDateValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelPubDateValidator;
use PHPUnit\Framework\TestCase;

class ChannelLastBuildDateValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoLastBuildDate_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelLastBuildDateValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidLastBuildDate_whenValidate_thenShouldReturnValid() {
        $testDate = new DateTime();
        $feed = $this->buildRssFeedChannelWithLastBuildDate($testDate->format(DateTimeInterface::RSS));
        $validator = new ChannelLastBuildDateValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyLastBuildDate_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithLastBuildDate("");
        $validator = new ChannelLastBuildDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("lastBuildDate cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesLastBuildDate_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithLastBuildDate("   ");
        $validator = new ChannelLastBuildDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("lastBuildDate cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenWronglyFormattedLastBuildDate_whenValidate_thenShouldReturnInvalid() {
        $testDate = new DateTime();
        $feed = $this->buildRssFeedChannelWithLastBuildDate($testDate->format(DateTimeInterface::ISO8601));
        $validator = new ChannelLastBuildDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("lastBuildDate must be formatted according to RSS datetime format", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithLastBuildDate($lastBuildDate): RssFeed
    {
        $feed = $this->buildRssFeedChannel();
        $feed->getChannel()->setLastBuildDate($lastBuildDate);
        return $feed;
    }
}
