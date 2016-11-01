# sentry-nette
Integrates Sentry error handlers to nette (alse registers [Raven_client](https://github.com/getsentry/sentry-php) as a service)

## Install
```bash
composer require matyx/sentry-nette
```

## Configure
Add following to your **config.local.neon**
```yaml
#register extension
extensions:
	sentry: Matyx\Sentry\SentryExtension


sentry:
	dsn: https://__REPLACE_WITH_TOKEN__
```
