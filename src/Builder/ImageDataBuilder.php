<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Builder;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssChannelImage;

class ImageDataBuilder
{
    private FeedBuilder $parentBuilder;
    // Required attributes
    private string $url;
    private string $title;
    private string $link;
    // Optional attributes
    private int $width;
    private int $height;
    private ?string $description;

    public function __construct(FeedBuilder $parentBuilder) {
        $this->parentBuilder = $parentBuilder;
        $this->url = "";
        $this->title = "";
        $this->link = "";
        $this->width = -1;
        $this->height = -1;
        $this->description = null;
    }

    public function buildImage(): FeedBuilder
    {
        $image = new RssChannelImage();
        $image->setUrl($this->url);
        $image->setTitle($this->title);
        $image->setLink($this->link);
        $image->setWidth($this->width);
        $image->setHeight($this->height);
        $image->setDescription($this->description);

        $this->parentBuilder->withBuiltImage($image);
        return $this->parentBuilder;
    }

    public function withUrl(string $url): static {
        $this->url = $url;
        return $this;
    }

    public function withTitle(string $title): static {
        $this->title = $title;
        return $this;
    }

    public function withLink(string $link): static {
        $this->link = $link;
        return $this;
    }

    public function withWidth(int $width): static {
        $this->width = $width;
        return $this;
    }

    public function withHeight(int $height): static {
        $this->height = $height;
        return $this;
    }

    public function withDescription(string $description): static {
        $this->description = $description;
        return $this;
    }
}