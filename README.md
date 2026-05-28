# Vacancy API

Тестовое задание: сервис управления вакансиями.

## Стек

### Backend

* PHP 8.1
* Yii2
* MySQL 8
* Swagger/OpenAPI

### Frontend

* Nuxt 3
* TypeScript

### Infrastructure

* Docker
* Docker Compose

---

# Запуск проекта

## 1. Клонирование репозитория

```bash
make init
```

---

# Доступные сервисы

| Service     | URL                           |
| ----------- | ----------------------------- |
| Frontend    | http://localhost:3000         |
| Backend API | http://localhost:8080/api     |
| Swagger     | http://localhost:8080/swagger |
| MySQL       | localhost:3306                |

---

# API Endpoints

## Получить список вакансий

```http
GET /api/vacancies
```

Пример ответа:

```json
[
  {
    "id": 1,
    "title": "PHP Developer",
    "description": "Yii2 developer",
    "salary": 150000,
    "created_at": "2026-05-26 12:00:00"
  }
]
```

---

## Получить вакансию

```http
GET /api/vacancies/1
```

---

## Создать вакансию

```http
POST /api/vacancies
Content-Type: application/json
```

Body:

```json
{
  "title": "Senior PHP Developer",
  "description": "Laravel + Yii2",
  "salary": 300000
}
```

---
# Тесты

Backend:
```bash
make test
```

Frontend:
```bash
make test-frontend
```