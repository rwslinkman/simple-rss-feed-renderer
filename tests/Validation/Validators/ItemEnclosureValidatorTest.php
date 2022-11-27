<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssAttributedProperty;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemEnclosureValidator;
use PHPUnit\Framework\TestCase;

class ItemEnclosureValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoEnclosure_whenValidate_thenShouldReturnValidResult() {
        $item = $this->buildRssItem("TestItem");
        $validator = new ItemEnclosureValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidEnclosure_whenValidate_thenShouldReturnValidResult() {
        $item = $this->buildRssItemWithEnclosure(null, "https://test.com/media.png", 100, "image/png");
        $validator = new ItemEnclosureValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEnclosureWithExtraAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $item = $this->buildRssItem("TestItem");
        $enclosure = new RssAttributedProperty();
        $enclosure->setAttributeMap(array(
            "url" => "https://test.com/media.png",
            "length" => 100,
            "type" => "image/png",
            "extraElement" => "not allowed"
        ));
        $item->setEnclosure($enclosure);
        $validator = new ItemEnclosureValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The enclosure of RSS item 0 can only have url, length and type attributes", $result->getErrorMessage());
    }

    function testGivenEnclosureWithOtherAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $item = $this->buildRssItem("TestItem");
        $enclosure = new RssAttributedProperty();
        $enclosure->setAttributeMap(array(
            "otherElement" => "not allowed"
        ));
        $item->setEnclosure($enclosure);
        $validator = new ItemEnclosureValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider provideInvalidEnclosureData
     * @param $enclosureValue
     * @param $url
     * @param $length
     * @param $type
     * @param $expectedError
     * @return void
     */
    function testGivenInvalidEnclosureParams_whenValidate_thenShouldReturnInvalidResult($enclosureValue, $url, $length, $type, $expectedError) {
        $item = $this->buildRssItemWithEnclosure($enclosureValue, $url, $length, $type);
        $validator = new ItemEnclosureValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals($expectedError, $result->getErrorMessage());
    }

    function provideInvalidEnclosureData(): array
    {
        return array(
            // value
            array("invalid", "https://test.com/media.jpeg", 100, "image/jpeg", "The enclosure of RSS item 0 cannot have a value"),
            array(1337, "https://test.com/media.jpeg", 100, "image/jpeg", "The enclosure of RSS item 0 cannot have a value"),
            // url
            array(null, null, 100, "image/jpeg", "The enclosure 'url' attribute of RSS item 0 has to be a valid URL"),
            array(null, "", 100, "image/jpeg", "The enclosure 'url' attribute of RSS item 0 has to be a valid URL"),
            array(null, "    ", 100, "image/jpeg", "The enclosure 'url' attribute of RSS item 0 has to be a valid URL"),
            array(null, "not-an-url", 100, "image/jpeg", "The enclosure 'url' attribute of RSS item 0 has to be a valid URL"),
            // length
            array(null, "https://test.com/media.jpeg", null, "image/jpeg", "The enclosure 'length' attribute of RSS item 0 has to be a positive number"),
            array(null, "https://test.com/media.jpeg", 0, "image/jpeg", "The enclosure 'length' attribute of RSS item 0 has to be a positive number"),
            array(null, "https://test.com/media.jpeg", -1, "image/jpeg", "The enclosure 'length' attribute of RSS item 0 has to be a positive number"),
            // type
            array(null, "https://test.com/media.jpeg", 100, null, "The enclosure 'type' attribute of RSS item 0 has to be a valid mime type"),
            array(null, "https://test.com/media.jpeg", 100, "", "The enclosure 'type' attribute of RSS item 0 has to be a valid mime type"),
            array(null, "https://test.com/media.jpeg", 100, "   ", "The enclosure 'type' attribute of RSS item 0 has to be a valid mime type"),
        );
    }

    /**
     * @param $enclosureValue
     * @param $url
     * @param $length
     * @param $type
     * @return RssItem
     */
    private function buildRssItemWithEnclosure($enclosureValue, $url, $length, $type): RssItem
    {
        $item = $this->buildRssItem("TestItem");
        $enclosure = new RssAttributedProperty();
        if ($enclosureValue !== null) {
            $enclosure->setValue($enclosureValue);
        }
        $attributes = array();
        if ($url !== null) {
            $attributes['url'] = $url;
        }
        if ($length !== null) {
            $attributes['length'] = $length;
        }
        if ($type !== null) {
            $attributes['type'] = $type;
        }
        if (count($attributes) > 0) {
            $enclosure->setAttributeMap($attributes);
        }
        $item->setEnclosure($enclosure);
        return $item;
    }
}
