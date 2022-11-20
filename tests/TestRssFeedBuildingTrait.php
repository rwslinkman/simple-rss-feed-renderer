<?php

namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;

trait TestRssFeedBuildingTrait
{
    function buildRssFeedChannel(): RssFeed
    {
        return $this->getRssFeedChannelBuilder()
            ->build();
    }

    function getRssFeedChannelBuilder(): FeedBuilder
    {
        return (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles");
    }

    function buildRssItem($title = null, $description = null): RssItem {
        $item = new RssItem();
        if($title != null)
            $item->setTitle($title);
        if($description != null)
            $item->setDescription($description);
        return $item;
    }
}