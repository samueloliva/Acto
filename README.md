# Acto Pre-Screen Tasks

## UserController
The proposed refactored code is in UserController.php

## Cache
The Cache class code is in Cache.php

But bellow follows an example of use of the class.

### Example:

Instantiating one cache object with the default parameters 
Default: $folder='cache/', $name = 'api', $extension = '.cache'.
These parameters define the cache folder and file name and extension.

Creating three cache items, the first one has two seconds to expires.
The other will expire in 10 minutes, as defined by default.
The sleep is used in order to expire the first item.

```php
$cache = new Cache();
$cache->put("A", "Cache test A!", 2);
sleep(4);
$cache->put("B", "Cache test B!");
$cache->put("C", "Cache test C!");
```

Removing cache object with key "B" and listing all items

```php
$cache->remove("B");
print_r($cache->findAll());
```

Finding cache item by key

```php
print_r($cache->find("A"));
```

Removing all cache items expired and listing all remaining

```php
$cache->removeExpired();
print_r($cache->findAll());
```

Remove all items and listing all remaining

```php
$cache->removeAll();
print_r($cache->findAll());
```