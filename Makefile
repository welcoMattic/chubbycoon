# Infrastructure
start:
	fab start
	@make -s confirm-up

stop:
	fab stop

confirm-up:
	@echo "=============== Stack is up and ready ================="
	@echo "Application is accessible at http://chubbycoon.dev/"
