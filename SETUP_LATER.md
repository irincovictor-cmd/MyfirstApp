# Setup later (after the deadline)

Submit the **GitHub link** now. Use this when you have time for localhost.

## One command (WSL Ubuntu)

```bash
cd ~
curl -fsSL https://raw.githubusercontent.com/irincovictor-cmd/MyfirstApp/main/setup-bloodlink.sh -o setup-bloodlink.sh
bash setup-bloodlink.sh
```

Or if already cloned:

```bash
cd ~/project2/myFirstApp
git pull origin main
bash setup-bloodlink.sh
```

## After it finishes

| Page | URL |
|------|-----|
| Home | http://localhost:8000/blood |
| Donors | http://localhost:8000/blood/donors |
| Requests | http://localhost:8000/blood/requests |
| Contact | http://localhost:8000/blood/contact |
| Admin | http://localhost:8000/blood/admin |

## Requirements

1. WSL Ubuntu
2. Docker Desktop (running, WSL integration on)
3. School `~/project2/docker-compose.yml` if you use laravel_php / nginx on 8000

## Repo to submit now

https://github.com/irincovictor-cmd/MyfirstApp
