# TimeTrack Development Log

This document tracks the development progress, architectural decisions, and important information for the TimeTrack project.

## Project Setup & Architecture

- **Stack:**
  - **Frontend:** React + Vite + TypeScript (running on port 5173)
  - **Backend:** Laravel (PHP 8.2)
  - **Database:** Supabase (PostgreSQL)
  - **Containerization:** Docker Compose
- **Architecture:**
  - The backend is served by an **Nginx** container that acts as a reverse proxy to a separate **PHP-FPM** container. This is a standard, production-ready setup.
  - The frontend is served by the Vite development server.
  - Services are connected via a shared Docker network (`app-network`).
  - Laravel connects to the host's Supabase instance via `host.docker.internal`.

## Authentication

- **Method:** Implemented using **Laravel Sanctum** for token-based API authentication.
- **Endpoints:**
  - `POST /api/login`: Authenticates a user and returns a Sanctum token.
  - `GET /api/me`: Returns the currently authenticated user's data (protected by `auth:sanctum` middleware).
- **Test User:**
  - **Email:** `user@user.com`
  - **Password:** `user`
- **User Creation:** A custom Artisan command `php artisan app:create-user` is available to quickly create new users for testing.

## Database Schema

- **Management:** Database schema changes are managed via **Supabase Migrations**.
- **Tables:**
  - `auth.users`: (Supabase default) Stores user information.
  - `public.users`: (Laravel default) Created by initial migrations. Note: The primary user table for auth is `auth.users`.
  - `public.clocking_days`: Stores daily check-in/out times. `user_id` is a `UUID` that references `auth.users(id)`.
  - `public.horas_teoricas`: Stores theoretical work hours for specific dates.

---

_This log will be updated as new features are implemented and decisions are made._
