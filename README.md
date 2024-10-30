## Transaction Processing System

Design and implement a simple transaction processing system that demonstrates your ability to handle concurrent operations, ensure data integrity, and implement basic security measures.

- Create a simple RESTful API with the following endpoints:
	- POST /transaction: Create a new transaction
	- GET /balance: Retrieve the current balance for a user
- Implement a data store to keep track of user balances and transactions.
- Ensure that the system can handle concurrent transactions without allowing double-spending or creating duplicate records.
- Implement a basic locking mechanism to prevent race conditions when updating balances.
- Add a simple authentication mechanism to secure the API endpoints.
- Write unit tests to verify the correctness of your implementation.
- Provide a brief explanation of how you would scale this system and improve its architecture for production use.


## Prerequisites

Before you start, ensure you have the following installed:

- Docker
- PHP version 8.3 or later
- Web browser
- Shell or terminal environment

## Getting Started

1. **Clone the repository:**

   ```bash
   git clone git@github.com:degod/transaction_system.git
   ```

2. **Navigate to the project directory:**

	```bash
	cd transaction_system/
	```

3. **Start the application with Laravel Sail:**

	```bash
	docker-compose up --build -d
	```

4. **Logging in to container shell:**

	```bash
	docker-compose exec app bash
	```

5. **Completing the setup:**

	```bash
	php artisan migrate:fresh && php artisan test
	```

6. **Exiting container shell:**

	```bash
	exit
	```


## Contributing

If you encounter bugs or wish to contribute, please follow these steps:

- Fork the repository and clone it locally.
- Create a new branch (`git checkout -b feature/fix-issue`).
- Make your changes and commit them (`git commit -am 'Fix issue'`).
- Push to the branch (`git push origin feature/fix-issue`).
- Create a new Pull Request against the `main` branch, tagging `@degod`.

## Contact

For inquiries or assistance, you can reach out to Godwin Uche:

- `Email:` degodtest@gmail.com
- `Phone:` +2348024245093
