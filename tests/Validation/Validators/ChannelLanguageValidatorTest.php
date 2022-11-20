<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLanguageValidator;
use PHPUnit\Framework\TestCase;

class ChannelLanguageValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoLanguage_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
    }

    function testGivenDutchLanguage_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithLanguage("nl-nl");
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
    }

    function testGivenInvalidLanguage_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithLanguage("java-kotlin");
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Language 'java-kotlin' is not a valid language", $result->getErrorMessage());
    }

    function testGivenRandomWord_whenValidate_thenShouldReturnInvalid() {
        $feed = $this->buildRssFeedChannelWithLanguage("someValue");
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Language 'someValue' is not a valid language", $result->getErrorMessage());
    }

    private function buildRssFeedChannelWithLanguage($language): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->withChannelLanguage($language)
            ->build();
    }
}
