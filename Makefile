.PHONY: build lint doc consumer publisher

build:
	find ./instapro -name '*.proto' -print0 | xargs -0 bin/protoc --php_out=./demo/messages

lint:
	buf lint

doc:
	#docker run --rm -v $(PWD)/doc:/out -v $(PWD)/instapro:/protos pseudomuto/protoc-gen-doc
	docker run --entrypoint= --rm -v $(PWD)/doc:/out -v $(PWD)/instapro:/protos pseudomuto/protoc-gen-doc "find /protos -name '*.proto' -print0 | xargs -0 bin/protoc --plugin_name=doc --plugin_out=/out"

consumer:
	cd demo && /usr/local/Cellar/php/8.0.5/bin/php consumer.php

publisher:
	cd demo && /usr/local/Cellar/php/8.0.5/bin/php publisher.php
