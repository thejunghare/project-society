# Project Society (ERP)

A comprehensive ERP solution for managing housing societies. This project is built with **Laravel (PHP)** and uses **Docker** to ensure it runs consistently across all operating systems.

## 📋 Prerequisites

Before you start, you need to install **Docker**. This is the only major tool you need, as it handles the Database and PHP automatically.

### 1. Install Docker Desktop

* **Mac:** [Download for Mac](https://docs.docker.com/desktop/install/mac-install/) (Choose "Apple Silicon" for M1/M2/M3/M4 chips, or "Intel" for older Macs).
* **Windows:** [Download for Windows](https://docs.docker.com/desktop/install/windows-install/).
* **Linux:** [Install Docker Engine](https://docs.docker.com/engine/install/).

### 2. Verify Installation

Open your terminal (Command Prompt on Windows) and type:

```bash
docker --version
docker-compose --version

```

If you see version numbers, you are ready to go.

---

## 🚀 Quick Start Guide

### Step 1: Clone the Repository

Open your terminal/command prompt and run:

```bash
git clone https://github.com/thejunghare/project-society.git
cd project-society

```

### Step 2: Setup Configuration

Create the environment file by copying the example.

**Mac / Linux:**

```bash
cp .env.example .env

```

**Windows (Command Prompt):**

```cmd
copy .env.example .env

```

**⚠️ Important:** Open the `.env` file in a text editor (like VS Code or Notepad) and update the **Database** section to match the Docker setup:

```ini
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=society
DB_USERNAME=root
DB_PASSWORD=root

```

*Note: Do not change `DB_HOST` to `localhost` or `127.0.0.1`. In Docker, the host must be the service name `mysql`.*

### Step 3: Run the Application

This command builds the environment and starts the servers.

```bash
docker-compose up -d --build

```

* Wait for the process to complete. You should see green `Started` messages for `society_mysql`, `app`, and `phpmyadmin`.
* **Note:** The first time you run this, it may take 5–10 minutes to download everything.

### Step 4: Install Dependencies & Setup Database

Now that the server is running, we need to install the PHP libraries and set up the database tables. Run these commands one by one:

**1. Install PHP Libraries:**

```bash
docker-compose exec app composer install

```

**2. Generate App Encryption Key:**

```bash
docker-compose exec app php artisan key:generate

```

**3. Set up the Database (Migrations & Seeds):**

```bash
docker-compose exec app php artisan migrate --seed

```

**4. Fix Folder Permissions (Crucial for Mac/Linux):**

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache

```

---

## 🌐 Accessing the App

Once Step 4 is complete, open your browser:

* **Main Application:** [http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)
* **Database Admin (phpMyAdmin):** [http://localhost:8080](https://www.google.com/search?q=http://localhost:8080)
* **Username:** `root`
* **Password:** `root`



---

## 🛠 Troubleshooting

### "Forbidden" or "403 Error"

This means Apache doesn't have permission to read your files. Run this command:

```bash
docker-compose exec app chmod -R 755 /var/www/html
docker-compose exec app chmod -R 777 /var/www/html/storage

```

### "Connection Refused" (Database Error)

If the app says it cannot connect to the database:

1. Check your `.env` file. Ensure `DB_HOST=mysql`.
2. If you just started the container, wait 30 seconds. The database takes a moment to initialize.

### "Class 'ZipArchive' not found" or Composer Errors

The container needs to be rebuilt to include the ZIP extension. Run:

```bash
docker-compose down
docker-compose up -d --build

```

### How to Stop the App

To stop the servers and free up memory:

```bash
docker-compose down

```

---

## 📂 Project Structure for Developers

* **`docker-compose.yml`**: The blueprint for the server. It defines the Web Server (App), Database (MySQL), and Database GUI (phpMyAdmin).
* **`Dockerfile`**: Instructions for building the PHP/Apache server.
* **`.env`**: Configuration file for passwords and database keys. **Never commit this file to GitHub.**

## ✨ Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-name`).
3. Commit your changes.
4. Push to the branch and submit a Pull Request.
