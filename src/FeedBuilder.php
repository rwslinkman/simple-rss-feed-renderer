<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use RuntimeException;

class FeedBuilder
{
    // default channel
    private string $channelTitle;
    private string $channelDescription;
    private string $channelUrl;
    private array $items;
    // additional channels (optional)
    private array $otherChannels;
    // rendering
    private ?FeedRendererInterface $renderer;

    public function __construct() {
        $this->channelTitle = "";
        $this->channelDescription = "";
        $this->channelUrl = "";
        $this->items = array();
        $this->otherChannels = array();
    }

    public function build(): RssFeed {
        if($this->renderer == null) {
            throw new RuntimeException("Renderer must be set. Call withFeedRenderer() first.");
        }
        $feed = new RssFeed($this->renderer);

        // default channel
        $channel = new RssChannel();
        $channel->setTitle($this->channelTitle);
        $channel->setDescription($this->channelDescription);
        $channel->setUrl($this->channelUrl);
        foreach($this->items as $item) {
            $channel->addItem($item);
        }
        $feed->addChannel($channel);

        // other channels
        foreach($this->otherChannels as $ch) {
            $feed->addChannel($ch);
        }
        return $feed;
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

    /** @noinspection PhpUnused */
    public function withCustomChannel(RssChannel $channel): static {
        $this->otherChannels[] = $channel;
        return $this;
    }

    public function withFeedRenderer(FeedRendererInterface $renderer): static {
        $this->renderer = $renderer;
        return $this;
    }

    public function withPrettyPrintXML(bool $enabled): static {
        $this->renderer?->configurePrettyPrint($enabled);
        return $this;
    }

    /** @noinspection PhpPureAttributeCanBeAddedInspection */
    public function addItem(): FeedItemBuilder {
        return new FeedItemBuilder($this);
    }

    public function withBuiltItem(RssItem $item): static
    {
        $this->items[] = $item;
        return $this;
    }
}