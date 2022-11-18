<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelLanguageValidator;
use PHPUnit\Framework\TestCase;

class ChannelLanguageValidatorTest extends TestCase
{
    function testGivenNoLanguage_whenValidate_thenShouldReturnValid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
    }

    function testGivenDutchLanguage_whenValidate_thenShouldReturnValid() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->withChannelLanguage("nl-nl")
            ->build();
        $validator = new ChannelLanguageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
    }
}
