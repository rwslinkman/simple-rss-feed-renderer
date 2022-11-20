<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelManagingEditorValidator;
use PHPUnit\Framework\TestCase;

class ChannelManagingEditorValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoManagingEditor_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelManagingEditorValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidManagingEditor_whenValidte_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithManagingEditor("editor@channel.com");
        $validator = new ChannelManagingEditorValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyManagingEditor_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithManagingEditor("");
        $validator = new ChannelManagingEditorValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Managing editor cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesManagingEditor_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithManagingEditor("   ");
        $validator = new ChannelManagingEditorValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Managing editor cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenNonEmailManagingEditor_whenValidte_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithManagingEditor("someone's name");
        $validator = new ChannelManagingEditorValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Value for channel's managing editor must be an e-mail address", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithManagingEditor($managingEditor): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->withChannelManagingEditor($managingEditor)
            ->build();
    }
}
