<?php

declare(strict_types = 1);

namespace EdmondsCommerce\W3C\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getAssetDir():string
    {
        return __DIR__ . '/assets';
    }


    protected function getHtmlContent($name)
    {
        return file_get_contents($this->getHtmlPath($name));
    }

    protected function getHtmlPath($name)
    {
        $baseAssetsDir = $this->getAssetDir();

        return $baseAssetsDir . '/html/'.$name;
    }


}