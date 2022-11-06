<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer\Tests;

use nl\rwslinkman\SimpleRssFeedRenderer\RssFeed;
use nl\rwslinkman\SimpleRssFeedRenderer\SimpleRssFeedRenderer;

class SimpleRssFeedRendererTests
{
    public function testGivenX_whenY_thenZ() {
        $renderer = new SimpleRssFeedRenderer();
        $testFeed = new RssFeed($renderer);

        $renderer->render();
    }
}