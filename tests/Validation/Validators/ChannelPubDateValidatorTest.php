<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelPubDateValidator;
use PHPUnit\Framework\TestCase;

class ChannelPubDateValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoPubDate_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelPubDateValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidPubDate_whenValidate_thenShouldReturnValid() {
        $testDate = new DateTime();
        $feed = $this->buildRssFeedChannelWithPubDate($testDate->format(DateTimeInterface::RSS));
        $validator = new ChannelPubDateValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyPubDate_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithPubDate("");
        $validator = new ChannelPubDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("pubDate cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesPubDate_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithPubDate("   ");
        $validator = new ChannelPubDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("pubDate cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenWronglyFormattedPubDate_whenValidate_thenShouldReturnInvalid() {
        $testDate = new DateTime();
        $feed = $this->buildRssFeedChannelWithPubDate($testDate->format(DateTimeInterface::ISO8601));
        $validator = new ChannelPubDateValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("pubDate must be formatted according to RSS datetime format", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithPubDate($pubDate): RssFeed
    {
        $feed = $this->buildRssFeedChannel();
        $feed->getChannel()->setPubDate($pubDate);
        return $feed;
    }
}
