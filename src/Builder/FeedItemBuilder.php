<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Builder;

use DateTime;
use DateTimeInterface;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssItem;

class FeedItemBuilder
{
    private FeedBuilder $parentBuilder;

    // Optional attributes
    private ?string $title = null;
    private ?string $description = null;
    private ?string $link = null;
    private ?string $author = null;
    private ?string $category = null;
    private ?string $comments = null;
//    private ?object $enclosure;
//    private ?object $guid;
    private ?DateTime $pubDate = null;
//    private ?object $source;


    public function __construct(FeedBuilder $parent)
    {
        $this->parentBuilder = $parent;
    }

    public function buildItem(): FeedBuilder {
        $pubDate = $this->pubDate?->format(DateTimeInterface::RSS);

        $item = new RssItem();
        $item->setTitle($this->title);
        $item->setDescription($this->description);
        $item->setLink($this->link);
        $item->setAuthor($this->author);
        $item->setCategory($this->category);
        $item->setComments($this->comments);
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

    public function withLink(string $link): static
    {
        $this->link = $link;
        return $this;
    }

    public function withAuthor(string $author): static {
        $this->author = $author;
        return $this;
    }

    public function withCategory(string $category): static {
        $this->category = $category;
        return $this;
    }

    public function withComments(string $comments): static {
        $this->comments = $comments;
        return $this;
    }

    public function withPubDate(DateTime $pubDate): static {
        $this->pubDate = $pubDate;
        return $this;
    }
}