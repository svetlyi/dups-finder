# Dups-finder in PHP

It's an application for the sake of application and to play with threads in PHP.

## Usage:

```php
# find files duplicates in /path/to/folder/ using 4 threads:
php app.php app:find-dups /path/to/folder/ 4
```

## Requirements:

There must be the [pthreads](https://github.com/krakjoe/pthreads) extension installed.
