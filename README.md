# Acto

```php
$cache = new Cache();
$cache->put("A", "Cache test A!", 2);
sleep(4);
$cache->put("B", "Cache test B!");
$cache->put("C", "Cache test C!");
$cache->remove("B");
print_r($cache->find("A"));
echo "\n";
print_r($cache->findAll());
$cache->removeExpired();
print_r($cache->findAll());
$cache->removeAll();
print_r($cache->findAll());

```