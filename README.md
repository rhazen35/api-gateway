# Skeme API Gateway

This API is the gateway to the Skeme Planning Software

Prerequisites
-------------
This API uses Symfony 5 with the following bundles:

- api-platform/api-pack
- doctrine/doctrine-migrations-bundle
- gedmo/doctrine-extensions
- lexik/jwt-authentication-bundle
- symfony/framework-bundle
- symfony/validator

Installation
------------

```bash
$ composer install
```

Database Setup
--------------

#### Add the current to you .env (.env.local) file 
```bash
DATABASE_URL=mysql://user:password@127.0.0.1:3306/skeme_api_%kernel.environment%

$ bin/console doctrine:database:create (do:da:cr) # Database creation
$ bin/console doctrine:migrations:migrate (do:mi:mi) # Migrations
$ bin/console doctrine:fixtures:load (do:fi:lo) # Data fixtures
```

Lexik JWT Bundle Setup
----------------------

#### Generate the SSH keys:

``` bash
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

Configuration
-------------

Configure the SSH keys path in your `config/packages/lexik_jwt_authentication.yaml` :

``` yaml
lexik_jwt_authentication:
    secret_key:       '%kernel.project_dir%/config/jwt/private.pem' # required for token creation
    public_key:       '%kernel.project_dir%/config/jwt/public.pem'  # required for token verification
    pass_phrase:      'your_secret_passphrase' # required for token creation, usage of an environment variable is recommended
    token_ttl:        3600
```

Making a Request
----------------

In order to make a request you will have to get a JWT Token.

Make a GET request to 'api/login_check' with the following:

- Authorization : None
- Content-Type: 'application/json'
- The email and password (from the UserFixture)

After you get the JWT token you can make requests with the token:

Authorization: Bearer {YOUR_TOKEN}