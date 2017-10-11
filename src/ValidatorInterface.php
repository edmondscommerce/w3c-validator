<?php

declare(strict_types=1);

namespace EdmondsCommerce\W3C;

interface ValidatorInterface
{
    /**
     * Validates a file path
     * @param string $inputFile
     * @return array
     */
    public function validateFile(string $inputFile): array;

    /**
     * Validates a raw fragment
     * @param string $content
     * @return array
     */
    public function validateFragment(string $content): array;
}