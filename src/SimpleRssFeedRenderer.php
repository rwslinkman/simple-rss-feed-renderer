<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use SimpleXMLElement;

class SimpleRssFeedRenderer implements FeedRendererInterface
{
    const RSS_FEED_DECLARATION = "<rss xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:atom=\"http://www.w3.org/2005/Atom\"></rss>";

    private bool $prettyPrintEnabled = false;

    function render(RssFeed $feed): string
    {
        $rss = new SimpleXMLElement(self::RSS_FEED_DECLARATION);
        $rss->addAttribute("version", "2.0");

        foreach($feed->getChannels() as $channel) {
            $rssChannel = $rss->addChild("channel");
            $channel->decoreate($rssChannel);

            // foreach item
            foreach($channel->getItems() as $item) {
                $rssItem = $rssChannel->addChild("item");
                $item->decorate($rssItem);
            }
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
}