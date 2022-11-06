# SimpleRssFeedRenderer
Basic object-to-RSS renderer for hosting an RSS feed    

# Usage
Please find below an example of how to use `SimpleXmlFeedRenderer`.   

```php
// Article content loaded in a way preferred by you
$articlesList = array(...);

$feedBuilder = (new FeedBuilder())
    ->withFeedRenderer(new SimpleXmlFeedRenderer())
    ->withPrettyPrintXML(true)
    ->withChannelTitle("Fun facts")
    ->withChannelDescription("Daily fun facts for you to read")
    ->withChannelUrl("https://funfacts.nl/articles");

foreach ($articlesList as $article) {
    $feedBuilder->addItem()
        ->withTitle($art->getTitle())
        ->withDescription($article->getSubtitle())
        ->withUrl($url)
        ->withPubDate($article->getCreatedAt())
        ->buildItem();
}


// Don't forget to set "application/rss+xml" for the "Content-Type" header
$rssXml = $feedBuilder->build();
```