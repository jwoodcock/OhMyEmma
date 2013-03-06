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
<pre>
{
    "require": {
        "OhMyEmma": "1.*"
    }
}
</pre>
</code>

## Usage ##

Create a new instance and provide account credentials and which interface 
you want to use. 
<code>
<pre>
$emma = new Emma(
    $account_id,
    $public_api_key,
    $private_api_key,
    $interface
);
</pre>
</code>
Available interfaces are: (case sensitive)
* fields
* groups
* mailings
* members
* response
* searches
* triggers
* webhooks

## License ##

Copyright (c) 2013, Kite, Inc All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
