<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use DateTime;
use nl\rwslinkman\SimpleRssFeedRenderer\Builder\FeedBuilder;
use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\SimpleRssFeedRenderer;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    public function testReadMeSample() {
        $rssFeed = $this->createTestFeed();

        // Rendering the RSS feed
        $renderer = new SimpleRssFeedRenderer();
        $renderer->configurePrettyPrint(true);
        $rssXml = $renderer->render($rssFeed);

        $this->assertNotNull($rssXml);
        $this->assertNotEquals("", $rssXml);
    }

    private function createTestArticle($id, $title, $subtitle) {
        return array('id' => $id, 'title' => $title, 'subtitle' => $subtitle, 'createdAt' => new DateTime());
    }

    /**
     * @return RssFeed
     */
    private function createTestFeed(): RssFeed
    {
        // Some sample data
        $articlesList = array(
            $this->createTestArticle(1, "Article #1", "This is the 1st article"),
            $this->createTestArticle(2, "Article #2", "This is the 2nd article"),
            $this->createTestArticle(3, "Article #3", "This is the 3rd article"),
        );

        // RSS feed builder
        $feedBuilder = (new FeedBuilder())
            ->withChannelTitle("Fun facts")
            ->withChannelDescription("Daily fun facts for you to read")
            ->withChannelUrl("https://funfacts.nl/articles");

        foreach ($articlesList as $article) {
            // Adding articles to RSS feed
            $feedBuilder
                ->addItem()
                ->withTitle($article['title'])
                ->withDescription($article['subtitle'])
                ->withLink("https://funfacts.nl/articles/" . $article['id'])
                ->withPubDate($article['createdAt'])
                ->buildItem();
        }
        return $feedBuilder->build();
    }
}