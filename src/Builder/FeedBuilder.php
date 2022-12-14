<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Builder;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssAttributedProperty;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannel;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannelImage;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;

class FeedBuilder
{
    // Mandatory items
    private string $channelTitle;
    private string $channelDescription;
    private string $channelUrl;
    private array $items;
    // optional items
    private ?string $channelLanguage = null;
    private ?string $channelCopyright = null;
    private ?string $channelManagingEditor = null;
    private ?string $channelWebMaster = null;
    private ?DateTime $channelPubDate = null;
    private ?DateTime $channelLastBuildDate = null;
    private ?string $channelCategory = null;
    private ?string $channelGenerator = null;
    private ?string $channelDocs = null;
//    private ?RssAttributedProperty $channelCloud = null;
    private ?int $channelTtl = null;
    private ?RssChannelImage $channelImage = null;
//    private ?string $channelRating = null;
//    private ?object $channelTextInput = null;
    private ?array $channelSkipHours = null;
    private ?array $channelSkipDays = null;

    public function __construct() {
        $this->channelTitle = "";
        $this->channelDescription = "";
        $this->channelUrl = "";
        $this->items = array();
    }

    public function build(): RssFeed {
        $pubDate = $this->channelPubDate?->format(DateTimeInterface::RSS);
        $lastBuildDate = $this->channelLastBuildDate?->format(DateTimeInterface::RSS);

        // Channel metadata
        $channel = new RssChannel();
        $channel->setTitle($this->channelTitle);
        $channel->setDescription($this->channelDescription);
        $channel->setLink($this->channelUrl);
        $channel->setLanguage($this->channelLanguage);
        $channel->setCopyright($this->channelCopyright);
        $channel->setManagingEditor($this->channelManagingEditor);
        $channel->setWebMaster($this->channelWebMaster);
        $channel->setPubDate($pubDate);
        $channel->setLastBuildDate($lastBuildDate);
        $channel->setCategory($this->channelCategory);
        $channel->setGenerator($this->channelGenerator);
        $channel->setDocs($this->channelDocs);
        $channel->setTtl($this->channelTtl);
        $channel->setImage($this->channelImage);
        $channel->setSkipHours($this->channelSkipHours);
        $channel->setSkipDays($this->channelSkipDays);
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

    public function withChannelLanguage(string $language): static {
        $this->channelLanguage = $language;
        return $this;
    }

    public function withChannelCopyright(string $copyright): static {
        $this->channelCopyright = $copyright;
        return $this;
    }

    public function withChannelManagingEditor(string $managingEditor): static {
        $this->channelManagingEditor = $managingEditor;
        return $this;
    }

    public function withChannelWebMaster(string $webMaster): static {
        $this->channelWebMaster = $webMaster;
        return $this;
    }

    public function withChannelPubDate(DateTime $pubDate): static {
        $this->channelPubDate = $pubDate;
        return $this;
    }

    public function withChannelLastBuildDate(DateTime $lastBuildDate): static {
        $this->channelLastBuildDate = $lastBuildDate;
        return $this;
    }

    public function withChannelCategory(string $category): static {
        $this->channelCategory = $category;
        return $this;
    }

    public function withChannelGenerator(): static {
        $this->channelGenerator = "rwslinkman/simple-rss-feed-renderer";
        return $this;
    }

    public function withChannelDocs(string $docs): static {
        $this->channelDocs = $docs;
        return $this;
    }

    public function withChannelTtl(int $ttl): static {
        $this->channelTtl = $ttl;
        return $this;
    }

    public function withChannelSkipHours(array $skipHours): static {
        $this->channelSkipHours = $skipHours;
        return $this;
    }

    public function withChannelSkipDays(array $skipDays): static {
        $this->channelSkipDays = $skipDays;
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
        $this->channelImage = $image;
        return $this;
    }
}