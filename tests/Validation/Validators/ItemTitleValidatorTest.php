<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemTitleValidator;
use PHPUnit\Framework\TestCase;

class ItemTitleValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoTitle_whenValidate_ThenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemTitleValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyTitle_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setTitle("");
        $validator = new ItemTitleValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Title of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesTitle_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setTitle("    ");
        $validator = new ItemTitleValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Title of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }
}
