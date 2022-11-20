<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use DateTime;
use DOMDocument;
use DOMElement;
use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\SimpleRssFeedRenderer;
use PHPUnit\Framework\TestCase;

class SimpleRssFeedRendererTest extends TestCase
{
    use TestRssFeedBuildingTrait;

    function testGivenFeedWithTwoItems_whenRender_thenShouldReturnValidRssXml() {
        $testDate = new DateTime();
        $feedBuilder = $this->getRssFeedChannelBuilder()
            // TODO: Add attributes
            ->addItem()
                ->withTitle("TestTitle")
                ->withDescription("TestDescription")
                ->withUrl("https://test.com")
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
                ->withUrl("https://test2.com")
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
        // Channel AtomLink validation
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://funfacts.nl/articles", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
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

        // Item 2 validation
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item", 2);
        $this->assertNotNull($itemElement);
        $this->validate($itemElement, "title", "TestTitle2");
        $this->validate($itemElement, "link", "https://test2.com");
        $this->validate($itemElement, "pubDate",  $testDate->format(DATE_RSS));
        $this->validate($itemElement, "description",  "TestDescription2");
    }

    function testGivenFeedWithOneItem_andPrettyPrintConfigured_whenRender_thenShouldReturnValidRssXml() {
        $testDate = new DateTime();
        $feed = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            // TODO: Add attributes
            ->withChannelUrl("https://funfacts.nl/articles")
            ->addItem()
                ->withTitle("TestTitle")
                ->withDescription("TestDescription")
                ->withUrl("https://test.com")
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
        // Channel AtomLink validation
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://funfacts.nl/articles", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));

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
            // TODO: Add attributes
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
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://funfacts.nl/articles", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
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

    private function validate(\DOMNode $parent, $tagName, $expectedValue) {
        // Channel description validation
        $descriptionElement = $this->nodeByTagName($parent->childNodes, $tagName);
        $this->assertNotNull($descriptionElement);
        $this->assertEquals($expectedValue, $descriptionElement->textContent);
    }
}