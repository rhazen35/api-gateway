Skeme Core API

Installation
------------

```bash
$ composer install
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