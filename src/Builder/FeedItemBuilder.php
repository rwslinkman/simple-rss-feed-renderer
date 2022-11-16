<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Builder;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;

class FeedItemBuilder
{
    private FeedBuilder $parentBuilder;

    private string $title;
    private string $description;
    private string $url;
    private DateTime $pubDate;

    public function __construct(FeedBuilder $parent)
    {
        $this->parentBuilder = $parent;
        $this->title = "";
        $this->description = "";
        $this->url = "";
    }

    public function buildItem(): FeedBuilder {
        $pubDate = $this->pubDate->format(DateTimeInterface::RSS);

        $item = new RssItem();
        $item->setTitle($this->title);
        $item->setDescription($this->description);
        $item->setUrl($this->url);
        $item->setPubDate($pubDate);

        $this->parentBuilder->withBuiltItem($item);
        return $this->parentBuilder;
    }

    public function withTitle(string $channelTitle): static
    {
        $this->title = $channelTitle;
        return $this;
    }

    public function withDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function withUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function withPubDate(DateTime $pubDate): static {
        $this->pubDate = $pubDate;
        return $this;
    }
}