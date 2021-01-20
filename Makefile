.PHONY: devenv-up
devenv-up:
	./vendor/bin/sail up

.PHONY: devenv-down
devenv-down:
	./vendor/bin/sail down
