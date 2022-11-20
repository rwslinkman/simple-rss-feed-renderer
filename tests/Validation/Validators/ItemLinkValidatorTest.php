<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemCommentsValidator;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemLinkValidator;
use PHPUnit\Framework\TestCase;

class ItemLinkValidatorTest extends TestCase
{
    function testGivenNoLink_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemLinkValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidLink_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $item->setLink("https://some-site.org/my-item");
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyLink_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setLink("");
        $validator = new ItemLinkValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Link of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesLink_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setLink("   ");
        $validator = new ItemLinkValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Link of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenInvalidLink_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setLink("notfound");
        $validator = new ItemLinkValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Link of RSS item 0 must be a valid URL", $result->getErrorMessage());
    }
}
