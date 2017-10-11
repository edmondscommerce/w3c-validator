# W3C Validator
## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)

A simple wrapper class around the W3C HTML Validator (CSS coming soon).

## Usage

Ensure that you have the following system dependencies

* Java Runtime
* Unzip

Install using composer.
Run the `w3c-html-install.bash` command in the `bin` directory

To run the validator, instantiate the `EdmondsCommerce\W3C\Html` class and use the available public methods to validate files or fragments.
The library does not handle resolving a URL but this should not be an issue to work around.

The tool was created with the idea of bulk validation of files over using the public W3C validator that does have a rate limit set.
