```bash
$ find ./instapro -name '*.proto' -print0 | xargs -0 bin/protoc --php_out=./demo/messages
```

```bash
$ /usr/local/Cellar/php/8.0.5/bin/php consumer.php
$ /usr/local/Cellar/php/8.0.5/bin/php publisher.php
```
