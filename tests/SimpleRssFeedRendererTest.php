<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use nl\rwslinkman\SimpleRssFeedRenderer\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\SimpleRssFeedRenderer;
use PHPUnit\Framework\TestCase;

class SimpleRssFeedRendererTest extends TestCase
{
    function testGivenFeedWithOneItem_whenRender_thenShouldReturnValidRssXml() {

        $feedBuilder = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles");
        $feedBuilder
            ->addItem()
            ->withTitle("TestTitle")
            ->withDescription("TestDescription")
            ->withUrl("https://test.com")
            ->withPubDate(new \DateTime())
            ->buildItem();
        $feed = $feedBuilder->build();
        $renderer = new SimpleRssFeedRenderer();

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new \DOMDocument();
        $resultDOM->loadXML($result);
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        $titleElement = $this->nodeByTagName($resultChannel->childNodes, "title");
        $this->assertNotNull($titleElement);
        $this->assertEquals("Fun facts", $titleElement->textContent);
        $linkElement = $this->nodeByTagName($resultChannel->childNodes, "link");
        $this->assertNotNull($linkElement);
        $this->assertEquals("https://funfacts.nl/articles", $linkElement->textContent);
        $descriptionElement = $this->nodeByTagName($resultChannel->childNodes, "description");
        $this->assertNotNull($descriptionElement);
        $this->assertEquals("Daily fun facts for you to read", $descriptionElement->textContent);
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://rwslinkman.nl", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item");
        $this->assertNotNull($itemElement);
        $itemTitleElement = $this->nodeByTagName($itemElement->childNodes, "title");
        $this->assertNotNull($itemTitleElement);
        $this->assertEquals("TestTitle", $itemTitleElement->textContent);
        $itemLinkElement = $this->nodeByTagName($itemElement->childNodes, "link");
        $this->assertNotNull($itemLinkElement);
        $this->assertEquals("https://test.com", $itemLinkElement->textContent);
        $itemPubDateElement = $this->nodeByTagName($itemElement->childNodes, "pubDate");
        $this->assertNotNull($itemPubDateElement);
        $this->assertNotEquals("", $itemPubDateElement->textContent);
        $itemDescriptionElement = $this->nodeByTagName($itemElement->childNodes, "description");
        $this->assertNotNull($itemDescriptionElement);
        $this->assertEquals("TestDescription", $itemDescriptionElement->textContent);
    }

    function testGivenFeedWithOneItem_andPrettyPrintConfigured_whenRender_thenShouldReturnValidRssXml() {

        $feedBuilder = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles");
        $feedBuilder
            ->addItem()
            ->withTitle("TestTitle")
            ->withDescription("TestDescription")
            ->withUrl("https://test.com")
            ->withPubDate(new \DateTime())
            ->buildItem();
        $feed = $feedBuilder->build();
        $renderer = new SimpleRssFeedRenderer();
        $renderer->configurePrettyPrint(true);

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new \DOMDocument();
        $resultDOM->loadXML($result);
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        $titleElement = $this->nodeByTagName($resultChannel->childNodes, "title");
        $this->assertNotNull($titleElement);
        $this->assertEquals("Fun facts", $titleElement->textContent);
        $linkElement = $this->nodeByTagName($resultChannel->childNodes, "link");
        $this->assertNotNull($linkElement);
        $this->assertEquals("https://funfacts.nl/articles", $linkElement->textContent);
        $descriptionElement = $this->nodeByTagName($resultChannel->childNodes, "description");
        $this->assertNotNull($descriptionElement);
        $this->assertEquals("Daily fun facts for you to read", $descriptionElement->textContent);
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://rwslinkman.nl", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
        $itemElement = $this->nodeByTagName($resultChannel->childNodes, "item");
        $this->assertNotNull($itemElement);
        $itemTitleElement = $this->nodeByTagName($itemElement->childNodes, "title");
        $this->assertNotNull($itemTitleElement);
        $this->assertEquals("TestTitle", $itemTitleElement->textContent);
        $itemLinkElement = $this->nodeByTagName($itemElement->childNodes, "link");
        $this->assertNotNull($itemLinkElement);
        $this->assertEquals("https://test.com", $itemLinkElement->textContent);
        $itemPubDateElement = $this->nodeByTagName($itemElement->childNodes, "pubDate");
        $this->assertNotNull($itemPubDateElement);
        $this->assertNotEquals("", $itemPubDateElement->textContent);
        $itemDescriptionElement = $this->nodeByTagName($itemElement->childNodes, "description");
        $this->assertNotNull($itemDescriptionElement);
        $this->assertEquals("TestDescription", $itemDescriptionElement->textContent);
    }

    function testGivenEmptyFeed_whenRender_thenShouldRenderReturnValidRssXml() {

        $feedBuilder = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles");
        $feed = $feedBuilder->build();
        $renderer = new SimpleRssFeedRenderer();

        $result = $renderer->render($feed);

        $this->assertNotNull($result);
        $resultDOM = new \DOMDocument();
        $resultDOM->loadXML($result);
        $resultChannels = $resultDOM->getElementsByTagName("channel");
        $this->assertEquals(1, $resultChannels->count());
        $resultChannel = $resultChannels->item(0);
        $this->assertNotNull($resultChannel);
        $titleElement = $this->nodeByTagName($resultChannel->childNodes, "title");
        $this->assertNotNull($titleElement);
        $this->assertEquals("Fun facts", $titleElement->textContent);
        $linkElement = $this->nodeByTagName($resultChannel->childNodes, "link");
        $this->assertNotNull($linkElement);
        $this->assertEquals("https://funfacts.nl/articles", $linkElement->textContent);
        $descriptionElement = $this->nodeByTagName($resultChannel->childNodes, "description");
        $this->assertNotNull($descriptionElement);
        $this->assertEquals("Daily fun facts for you to read", $descriptionElement->textContent);
        $atomLinkElement = $this->nodeByTagName($resultChannel->childNodes, "atom:link");
        $this->assertNotNull($atomLinkElement);
        $this->assertEquals("https://rwslinkman.nl", $atomLinkElement->getAttribute("href"));
        $this->assertEquals("self", $atomLinkElement->getAttribute("rel"));
        $this->assertEquals("application/rss+xml", $atomLinkElement->getAttribute("type"));
    }

    private function nodeByTagName($nodes, $tagName): ?\DOMElement
    {
        foreach($nodes as $child) {
            if($child instanceof \DOMElement) {
                if($child->tagName === $tagName) {
                    return $child;
                }
            }
        }
        return null;
    }
}