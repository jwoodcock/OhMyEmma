OhMyEmma
========

OhMyEmma is a PHP library for interfacing with the Emma, www.myemma.com, API and
requires an active API account_id, public_api_key, and private_api_key.

This library is based off the API documentation published on March 05, 2013 and
can be found at this URL: http://api.myemma.com/index.html. Currently Emma does
not have a method to inform users when the API is updated so this library will
only be updated when users find a need or inform the authors of a change. 

Additionally, to properly use this library it is best to read and understand
the documentation for how filters, arrays and other parameters should be 
structure as this library is not intended to validate the data structures 
provided to it. 

With that, we give you OhMyEmma

## Installing ##

You have two options for using this library, first download and move to your 
desired location and second USE COMPOSER. So, USE COMPOSER. ;-)

<code>
{
    "require": {
        "OhMyEmma": "1.*"
    }
}
</code>

## Usage ##

Create a new instance. 
<code>
$emma = new Emma(
    $account_id,
    $public_api_key,
    $private_api_key,
    $interface
);
</code>
