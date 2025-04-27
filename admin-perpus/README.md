# filepath: admin-perpus/README.md
# Project Title: Admin Perpus

## Description
Admin Perpus is a Laravel-based application designed for managing a library system. This project allows users to upload book files and cover images, facilitating the management of library resources.

## Features
- User-friendly interface for uploading books and cover images.
- Organized structure for managing library entries.

## Installation
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd admin-perpus
   ```
3. Install dependencies:
   ```
   composer install
   npm install
   ```
4. Set up your environment file:
   ```
   cp .env.example .env
   ```
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Run migrations:
   ```
   php artisan migrate
   ```

## Usage
To access the book upload feature, navigate to the upload page. You can upload a book file and a cover image through the provided form.

## Routes
- `/upload` - Displays the upload form.
- `/upload/store` - Handles the form submission for book and cover image uploads.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License.