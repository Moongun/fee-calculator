**BUILD:**
```
docker compose up
docker compose run php composer install
```

**TESTS:**
```
docker compose run php vendor/bin/phpunit tests
```