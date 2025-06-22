# Time Tracking Application (Curso)

This is a simple, internal time tracking application built for a course. It features a Laravel backend and a React frontend, all managed within a Dockerized environment.

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: React, Vite, TypeScript, Tailwind CSS, shadcn/ui
- **Database**: Supabase (self-hosted PostgreSQL)
- **Infrastructure**: Docker Compose

## Project Structure

- `backend/`: Contains the Laravel API.
- `frontend/`: Contains the React SPA.

## Getting Started

### Prerequisites

- [Docker](https://www.docker.com/products/docker-desktop)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (v18 or higher)
- [PHP](https://www.php.net/) (v8.2 or higher)

### Setup

1.  **Clone the repository:**

    ```sh
    git clone <repository-url>
    cd timetrack-curso
    ```

2.  **Backend Setup:**

    ```sh
    cd backend
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

    _Update the `.env` file with your Supabase database credentials._

3.  **Frontend Setup:**
    ```sh
    cd ../frontend
    npm install
    ```

### Running the Application

1.  **Start the Docker containers** (once Supabase is configured in `docker-compose.yml`):

    ```sh
    docker-compose up -d
    ```

2.  **Run the Laravel backend:**

    ```sh
    cd backend
    php artisan serve
    ```

    _The backend will be available at `http://localhost:8000`._

3.  **Run the React frontend:**
    ```sh
    cd ../frontend
    npm run dev
    ```
    _The frontend will be available at `http://localhost:5173`._
