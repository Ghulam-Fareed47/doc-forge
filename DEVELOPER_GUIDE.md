# Developer Guide: PDF Merger Application

## Project Architecture

This project is a modern web application built with a **Laravel 12 API** backend and a **Vue 3 + Vite** frontend.

### Key Design Decisions
1.  **Frontend-First Processing**: All PDF operations (Merge, Split, Compress, etc.) are performed **client-side** in the browser using `pdf-lib` and `pdfjs-dist`.
    *   *Why?* This eliminates the need for Ghostscript or heavy backend processing, ensures 100% data privacy (files never leave the user's device for processing), and provides immediate feedback.
    *   *Backend Role*: The Laravel backend is used strictly for **Authentication** (Breeze/Sanctum) and **Usage Logging**.

2.  **Authentication**:
    *   Uses **Laravel Sanctum** (Stateful) for SPA authentication.
    *   Frontend and Backend share the same domain (or localhost ports) and communicate via cookies.
    *   `authStore` (Pinia) manages the user state on the frontend.

3.  **Usage Limits**:
    *   **Guest Users**: Limited to 2 free uses per tool. Tracked via `localStorage`.
    *   **Registered Users**: Unlimited usage.
    *   **Enforcement**: The `usageService.js` checks limits before every operation.

## Directory Structure

### Backend (`/pdf-merger-backend`)
*   **`app/Http/Controllers/`**:
    *   `AuthController`: Handles login, registration, logout (via Breeze).
    *   `UsageController`: Receives logs from the frontend when a tool is successfully used.
*   **`routes/api.php`**: Defines the API endpoints for user fetching and usage logging.
*   **`config/cors.php`**: Configured to allow requests from the Vue frontend (`localhost:5173`).

### Frontend (`/pdf-merger-frontend`)
*   **`src/views/`**: Contains the page components for each tool (e.g., `MergePdfPage.vue`, `SplitPdfPage.vue`).
*   **`src/services/`**:
    *   `pdfService.js`: The core logic for PDF manipulation. Contains `mergePdfs`, `splitPdf`, `compressPdf`, etc.
    *   `usageService.js`: Manages guest limits and API logging.
*   **`src/stores/`**:
    *   `auth.js`: Pinia store for user session management.

## Setup Instructions

### Prerequisites
*   PHP 8.2+
*   Composer
*   Node.js & npm
*   MySQL (or other database)

### Backend Setup
1.  Navigate to `pdf-merger-backend`.
2.  Install dependencies: `composer install`.
3.  Copy `.env.example` to `.env` and configure your database.
4.  Generate key: `php artisan key:generate`.
5.  Run migrations: `php artisan migrate`.
6.  Start server: `php artisan serve` (Runs on port 8000).

### Frontend Setup
1.  Navigate to `pdf-merger-frontend`.
2.  Install dependencies: `npm install`.
3.  Start dev server: `npm run dev` (Runs on port 5173).

## Authentication Flow
1.  **Sign Up**: Users register at `/register`. Laravel creates the user and logs them in.
2.  **Login**: Users login at `/login`. Laravel issues a session cookie.
3.  **Persistence**: `App.vue` calls `authStore.initialize()` on mount to check if a valid session exists.

## Admin & Usage Tracking
*   **Usage Logs**: Every successful PDF operation logs an entry to the `usages` table in the database, including the tool name and file size.
*   **Admin Panel**: An administrative dashboard (using Filament) is planned to visualize this data but is currently pending installation due to dependency issues.
