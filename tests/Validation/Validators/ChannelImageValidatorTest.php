<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests\Validation\Validators;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannelImage;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Tests\TestRssFeedBuildingTrait;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\Validators\ChannelImageValidator;
use PHPUnit\Framework\TestCase;

class ChannelImageValidatorTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenNoImage_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannel();
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    /**
     * @dataProvider provideBasicImageExtensions
     * @return void
     */
    function testGivenBasicImage_whenValidate_thenShouldReturnValid($ext) {
        $feed = $this->buildRssFeedChannelWithImage("https://some-url.org/my-image.$ext", "My image", "https://some-url.org");
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function provideBasicImageExtensions(): array {
        return array(
            array("png"),
            array("jpg"),
            array("jpeg"),
            array("gif"),
        );
    }

    function testGivenBasicImageWithWidth_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithImage("https://some-url.org/my-image.png", "My image", "https://some-url.org", 100);
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenBasicImageWithHeight_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithImage("https://some-url.org/my-image.png", "My image", "https://some-url.org", null, 100);
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    function testGivenBasicImageWithDescription_whenValidate_thenShouldReturnValid() {
        $feed = $this->buildRssFeedChannelWithImage("https://some-url.org/my-image.png", "My image", "https://some-url.org", null, null, "This is my image");
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getErrorMessage());
    }

    /**
     * @dataProvider provideInvalidImageProperties
     * @return void
     */
    function testInvalidImageProperties_whenValidate_thenShouldReturnInvalid($url, $title, $link, $width, $height, $description, $expectedError) {
        $feed = $this->buildRssFeedChannelWithImage($url, $title, $link, $width, $height, $description);
        $validator = new ChannelImageValidator();

        $result = $validator->validate($feed);

        $this->assertFalse($result->isValid());
        $this->assertEquals($expectedError, $result->getErrorMessage());
    }

    function provideInvalidImageProperties(): array {
        return array(
            // url 0-4
            array("", "My image", "https://some-url.org", 100, 100, "This is my image", "The channel image URL cannot be empty when the image is provided"),
            array("   ", "My image", "https://some-url.org", 100, 100, "This is my image", "The channel image URL cannot be empty when the image is provided"),
            array("notfound", "My image", "https://some-url.org", 100, 100, "This is my image", "The channel image URL must be a valid link to a GIF, JPEG or PNG image"),
            array("https://some-url.org/image", "My image", "https://some-url.org", 100, 100, "This is my image", "The channel image URL must be a valid link to a GIF, JPEG or PNG image"),
            array("https://some-url.org/image.nzb", "My image", "https://some-url.org", 100, 100, "This is my image", "The channel image URL must be a valid link to a GIF, JPEG or PNG image"),
            // title 5-6
            array("https://some-url.org/image.png", "", "https://some-url.org", 100, 100, "This is my image", "The channel image title cannot be empty when the image is provided"),
            array("https://some-url.org/image.png", "   ", "https://some-url.org", 100, 100, "This is my image", "The channel image title cannot be empty when the image is provided"),
            // link 7-9
            array("https://some-url.org/image.png", "My image", "", 100, 100, "This is my image", "The channel image link cannot be empty when provided"),
            array("https://some-url.org/image.png", "My image", "    ", 100, 100, "This is my image", "The channel image link cannot be empty when provided"),
            array("https://some-url.org/image.png", "My image", "notfound", 100, 100, "This is my image", "The channel image link must be a valid URL to the page where the image is displayed"),
            // width 10-12
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 0, 100, "This is my image", "The channel image width must be a positive number"),
            array("https://some-url.org/image.png", "My image", "https://some-url.org", -1, 100, "This is my image", "The channel image width must be a positive number"),
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 145, 100, "This is my image", "The channel image has a maximum width of 144"),
            // height 13-15
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 100, 0, "This is my image", "The channel image height must be a positive number"),
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 100, -1, "This is my image", "The channel image height must be a positive number"),
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 100, 401, "This is my image", "The channel image has a maximum height of 400"),
            // description 16-17
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 100, 100, "", "The channel image description cannot be empty when provided"),
            array("https://some-url.org/image.png", "My image", "https://some-url.org", 100, 100, "   ", "The channel image description cannot be empty when provided"),
        );
    }

    private function buildRssFeedChannelWithImage($imgUrl, $imgTitle, $imgLink, $imgWidth = null, $imgHeight = null, $imgDescr = null): RssFeed {
        $feed = $this->buildRssFeedChannel();
        $image = new RssChannelImage();
        $image->setUrl($imgUrl);
        $image->setTitle($imgTitle);
        $image->setLink($imgLink);
        $image->setWidth($imgWidth);
        $image->setHeight($imgHeight);
        $image->setDescription($imgDescr);
        $feed->getChannel()->setImage($image);
        return $feed;
    }
}
