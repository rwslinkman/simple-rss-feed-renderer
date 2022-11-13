# SimpleRssFeedRenderer
Basic object-to-RSS renderer for hosting an RSS feed

# Installation
Add `simple-rss-feed-renderer` to your dependencies using Composer:   
```shell
composer require rwslinkman/simple-rss-feed-renderer
```

# Usage
Please find below an example of how to use `SimpleXmlFeedRenderer`.   
The `FeedBuilder` can be used to create data objects.   

```php
// Article content loaded in a way preferred by you
$articlesList = array(...);

$feedBuilder = (new FeedBuilder())
    ->withChannelTitle("Fun facts")
    ->withChannelDescription("Daily fun facts for you to read")
    ->withChannelUrl("https://funfacts.nl/articles");

foreach ($articlesList as $article) {
    $feedBuilder
        ->addItem()
        ->withTitle($article->getTitle())
        ->withDescription($article->getSubtitle())
        ->withUrl("https://funfacts.nl/articles/" . $article->getId())
        ->withPubDate($article->getCreatedAt())
        ->buildItem();
}
$rssFeed = $feedBuilder->build();

// Don't forget to set "application/rss+xml" for the "Content-Type" header
$renderer = new SimpleRssFeedRenderer();
$renderer->configurePrettyPrint(true);
$rssXml = $renderer->render($rssFeed);
```

# Other
Run `phpunit` tests with or without coverage:    
```shell
./scripts/run_phpunit.sh 
./scripts/run_phpunit_coverage.sh 
```