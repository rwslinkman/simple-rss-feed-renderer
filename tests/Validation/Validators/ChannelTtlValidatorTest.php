<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelTtlValidator;
use PHPUnit\Framework\TestCase;

class ChannelTtlValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoTtl_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelTtlValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidTtl_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithTtl(60);
        $validator = new ChannelTtlValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenNegativeTtl_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithTtl(-60);
        $validator = new ChannelTtlValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel time-to-live must be a positive number", $result->getErrorMessage());
    }

    function testGivenZeroTtl_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithTtl(0);
        $validator = new ChannelTtlValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Channel time-to-live must be a positive number", $result->getErrorMessage());
    }

    /**
     * @param int $ttl
     * @return RssFeed
     */
    private function buildRssFeedChannelWithTtl(int $ttl): RssFeed
    {
        return $this->getRssFeedChannelBuilder()->withChannelTtl($ttl)->build();
    }
}
