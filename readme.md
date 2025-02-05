# Habit Tracker Backend

This is the backend for a Habit Tracker application, built using PHP, Laravel, and MySQL. The backend allows users to register, log in, manage their habits, track progress, and view reports on habit performance. Token-based authentication is used to ensure secure access to protected routes. 🔐

## Features 🌟

- **User Authentication 📝**: Users can register, log in, and log out securely using token-based authentication (Sanctum). ✔️
- **Habit Management 🔄**: Users can create, read, update, and delete their habits.
- **Track Habit Progress 📅**: Users can track whether they completed or skipped habits on a daily basis.
- **Reports 📊**: Users can view habit streaks and completion summaries to monitor their progress.

## Technologies Used 🛠️

- **PHP**: Server-side scripting language used to build the backend.
- **Laravel**: PHP framework used for building RESTful APIs and handling backend logic.
- **MySQL**: Database for storing user, habit, and progress data.
- **Sanctum**: Laravel's package for token-based authentication.
- **Postman**: For testing the API.

## Endpoints 🔌

### Authentication Routes 🚀

- **POST /register**: Registers a new user.
- **POST /login**: Logs in the user and generates a token. 🔑
- **POST /logout**: Logs the user out (requires authentication). 🚪

### Habit Routes (Protected by token authentication) 🔒

- **GET /habits**: Fetches all habits for the authenticated user.
- **POST /habits**: Creates a new habit for the authenticated user. ➕
- **GET /habits/{id}**: Fetches a specific habit by ID.
- **PUT /habits/{id}**: Updates a specific habit by ID. ✏️
- **DELETE /habits/{id}**: Deletes a specific habit by ID. 🗑️

### Progress Routes (Protected by token authentication) 🏃‍♀️

- **POST /habits/{id}/track**: Tracks the completion or skipping of a habit for a specific date. ✅❌
- **GET /habits/{id}/history**: Fetches the history of a specific habit's progress. 📈

### Report Routes (Protected by token authentication) 📑

- **GET /reports/streaks/{id}**: Fetches the current streak for a specific habit. 🔥
- **GET /reports/completion**: Fetches the completion summary for all habits. 🏆

## Middleware Functions 🛡️

- **auth:sanctum**: Ensures that routes are only accessible by authenticated users with a valid token.
- **auth:api**: Verifies that the user is logged in and authorized for protected routes.

## Testing 🧪

I write unit tests to ensure the backend functionality is working as expected.
