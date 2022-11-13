<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

class RssFeed
{
    private array $channels;

    public function __construct() {
        $this->channels = array();
    }

    public function addChannel(RssChannel $channel) {
        $this->channels[] = $channel;
    }

    /** @return RssChannel[] */
    public function getChannels(): array
    {
        return $this->channels;
    }
}