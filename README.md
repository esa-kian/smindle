# Dockerized Laravel Order Processing Application

This project is a simple Laravel application designed to process orders, validate payloads, and handle subscription-based items asynchronously. The application is fully dockerized and can be run using `docker compose`.

## Features
1. **Dockerized Setup**: Runs seamlessly with `docker compose`.
2. **Order Endpoint**: Validates incoming payloads and saves orders to a database.
3. **Async Subscription Handling**: Sends subscription items to a simulated slow third-party endpoint asynchronously.
4. **Database Integration**: Stores order data reliably in a relational database.

---

## Getting Started

### Prerequisites
- Docker and Docker Compose installed on your machine.

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/esa-kian/smindle.git
   cd smindle
   ```

2. Start the application:
```
docker compose up -d
```

### API Documentation
#### Endpoint: `POST /api/orders`
Processes an order payload and stores it in the database. If a subscription is included, it sends the relevant item to the third-party endpoint asynchronously.

*Request Body*
```json
{
  "first_name": "Alan",
  "last_name": "Turing",
  "address": "123 Enigma Ave, Bletchley Park, UK",
  "basket": [
    {
      "name": "Smindle ElePHPant plushie",
      "type": "unit",
      "price": 295.45
    },
    {
      "name": "Syntax & Chill",
      "type": "subscription",
      "price": 175.00
    }
  ]
}

```

*Response*

`201` Created: Order saved successfully.

`400` Bad Request: Validation error.

## Subscription Handling
When a subscription is included in the basket:
1. The application sends a `POST` request to the third-party endpoint: `https://very-slow-api.com/orders`.
2. Payload format for the third-party endpoint:
   ```json
   {
     "ProductName": "Syntax & Chill",
     "Price": 175.00,
     "Timestamp": "2025-01-21T12:00:00Z"
   }
   ```
3. This process is handled asynchronously using Laravel's queue system to prevent blocking the main application flow.
4. To process queued jobs, ensure that the worker is running:
```bash
php artisan queue:work
```
This command continuously processes jobs in the queue.
### Notes:
Make sure the queue driver is correctly configured in your .env file. For example:

```makefile
QUEUE_CONNECTION=database
```

A migration for the jobs table is included and can be set up using:
```bash
php artisan queue:table
php artisan migrate
```