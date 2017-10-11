<?php

declare(strict_types=1);

namespace Edmonds\GeneralRemoteLint\W3;

use EdmondsCommerce\W3C\AbstractValidator;
use EdmondsCommerce\W3C\ValidatorInterface;

class Html extends AbstractValidator implements ValidatorInterface
{

    /**
     * Returns the absolute path to the installed validator
     * @return string
     */
    protected function getValidatorPath(): string
    {
        //Get the bin directory
        $binDir = __DIR__ . '/../bin';
        $validatorPath = $binDir . '/html.jar';

        return $validatorPath;
    }

    /**
     * Get the full bash validator command
     * @param string $inputFile
     * @return string
     */
    protected function getValidatorCommand(string $inputFile): string
    {
        $validatorPath = $this->getValidatorPath();

        $format = 'java -jar %s --format json --exit-zero-always %s 2>&1';
        $command = sprintf($format, $validatorPath, $inputFile);

        return $command;
    }

    /**
     * @param string $inputFile
     * @return array
     */
    protected function runValidatorCommand(string $inputFile):array
    {
        $output = parent::runValidatorCommand($inputFile);
        $output = json_decode(array_shift($output), true);

        return $output['messages'];
    }
}
