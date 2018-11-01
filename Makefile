.DEFAULT_GOAL := help
PHP_CS_FIXER_COMMAND=./vendor/bin/php-cs-fixer

help:
	@echo "\033[33mUsage:\033[0m"
	@echo "  make [command]"
	@echo ""
	@echo "\033[33mAvailable commands:\033[0m"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%s\033[0m___%s\n", $$1, $$2}' | column -ts___

check: ## Checks project dependencies
	@echo "\033[1m\033[36m> Checking project dependencies\033[0m\033[21m"
	@which composer >/dev/null 2>&1 && echo "\033[32m[OK]\033[0m composer is installed\033[0m" || echo "\033[31m[KO]\033[0m composer is not installed"

install: ## Installs all project dependencies
	@echo "\033[1m\033[36m> Installing project dependencies\033[0m\033[21m"
	@composer install

test: ## Runs all tests
	@echo "\033[1m\033[36m> Running tests\033[0m\033[21m"
	./vendor/bin/phpunit

php-cs-fix: ## Fix PHP code style
	@echo "\033[1m\033[36m> Fixing code style\033[0m\033[21m"
	$(PHP_CS_FIXER_COMMAND) fix --config=./.php_cs

php-cs-lint: ## Lint PHP code style
	$(PHP_CS_FIXER_COMMAND) fix --config=./.php_cs --dry-run --diff