<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelSkipDaysValidator;
use PHPUnit\Framework\TestCase;

class ChannelSkipDaysValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoSkipDays_whenValidate_thenShouldReturnValidResult() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    /**
     * @dataProvider provideValidSkipDays
     * @return void
     */
    function testGivenValidSkipDays_whenValidate_thenShouldReturnValidResult($validSkipDay) {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array($validSkipDay))->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    /**
     * @dataProvider provideValidSkipDays
     * @return void
     */
    function testGivenValidSkipDaysLower_whenValidate_thenShouldReturnInvalidResult($validSkipDay) {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array(strtolower($validSkipDay)))->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)", $result->getErrorMessage());
    }

    function provideValidSkipDays(): array {
        return array(
            array("Monday"),
            array("Tuesday"),
            array("Wednesday"),
            array("Thursday"),
            array("Friday"),
            array("Saturday"),
            array("Sunday")
        );
    }

    function testGivenEmptySkipDays_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array())->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipDays property of the RSS channel cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenNumericSkipDays_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array(1337))->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)", $result->getErrorMessage());
    }

    function testGivenNonDaySkipDays_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array("Christmas", "National holiday"))->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)", $result->getErrorMessage());
    }

    function testGivenDuplicateSkipDays_whenValidate_thenShouldReturnInvalidResult() {
        $feed = $this->getRssFeedChannelBuilder()->withChannelSkipDays(array("Sunday", "Sunday"))->build();
        $validator = new ChannelSkipDaysValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("The skipDays property of the RSS channel can only contain valid days of the week (Monday-Sunday)", $result->getErrorMessage());
    }
}
