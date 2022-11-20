<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelCopyrightValidator;
use PHPUnit\Framework\TestCase;

class ChannelCopyrightValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoCopyright_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelCopyrightValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidCopyright_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithCopyright("Some copyright statement");
        $validator = new ChannelCopyrightValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyCopyright_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithCopyright("");
        $validator = new ChannelCopyrightValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Copyright cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesCopyright_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithCopyright("   ");
        $validator = new ChannelCopyrightValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Copyright cannot be empty when provided", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithCopyright($copyRight): RssFeed {
        return $this->getRssFeedChannelBuilder()
            ->withChannelCopyright($copyRight)
            ->build();
    }
}
