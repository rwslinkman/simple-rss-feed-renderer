<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemPubDateValidator;
use PHPUnit\Framework\TestCase;

class ItemPubDateValidatorTest extends TestCase
{
    function testGivenNoPubDate_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemPubDateValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidPubDate_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $item->setPubDate((new DateTime())->format(DateTimeInterface::RSS));
        $validator = new ItemPubDateValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyPubDate_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setPubDate("");
        $validator = new ItemPubDateValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("PubDate of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesPubDate_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setPubDate("   ");
        $validator = new ItemPubDateValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("PubDate of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenWronglyFormattedPubDate_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setPubDate((new DateTime())->format(DateTimeInterface::ISO8601));
        $validator = new ItemPubDateValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("PubDate of RSS item 0 must be formatted according to RSS datetime format", $result->getErrorMessage());
    }
}
