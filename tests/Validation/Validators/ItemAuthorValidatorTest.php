<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ItemAuthorValidator;
use PHPUnit\Framework\TestCase;

class ItemAuthorValidatorTest extends TestCase
{
    function testGivenNoAuthor_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $validator = new ItemAuthorValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenValidAuthor_whenValidate_thenShouldReturnValid() {
        $item = new RssItem();
        $item->setAuthor("author@company.com");
        $validator = new ItemAuthorValidator();

        $result = $validator->validate($item, 0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenEmptyAuthor_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setAuthor("");
        $validator = new ItemAuthorValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Author of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenSpacesAuthor_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setAuthor("");
        $validator = new ItemAuthorValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Author of RSS item 0 cannot be empty when provided", $result->getErrorMessage());
    }

    function testGivenNonEmailAuthor_whenValidate_thenShouldReturnInvalid() {
        $item = new RssItem();
        $item->setAuthor("not an email");
        $validator = new ItemAuthorValidator();

        $result = $validator->validate($item, 0);

        $this->assertFalse($result->isValid());
        $this->assertEquals("Author of RSS item 0 has to be a valid e-mail address", $result->getErrorMessage());
    }
}
