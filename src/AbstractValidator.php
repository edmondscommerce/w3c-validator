<?php

declare(strict_types=1);

namespace EdmondsCommerce\W3C;


use EdmondsCommerce\W3C\Exception\W3Exception;
use EdmondsCommerce\W3C\Exception\W3ValidatorInstallException;

abstract class AbstractValidator implements ValidatorInterface
{

    /**
     * AbstractValidator constructor.
     */
    public function __construct()
    {
        $path = $this->getValidatorPath();

        if (!is_file($path))
        {
            throw new W3ValidatorInstallException('Validator does not exist at "' . $path . '"');
        }

        if (!is_executable($path))
        {
            throw new W3ValidatorInstallException('Validator is not executable at path "' . $path . '"');
        }
    }

    /**
     * Returns the absolute path to the installed validator
     * @return string
     */
    protected abstract function getValidatorPath(): string;

    /**
     * Get the full bash validator command
     * @return string
     */
    protected abstract function getValidatorCommand(string $inputFile): string;

    protected function runValidatorCommand(string $inputFile)
    {
        $command = $this->getValidatorCommand($inputFile);

        $output = array();
        $exitCode = null;
        exec($command, $output, $exitCode);

        if (0 !== $exitCode)
        {
            throw new W3Exception('Error when running validator command');
        }

        return $output;
    }

    public function validateFile(string $inputFile): array
    {
        //Check we can read the file
        if (!is_file($inputFile))
        {
            throw new W3Exception('Could not find input file at "' . $inputFile . '"');
        }

        if (is_readable($inputFile) === false)
        {
            throw new W3Exception('Could not read input file at "' . $inputFile . '"');
        }

        $result = $this->runValidatorCommand($inputFile);

        return $result;
    }

    /**
     * @param string $content
     * @return array
     */
    public function validateFragment(string $content): array
    {
        $tempFile = $this->writeTempFile($content);

        return $this->validateFile($tempFile);

        //TODO: Remove the tmp file when we are done just in case
    }

    /**
     * Writes to a random temporary file in the configured system tmp directory
     * Returns the output files path as a string to be used
     * @param string $fragmentContent
     * @return string
     * @throws W3Exception
     */
    protected function writeTempFile(string $fragmentContent): string
    {
        $path = tempnam(sys_get_temp_dir(), 'w3c_');

        if (file_put_contents($path, $fragmentContent) === false)
        {
            throw new W3Exception('Could not write temporary file to "' . $path . '"');
        }

        return $path;
    }
}