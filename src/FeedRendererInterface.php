<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

use nl\rwslinkman\SimpleRssFeedRenderer\Object\RssFeed;

interface FeedRendererInterface
{
    function configurePrettyPrint(bool $enabled): void;

    function configureValidateBeforeRender(bool $enabled): void;

    function render(RssFeed $feed): string;
}