# directory-counter
## Description
CLI App recursively iterates directory counting numbers in `count` files. 

## Install
Run docker container
```shell
docker compose run --rm php sh
# or
make docker/exec-sh
```

Install dependencies
```shell
composer install
```

## Usage
```shell
# from app directory
./bin/dircnt <path>
```
Example: run on `fixtures` directory
```shell
./bin/dircnt fixtures
```

## Developing
```shell
# Run CS fixer
make code/cs 

# Run phpstan
make code/phpstan

# Run code checks.
make code/check

# Run phpunit tests
make code/test
```