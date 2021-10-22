## Compile .proto files to PHP
```bash
$ find ./instapro -name '*.proto' -print0 | xargs -0 bin/protoc --php_out=./demo/messages
```

## Linting & BC break
```bash
$ buf lint
$ buf breaking --against .git#branch=main
```

## Run the demo
```bash
$ make consumer
$ make publisher
```

## Install

Make sure `php` is in your `$PATH` and at least version 8.0.0.

You need a running RabbitMq server on localhost:5672 (user: guest, password: guest)
```bash
# Install protobuf with brew
$ brew install protobuf

# install runtime as PHP
$ composer require google/protobuf

# install PHP runtime as Pecl
$ pecl install protobuf
```