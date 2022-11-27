<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssAttributedProperty;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemGuidValidator;
use PHPUnit\Framework\TestCase;

class ItemGuidValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoGuid_whenValidate_thenShouldReturnValidResult() {
        $testItem = $this->buildRssItem("TestItem");
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyGuid_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("");
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Value of property 'guid' in RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesGuid_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("     ");
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Value of property 'guid' in RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenValidGuidWithoutPermalinkAttribute_whenValidate_thenShouldReturnValidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes");
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenGuidWithValidPermalinkTrueAttribute_whenValidate_thenShouldReturnValidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("isPermaLink" => true));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenGuidWithValidPermalinkFalseAttribute_whenValidate_thenShouldReturnValidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("isPermaLink" => false));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenGuidWithStringPermalinkAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("isPermaLink" => "wrong"));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("isPermaLink attribute of 'guid' of RSS item 0 must be boolean", $result->getErrorMessage());
    }

    function testGivenGuidWithNumberPermalinkAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("isPermaLink" => 1337));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("isPermaLink attribute of 'guid' of RSS item 0 must be boolean", $result->getErrorMessage());
    }

    function testGivenGuidWithExtraAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("isPermaLink" => true, "somethingElse" => "not allowed"));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Property 'guid' of RSS item 0 can only have isPermaLink attribute", $result->getErrorMessage());
    }

    function testGivenGuidWithOtherAttribute_whenValidate_thenShouldReturnInvalidResult() {
        $testItem = $this->buildRssItemWithGuid("some guid value, any string goes", array("somethingElse" => "not allowed"));
        $validator = new ItemGuidValidator();

        $result = $validator->validate($testItem, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Property 'guid' of RSS item 0 can only have isPermaLink attribute", $result->getErrorMessage());
    }

    /**
     * @param string|null $value
     * @param array|null $attributeMap
     * @return RssItem
     */
    private function buildRssItemWithGuid(string $value = null, array $attributeMap = null): RssItem
    {
        $guidProperty = new RssAttributedProperty();
        $guidProperty->setValue($value);
        if($attributeMap !== null) {
            $guidProperty->setAttributeMap($attributeMap);
        }
        $testItem = $this->buildRssItem("TestItem");
        $testItem->setGuid($guidProperty);
        return $testItem;
    }
}
