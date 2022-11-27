<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelSkipHoursValidator;
use PHPUnit\Framework\TestCase;

class ChannelSkipHoursValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoSkipHours_whenValidate_thenShouldReturnValidResult() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidSkipHours_whenValidate_thenShouldReturnValidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array(0,1,2,3,4,5))->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptySkipHours_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array())->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipHours property of the RSS channel cannot be empty when provided", $result->getErrorMessage());
    }


    function testGivenNegativeSkipHours_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array(1,2,-3,4,5))->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23", $result->getErrorMessage());
    }

    function testGivenTooLargeSkipHours_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array(24,1337))->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23", $result->getErrorMessage());
    }

    function testGivenNonNumericSkipHours_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array(6,"twelve"))->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23", $result->getErrorMessage());
    }

    function testGivenDuplicateSkipHours_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipHours(array(6,6))->build();
        $validator = new ChannelSkipHoursValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("All values in RSS channel's element 'skipHours' should be numbers between 0 and 23", $result->getErrorMessage());
    }
}
