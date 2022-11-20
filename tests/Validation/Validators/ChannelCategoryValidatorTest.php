<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelCategoryValidator;
use PHPUnit\Framework\TestCase;

class ChannelCategoryValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoCategory_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelCategoryValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidCategory_whenValidate_whenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithCategory("Facts");
        $validator = new ChannelCategoryValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyCategory_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithCategory("");
        $validator = new ChannelCategoryValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel category cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesCategory_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithCategory("   ");
        $validator = new ChannelCategoryValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel category cannot be empty when provided", $result->getErrorMessage());
    }

    /**
     * @return RssFeed
     */
    private function buildRssFeedChannelWithCategory($category): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->withChannelCategory($category)
            ->build();
    }
}
