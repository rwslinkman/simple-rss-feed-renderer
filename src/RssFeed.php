<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

class RssFeed
{
    private FeedRendererInterface $feedRenderer;
    private array $channels;

    public function __construct(FeedRendererInterface $renderer) {
        $this->channels = array();
        $this->feedRenderer = $renderer;
    }

    public function configureRenderer(FeedRendererInterface $renderer) {
        $this->feedRenderer = $renderer;
    }

    public function addChannel(RssChannel $channel) {
        $this->channels[] = $channel;
    }

    public function renderFeed(): string {
        return $this->feedRenderer->render($this);
    }

    /** @return RssChannel[] */
    public function getChannels(): array
    {
        return $this->channels;
    }

    public function __toString(): string
    {
        return $this->renderFeed();
    }
}