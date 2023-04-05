.PHONY: docker/up-local
## Docker up local
docker/up-local:
	docker compose up --build -d
