<?php

declare(strict_types=1);

namespace EdmondsCommerce\W3C\Tests\Integration;

use EdmondsCommerce\W3C\Html;
use EdmondsCommerce\W3C\Tests\TestCase;

class HtmlTest extends TestCase
{
    /** @var  Html */
    protected $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new Html();
    }

    public function testItWillValidateRawHtmlFragment()
    {
        $html = $this->getHtmlContent('valid.html');

        $result = $this->validator->validateFragment($html);

        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    public function testItWillValidateHtmlFiles()
    {
        $html = $this->getHtmlPath('valid.html');

        $result = $this->validator->validateFile($html);

        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    public function testItWillValidateRawHtmlWithWarnings()
    {
        $html = $this->getHtmlPath('warning.html');

        $result = $this->validator->validateFile($html);

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
    }

    public function testItWillValidateRawHtmlWithErrors()
    {
        $html = $this->getHtmlPath('error.html');

        $result = $this->validator->validateFile($html);

        $this->assertInternalType('array', $result);
        $this->assertCount(5, $result);
    }
}