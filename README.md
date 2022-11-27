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
Most properties in the RSS 2.0 specification are configurable.   
Not all configurable properties are shown in the example below.    

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
        ->withLink("https://funfacts.nl/articles/" . $article->getId())
        ->withPubDate($article->getCreatedAt())
        ->buildItem();
}
$rssFeed = $feedBuilder->build();

// Don't forget to set "application/rss+xml" for the "Content-Type" header
$renderer = new SimpleRssFeedRenderer();
$renderer->configurePrettyPrint(true);
$renderer->configureValidateBeforeRender(true);
$rssXml = $renderer->render($rssFeed);
```

When configured, the renderer will perform RSS 2.0 validations on all provided data in the `RssFeed` object.   
The `RssValidator` can also be run separately:   

```php
$feedBuilder = (new FeedBuilder())
    ->withChannelTitle("Fun facts")
    ->withChannelDescription("Daily fun facts for you to read")
    ->withChannelUrl("https://funfacts.nl/articles");
$rssFeed = $feedBuilder->build();

// it will throw InvalidRssException containing the ValdationReport in case of errors
$validator = new RssValidator();
$validator->validate($rssFeed);
```

# Other
Run `phpunit` tests with or without coverage:    
```shell
./scripts/run_phpunit.sh 
./scripts/run_phpunit_coverage.sh 
```