<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemCommentsValidator;
use PHPUnit\Framework\TestCase;

class ItemCommentsValidatorTest extends TestCase
{
    function testGivenNoComments_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidComments_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $item->setComments("https://some-site.org/my-item");
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyComments_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setComments("");
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Comments of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesComments_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setComments("   ");
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Comments of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenInvalidComments_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setComments("notfound");
        $validator = new ItemCommentsValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Comments of RSS item 0 must be a valid URL of a page for comments relating to the item", $result->getErrorMessage());
    }
}
