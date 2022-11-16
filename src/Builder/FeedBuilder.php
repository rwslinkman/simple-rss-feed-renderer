<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Builder;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannel;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannelImage;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;
use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;

class FeedBuilder
{
    // Mandatory items
    private string $channelTitle;
    private string $channelDescription;
    private string $channelUrl;
    private array $items;
    // optional items

    public function __construct() {
        $this->channelTitle = "";
        $this->channelDescription = "";
        $this->channelUrl = "";
        $this->items = array();
    }

    public function build(): RssFeed {
        $channel = new RssChannel();
        // Channel metadata
        $channel->setTitle($this->channelTitle);
        $channel->setDescription($this->channelDescription);
        $channel->setLink($this->channelUrl);
        // Add items individually
        foreach($this->items as $item) {
            $channel->addItem($item);
        }
        return new RssFeed($channel);
    }

    public function withChannelTitle(string $channelTitle): static
    {
        $this->channelTitle = $channelTitle;
        return $this;
    }

    public function withChannelDescription(string $description): static
    {
        $this->channelDescription = $description;
        return $this;
    }

    public function withChannelUrl(string $url): static
    {
        $this->channelUrl = $url;
        return $this;
    }

    /** @noinspection PhpPureAttributeCanBeAddedInspection */
    public function addItem(): FeedItemBuilder {
        return new FeedItemBuilder($this);
    }

    public function addImage(): ImageDataBuilder {
        return new ImageDataBuilder($this);
    }

    public function withBuiltItem(RssItem $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function withBuiltImage(RssChannelImage $image): static {
        $this->image = $image;
        return $this;
    }
}