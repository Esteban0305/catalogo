# My PHP Nginx App

This project is a simple PHP application that uses SQLite as its database and is served using Nginx. Below are the instructions for setting up and running the application.

## Project Structure

```
my-php-nginx-app
├── src
│   ├── index.php          # Entry point of the application
│   └── db
│       └── database.sqlite # SQLite database file
├── nginx
│   └── default.conf       # Nginx configuration file
├── Dockerfile              # Dockerfile for building the PHP application image
├── docker-compose.yml      # Docker Compose file for managing services
└── README.md               # Project documentation
```

## Prerequisites

- Docker
- Docker Compose

## Setup Instructions

1. Clone the repository or download the project files.
2. Navigate to the project directory:
   ```
   cd my-php-nginx-app
   ```
3. Build and start the application using Docker Compose:
   ```
   docker-compose up --build
   ```
4. Access the application in your web browser at `http://localhost:8080`.

## Usage

- The application connects to an SQLite database located at `src/db/database.sqlite`.
- You can modify the `index.php` file to change the application logic.
- The Nginx configuration can be adjusted in `nginx/default.conf` as needed.

## License

This project is open-source and available under the MIT License.