# Spotify API SDK

This lib provides a PHP client to interact with the Spotify Web API.

## Installation

```
composer require bench1ps/spotify-api-client
```

## Working with the API

You will need to register an application with Spotify to use this lib, 
look at [this guide](https://developer.spotify.com/documentation/web-api/quick-start/) to set up your project.

A complete set of working examples is available in the `examples` directory.
To run them, proceed as follows:

```
cp examples/credentials.json.dist examples/credentials.json
```

Then, edit the file `credentials.json` and fill in the parameters for your project (`client_id`, `client_secret` and `redirect_uri`).

Before using the examples interacting with the Web API, you will need to get an access token from the Spotify account API:

```
php examples/authorization/authorization_code_flow_get_code.php
```

Visit the displayed URL, which will provide an authorization code. Copy this code in the file `examples/authorization/authorization_code_flow_exchange_code.php`, and run this file:

```
php examples/authorization/authorization_code_flow_exchange_code.php
``` 

You are now set up to interact with the Web API.
If the access token expires, you can get a new one by using the refresh token that was provided before:

```
php examples/authorization/refresh_token.php
``` 

