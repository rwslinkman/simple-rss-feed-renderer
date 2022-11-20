<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelDocsValidator;
use PHPUnit\Framework\TestCase;

class ChannelDocsValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoDocs_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelDocsValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidDocs_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithDocs("https://some-site.org/docs");

        $validator = new ChannelDocsValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyDocs_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithDocs("");
        $validator = new ChannelDocsValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel docs link cannot be empty", $result->getErrorMessage());
    }

    function testGivenSpacesDocs_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithDocs("   ");
        $validator = new ChannelDocsValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel docs link cannot be empty", $result->getErrorMessage());
    }

    function testGivenInvalidDocs_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithDocs("notfound");
        $validator = new ChannelDocsValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel docs link must be a valid URL", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithDocs($docs): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->withChannelDocs($docs)
            ->build();
    }
}
