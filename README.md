# Zadanie Rekrutacyjne: URL Shortener

## Uruchomienie

```bash
docker compose up -d --build
```

## Następnie z poziomu kontenera php (jeśli okaże się konieczne)

```bash
php bin/console d:d:c
php bin/console d:m:m
```

## Dodatkowo uruchamiamy consumer Symfony Messenger

```bash
php bin/console messenger:consume async -vv
```

## Następnie z poziomu kontenera React (jeśli okaże się konieczne)

```bash
pnpm install --frozen-lockfile
```

## Testy jednostkowe uruchamiane z poziomu kontenera PHP

```bash
 ./vendor/bin/phpunit
```

## Dodatkowo aplikacja zawiera narzędzia do statycznej analizy kodu, które można uruchomić z poziomu kontenera PHP

```bash
vendor/bin/phpstan analyse src
./vendor/bin/php-cs-fixer fix
```

Z racji iż jako docker'owy starter użyłem https://github.com/dunglas/symfony-docker, to przed użyciem należy wejść z poziomu przeglądarki na https://localhost aby potwierdzić certyfikaty https
Frontend znajduje się natomiast na porcie http://localhost:5173
