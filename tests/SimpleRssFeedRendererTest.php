<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use DateTime;
use DateTimeInterface;
use DOMDocument;
use DOMElement;
use DOMNamedNodeMap;
use DOMNode;
use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\SimpleRssFeedRenderer;
use PHPUnit\Framework\TestCase;

class SimpleRssFeedRendererTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenFeedWithTwoItems_whenRender_thenShouldReturnValidRssXml() {
        $testDate = new DateTime();
        $feedBuilder = $this->getRssFeedChannelBuilder()
            ->withChannelLanguage("nl-nl")
            ->withChannelCopyright("Copyright notice for content in the channel")
            ->withChannelManagingEditor("manager@funfacts.nl")
            ->withChannelWebMaster("webmaster@funfacts.nl")
            ->withChannelPubDate($testDate)
            ->withChannelLastBuildDate($testDate)
            ->withChannelCategory("Facts")
            ->withChannelGenerator()
            ->withChannelDocs("https://funfacts.nl/docs")
            ->withChannelTtl(60)
            ->withChannelSkipHours(array(0,1,2,3,4,5,21,22,23))
            ->withChannelSkipDays(array("Saturday", "Sunday"))
            ->addItem()
                ->withTitle("TestTitle")
                ->withDescription("TestDescription")
                ->withLink("https://test.com")
                ->withAuthor("author@test.com")
                ->withCategory("TestCategory")
                ->withComments("https://test.com/testtitle/comment-section")
                ->withEnclosure("https://test.com/testtitle.mp3", "12216320", "audio/mpeg")
                ->withGuid("https://test.com/testtitle")
                ->withPubDate($testDate)
            ->buildItem()
            ->addImage()
                ->withTitle("TestImage")
                ->withUrl("https://funfacts.nl/logo.png")
                ->withLink("https://funfacts.nl")
                ->withWidth(26)
                ->withHeight(26)
                ->withDescription("FunFacts favicon")
            ->buildImage()
            ->addItem()
                ->withTitle("TestTitle2")
                ->withDescription("TestDescription2")
                ->withLink("https://test2.com")
                ->withGuid("https://test.com/testtitle2", false)
                ->withPubDate($testDate)
            ->buildItem();
        $feed = $feedBuilder->build();
        $renderer = new SimpleRssFeedRenderer();
        $renderer->configureValidateBeforeRender(true);
        $renderer->configurePrettyPrint(false);

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new DOMDocument();
        $resultDOM->loadXML($result);
        // Channel validation
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        // Attributes
        $this->validate($resultChannel, "title", "Fun facts");
        $this->validate($resultChannel, "link", "https://funfacts.nl/articles");
        $this->validate($resultChannel, "description", "Daily fun facts for you to read");
        $this->validateAtomLink($resultChannel);
        $this->validate($resultChannel, "language", "nl-nl");
        $this->validate($resultChannel, "copyright", "Copyright notice for content in the channel");
        $this->validate($resultChannel, "managingEditor", "manager@funfacts.nl");
        $this->validate($resultChannel, "webMaster", "webmaster@funfacts.nl");
        $this->validate($resultChannel, "pubDate", $testDate->format(DateTimeInterface::RSS));
        $this->validate($resultChannel, "lastBuildDate", $testDate->format(DateTimeInterface::RSS));
        $this->validate($resultChannel, "category", "Facts");
        $this->validate($resultChannel, "generator", "rwslinkman/simple-rss-feed-renderer");
        $this->validate($resultChannel, "docs", "https://funfacts.nl/docs");
        $this->validate($resultChannel, "ttl", 60);
        $this->validateWithChildren($resultChannel, "skipDays", "day", array("Saturday", "Sunday"));
        $this->validateWithChildren($resultChannel, "skipHours", "hour", array(0,1,2,3,4,5,21,22,23));
        // Channel image validation
        $imageElement = $this->nodeByTagName($resultChannel->childNodes, "image");
        $this->assertNotNull($imageElement);
        $this->validate($imageElement, "title", "TestImage");
        $this->validate($imageElement, "url", "https://funfacts.nl/logo.png");
        $this->validate($imageElement, "link", "https://funfacts.nl");
        $this->validate($imageElement, "width", 26);
        $this->validate($imageElement, "height", 26);
        $this->validate($imageElement, "description", "FunFacts favicon");

        // Item validation
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item");
        $this->assertNotNull($itemElement);
        $this->validate($itemElement, "title", "TestTitle");
        $this->validate($itemElement, "link", "https://test.com");
        $this->validate($itemElement, "pubDate",  $testDate->format(DATE_RSS));
        $this->validate($itemElement, "description",  "TestDescription");
        $this->validate($itemElement, "author", "author@test.com");
        $this->validate($itemElement, "category", "TestCategory");
        $this->validate($itemElement, "comments", "https://test.com/testtitle/comment-section");
        $this->validate($itemElement, "guid", "https://test.com/testtitle");
        $this->validate($itemElement, "enclosure", null, array("url" => "https://test.com/testtitle.mp3", "length" => 12216320, "type" => "audio/mpeg"));

        // Item 2 validation
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item", 2);
        $this->assertNotNull($itemElement);
        $this->validate($itemElement, "title", "TestTitle2");
        $this->validate($itemElement, "link", "https://test2.com");
        $this->validate($itemElement, "pubDate",  $testDate->format(DATE_RSS));
        $this->validate($itemElement, "description",  "TestDescription2");
        $this->validate($itemElement, "guid", "https://test.com/testtitle2", array("isPermaLink" => "false"));
    }

    function testGivenFeedWithOneItem_andPrettyPrintConfigured_whenRender_thenShouldReturnValidRssXml() {
        $testDate = new DateTime();
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->addItem()
                ->withTitle("TestTitle")
                ->withDescription("TestDescription")
                ->withLink("https://test.com")
                ->withPubDate($testDate)
            ->buildItem()
            ->build();
        $renderer = new SimpleRssFeedRenderer();
        $renderer->configurePrettyPrint(true);

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new DOMDocument();
        $resultDOM->loadXML($result);
        // Channel validation
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        // Attributes
        $this->validate($resultChannel, "title", "Fun facts");
        $this->validate($resultChannel, "link", "https://funfacts.nl/articles");
        $this->validate($resultChannel, "description", "Daily fun facts for you to read");
        $this->validateAtomLink($resultChannel);

        // Item validation
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item");
        $this->assertNotNull($itemElement);
        $this->validate($itemElement, "title", "TestTitle");
        $this->validate($itemElement, "link", "https://test.com");
        $this->validate($itemElement, "pubDate",  $testDate->format(DATE_RSS));
        $this->validate($itemElement, "description",  "TestDescription");
    }

    function testGivenEmptyFeed_whenRender_thenShouldRenderReturnValidRssXml() {
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles")
            ->build();
        $renderer = new SimpleRssFeedRenderer();

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new DOMDocument();
        $resultDOM->loadXML($result);
        // Channel validation
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        // Attributes
        $this->validate($resultChannel, "title", "Fun facts");
        $this->validate($resultChannel, "link", "https://funfacts.nl/articles");
        $this->validate($resultChannel, "description", "Daily fun facts for you to read");
        // Channel AtomLink validation
        $this->validateAtomLink($resultChannel);
    }

    private function nodeByTagName($nodes, $tagName, $nth = 1): ?DOMElement
    {
        $childIndex = 0;
        foreach($nodes as $child) {
            if($child instanceof DOMElement) {
                if($child->tagName === $tagName) {
                    $childIndex += 1;
                    if($childIndex == $nth) {
                        return $child;
                    }
                }
            }
        }
        return null;
    }

    private function validate(DOMNode $parent, $tagName, $expectedValue, $expectedAttributes = array()) {
        // Channel description validation
        $descriptionElement = $this->nodeByTagName($parent->childNodes, $tagName);
        $this->assertNotNull($descriptionElement);
        $this->assertEquals($expectedValue, $descriptionElement->textContent);

        foreach($expectedAttributes as $name => $value) {
            /** @var DOMNamedNodeMap $attrs */
            $attrs = $descriptionElement->attributes;
            $this->assertNotNull($attrs);
            $attr = $attrs->getNamedItem($name);
            $this->assertNotNull($attr);
            $this->assertEquals($value, $attr->textContent);
        }
    }

    /**
     * @param DOMNode|null $resultChannel
     * @return void
     */
    private function validateAtomLink(?DOMNode $resultChannel): void
    {
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://funfacts.nl/articles", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
    }

    private function validateWithChildren(DOMNode $resultChannel, string $tagName, string $childTagName, $expectedValues = array()): void {
        $parentElement = $this->nodeByTagName($resultChannel->childNodes, $tagName);
        $this->assertNotNull($parentElement);
        foreach($expectedValues as $i => $expectation) {
            $childElement = $this->nodeByTagName($parentElement->childNodes, $childTagName, $i + 1);
            $this->assertNotNull($childElement);
            $this->assertEquals($expectation, $childElement->textContent);
        }
    }
}