<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Object;

/**
 * https://www.rssboard.org/rss-specification
 */
class RssFeed
{
    // https://www.rssboard.org/rss-specification#whatIsRss
    private RssChannel $channel;

    /**
     * @param RssChannel $channel
     */
    public function __construct(RssChannel $channel)
    {
        $this->channel = $channel;
    }

    /** @return RssChannel */
    public function getChannel(): RssChannel
    {
        return $this->channel;
    }
}