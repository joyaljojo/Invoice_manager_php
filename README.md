# Invoice_manager_php

## Overview

The Invoice Manager is a web-based PHP application designed to manage and organize invoices for various clients. It provides features to view, filter, add, update, and delete invoices, making it easier to manage financial records.

## Features

- **View Invoices:** View a list of invoices categorized by their status: "Draft," "Pending," or "Paid."
- **Filter by Status:** Easily filter invoices by their status using the navigation menu.
- **Add Invoices:** Add new invoices to the system with client details, amounts, and statuses.
- **Update Invoices:** Modify invoices with a "Paid" status to keep records up-to-date.
- **Delete Invoices:** Remove invoices from the system when needed.
- **View Invoice PDF:** Access PDF copies of invoices if they exist.

## Technology Stack

- **Backend:** PHP with a MySQL database.
- **Frontend:** HTML, CSS, and Bootstrap for styling.
- **Database:** PDO for database connectivity.
- **Dependencies:** Bootstrap for frontend styling.

## Application Structure

- `index.php`: Main landing page to display invoices based on selected statuses.
- `add.php`: Page to add new invoices to the system.
- `update.php`: Page to update invoices with a "Paid" status.
- `delete.php`: Page to delete invoices from the system.
- `style.css`: Custom CSS styles for the application.
- `data.php`: Includes code for database connection and initialization.
- `documents/`: Directory to store PDF copies of invoices.

## Getting Started

1. Set up a PHP environment with a configured MySQL database.
2. Import the provided database schema and tables from `data.sql` into your MySQL database.
3. Update the database connection details in `data.php` to match your environment.
4. Host the application files on your web server.
5. Access `index.php` through your web browser to start using the Invoice Manager.
