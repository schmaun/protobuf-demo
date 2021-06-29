Build
```bash
$ find ./instapro -name '*.proto' -print0 | xargs -0 bin/protoc --php_out=./demo/messages
```

Linting & BC break
```bash
$ buf lint
```

Generate docs
```bash
$ docker run --rm -v $(pwd)/doc:/out -v $(pwd)/instapro:/protos pseudomuto/protoc-gen-doc find ./protos -name '*.proto' -print0 | xargs -0 bin/protoc --plugin_name=doc --plugin_out=./out
```

Demo
```bash
$ rm code/stream.txt
$ make consumer
$ make publisher
```

Install
```bash
# Install protobuf with brew
$ brew install protobuf

# install runtime as PHP
$ composer require google/protobuf

# install PHP runtime as Pecl
$ pecl install protobuf
```