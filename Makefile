.PHONY: build lint doc consumer publisher

build:
	find ./instapro -name '*.proto' -print0 | xargs -0 protoc --php_out=./demo/messages

lint:
	buf lint

consumer:
	cd demo && /usr/local/Cellar/php/8.0.5/bin/php consumer.php

publisher:
	cd demo && /usr/local/Cellar/php/8.0.5/bin/php publisher.php
