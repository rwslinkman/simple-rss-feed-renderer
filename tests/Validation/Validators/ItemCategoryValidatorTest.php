<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemCategoryValidator;
use PHPUnit\Framework\TestCase;

class ItemCategoryValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoCategory_whenValidate_ThenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemCategoryValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyCategory_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setCategory("");
        $validator = new ItemCategoryValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Category of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesCategory_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setCategory("    ");
        $validator = new ItemCategoryValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Category of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }
}
