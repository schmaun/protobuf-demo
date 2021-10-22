.PHONY: build lint doc consumer publisher publisher_another dump

build:
	find ./instapro -name '*.proto' -print0 | xargs -0 protoc --php_out=./demo/messages

lint:
	buf lint

bc:
	buf breaking --against .git#branch=main

consumer:
	cd demo && php consumer.php

publisher:
	cd demo && php publisher.php

publisher_another:
	cd demo && php publisher_another.php

dump:
	cd demo && php /usr/local/bin/composer dump-autoload