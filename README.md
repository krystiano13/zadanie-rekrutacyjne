# Zadanie Rekrutacyjne: URL Shortener

## Uruchomienie

```bash
docker compose up -d --build
```

## Następnie z poziomu kontenera php

```bash
php bin/console d:d:c
php bin/console d:m:m
```

## Dodatkowo uruchamiamy consumer Symfony Messenger

```bash
php bin/console messenger:consume async -vv
```

## Następnie z poziomu kontenera react (jeśli okaże się konieczne)

```bash
pnpm install --frozen-lockfile
```
