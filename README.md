# Alexa Next Bus PHP

This project is an example serverless function that can be used to power a PHP based Alexa Skill, running on AWS Lambda, to fetch the next bus times from a number of configured bus stops (using the [TransportAPI](https://transportapi.com)). 

# Steps

### Prerequisites for development
- [node.js v6.10](https://nodejs.org)
- [php 7.1](https://secure.php.net/)
- [TransportAPI account](https://developer.transportapi.com/)

### Install serverless

`npm install serverless -g`

### Install dependencies

`docker run --rm -v $(pwd):/app composer/composer install`

### Run locally

`sls invoke local --function nextBus`

NOTE: You will need php 7 installed locally. Not ideal, but necessary without avoiding this and using docker for local testing instead.

### Setup AWS creds

`serverless config credentials --provider aws --key AKIAIOSFODNN7EXAMPLE --secret wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY`

See https://git.io/vXsdd

### Deploy

`sls deploy`

### Add trigger

Choose alexa skills kit.

### Create Alexa skill

Create a new skill, applying the invocation name "bus timetables". Insert ARN of AWS Lambda we just created. Intent not necessary at this stage, as this basic skill only does one thing, and happens on the launch request.

## Test!

"Alexa, open bus timetables."

## Rebuilding the PHP binary

If you need different compiler flags or dependencies you will need to recompile PHP.

### Prerequisites
- [docker](https://www.docker.com/)

### Compile the static standalone PHP 7 binary
To do this, we have to compile the PHP 7.1.2 with statically linked libraries:

```shell
sh buildphp.sh
```

### PHP Version
The default is to use the PHP 7.1.2 branch to compile the PHP binary.
To switch the PHP version you can set the branch PHP_VERSION_GIT_BRANCH parameter in `buildphp.sh` line 8.

# FAQs

### How do I get the ATCO code for my bus stop(s)?

One of the easiest ways is to find your bus stop on [OpenStreetMap](https://www.openstreetmap.org/node/496714689). Clicking on the stop should reveal data including the all important `naptan:AtcoCode`. This is the value you want to use.
 
From experience (examining bus stops by First Leeds), this tends to just look like the SMS code but with an extra 0. You might be able to guess the ATCO code if data is not readily available on OpenStreetMap.

Alternatively, you can view the full data set from DfT [here](https://data.gov.uk/dataset/naptan).

# Thanks
Huge thanks to [Robert Anderson](https://twitter.com/8ctopus) for piecing together the [serverless framework template](https://github.com/ZeroSharp/serverless-php) that this PoC is based on.

# Further reading
### Serverless PHP
- https://serverless.com/
- http://blog.zerosharp.com/the-serverless-framework-and-php/
- http://blog.gaiterjones.com/amazon-alexa-php-hello-world-example/
- https://github.com/nomisoft/PHP-Alexa-Helper
- https://github.com/awspilot/aws-lambda-php-template
- https://github.com/dannylinden/aws-lambda-php
- https://github.com/ZeroSharp/serverless-php

### Async PHP
- [Asynchronous API Interaction with Guzzle Session @ZendCon 2015](https://www.youtube.com/watch?v=4J7p0CZ0aQ4)
- [Steve Maraspin - Meet a parallel, asynchronous PHP world](https://www.youtube.com/watch?v=dk-D3g2MD2U) 
- [The promise of asynchronous PHP - Wim Godden](https://www.youtube.com/watch?v=JCE6G_b1-eA&t=466s)
- https://blog.madewithlove.be/post/concurrent-http-requests/
- https://blog.newrelic.com/2016/03/14/guzzle/

