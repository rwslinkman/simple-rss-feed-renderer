<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemDescriptionValidator;
use PHPUnit\Framework\TestCase;

class ItemDescriptionValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoDescription_whenValidate_ThenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemDescriptionValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyDescription_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setDescription("");
        $validator = new ItemDescriptionValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Description of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesDescription_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setDescription("    ");
        $validator = new ItemDescriptionValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Description of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }
}
