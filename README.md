# PDF Merger & Tools

A powerful, 100% free, and secure web application for managing PDF documents.
This application runs entirely in your browser—your files never leave your device for processing, ensuring maximum privacy and speed.

## 🚀 Features

### Core PDF Tools
*   **Merge PDF**: Combine multiple PDF documents into a single file. Drag and drop to reorder.
*   **Split PDF**: Extract specific pages or ranges (e.g., "1-5, 10") into a new document.
*   **Compress PDF**: Reduce file size while maintaining high quality.
*   **Watermark**: Add custom text watermarks with adjustable position and opacity.
*   **Extract Text**: instantly pull text content from any PDF.
*   **Images to PDF**: Convert JPG, PNG, GIF, or BMP images into a single PDF document.

### User Features
*   **Secure & Private**: All processing happens locally in your browser.
*   **Dark Mode**: Fully supported dark theme for comfortable viewing.
*   **Responsive Design**: Works on desktop, tablet, and mobile.
*   **Guest Access**: Try tools for free (limited to 2 uses per day).
*   **Unlimited Access**: **Sign Up** for a free account to unlock unlimited usage.

## 🛠️ Installation & Setup

### Prerequisites
*   Node.js (for the frontend)
*   PHP & Composer (for the backend API)

### Quick Start

1.  **Clone the repository**
    ```bash
    git clone <repository-url>
    cd pdf-merger
    ```

2.  **Setup Backend (API)**
    ```bash
    cd pdf-merger-backend
    composer install
    cp .env.example .env  # Configure your database settings here
    php artisan key:generate
    php artisan migrate
    php artisan serve
    ```

3.  **Setup Frontend (UI)**
    ```bash
    cd pdf-merger-frontend
    npm install
    npm run dev
    ```

4.  **Access the App**
    Open your browser and visit: `http://localhost:5173`

## 📖 Usage Guide

### Authentication
*   **Guests**: You can use any tool immediately but are limited to **2 operations**.
*   **Register**: Click "Sign up" in the top right to create an account. This grants you **unlimited access**.
*   **Login**: Returning users can log in to access their account.

### Admin & Monitoring
*   The application tracks tool usage stats (tool name, file size, timestamp) in the backend database (`usages` table).
*   *Note: The visual Admin Dashboard is currently pending installation.*

## 🏗️ For Developers
For detailed architecture, directory structure, and code patterns, please refer to the [Developer Guide](DEVELOPER_GUIDE.md).

---
*Built with Vue 3, Laravel 12, and pdf-lib.*
