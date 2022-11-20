<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemMinimalValidator;
use PHPUnit\Framework\TestCase;

class ItemMinimalValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenItemWithTitleAndDescription_whenValidate_thenShouldReturnValid() {
        $item = $this->buildRssItem("TestTitle", "TestDescription");
        $validator = new ItemMinimalValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenItemWithTitleOnly_whenValidate_thenShouldReturnValid() {
        $item = $this->buildRssItem("TestTitle");
        $validator = new ItemMinimalValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenItemWithDescriptionOnly_whenValidate_thenShouldReturnValid() {
        $item = $this->buildRssItem(null, "TestDescription");
        $validator = new ItemMinimalValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenItemWithoutTitleAndDescription_whenValidate_thenShouldReturnValid() {
        $item = $this->buildRssItem();
        $validator = new ItemMinimalValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("RSS item 0 must have either a title or description", $result->getErrorMessage());
    }


}
