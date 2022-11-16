<?php
namespace nl\rwslinkman\SimpleRssFeedRenderer;

interface FeedRendererInterface
{
    function configurePrettyPrint(bool $enabled): void;

    function configureValidateBeforeRender(bool $enabled): void;

    function render(RssFeed $feed): string;
}