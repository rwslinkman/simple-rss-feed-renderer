<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Validation\RssValidator;
use SimpleXMLElement;

class SimpleRssFeedRenderer implements FeedRendererInterface
{
    const RSS_FEED_DECLARATION = "<rss xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:atom=\"http://www.w3.org/2005/Atom\"></rss>";

    private bool $prettyPrintEnabled = false;
    private bool $validateBeforeRender = false;

    function render(RssFeed $feed): string
    {
        if($this->validateBeforeRender) {
            $validator = new RssValidator();
            $validator->validate($feed);
        }
        $feedChannel = $feed->getChannel();

        // Create XML objects to render
        $rss = new SimpleXMLElement(self::RSS_FEED_DECLARATION);
        $rss->addAttribute("version", "2.0");

        $rssChannel = $rss->addChild("channel");
        $feedChannel->decorate($rssChannel);

        // foreach item in channel
        foreach($feedChannel->getItems() as $item) {
            $rssItem = $rssChannel->addChild("item");
            $item->decorate($rssItem);
        }

        if($this->prettyPrintEnabled) {
            return $this->prettyPrint($rss);
        }
        return $rss->asXML();
    }

    private function prettyPrint(SimpleXMLElement $rssXml): string {
        $dom = dom_import_simplexml($rssXml)->ownerDocument;
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    function configurePrettyPrint(bool $enabled): void
    {
        $this->prettyPrintEnabled = $enabled;
    }

    function configureValidateBeforeRender(bool $enabled): void
    {
        $this->validateBeforeRender = $enabled;
    }
}