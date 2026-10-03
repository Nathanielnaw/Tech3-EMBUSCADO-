# POS Foundations (CodeIgniter 4)

This project continues **IT0049 TFA1** with **TFA2: From Arrays to a Real Database**. The four POS pages and navigation remain in place; the Customer Accounts and User Accounts pages now read from MySQL through CodeIgniter models.

## Prerequisites

- PHP 8.2 or newer
- Composer
- PHP extensions `intl`, `mbstring`, `mysqli`, and `zip` (Zip is needed for Composer archive downloads)
- MySQL or MariaDB (XAMPP includes MariaDB and the MySQL command-line client)

## Setup

From the project directory, install the Composer dependencies:

```bash
composer install
```

Copy `.env.example` to `.env` if you do not already have an `.env` file. Set your own local database username and password there. For XAMPP with its default local MariaDB setup, the relevant settings are:

```dotenv
app.baseURL = 'http://localhost:8080/'
database.default.hostname = 127.0.0.1
database.default.database = pos_db
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Use your actual MySQL credentials if they differ. `.env` is ignored by Git; `.env.example` contains no credentials. Change `app.baseURL` when running at a different URL.

## Database setup

From the project directory, import the schema and sample data into MySQL. These commands work with the MySQL command-line client in PowerShell; use `C:\xampp\mysql\bin\mysql.exe` in place of `mysql` if it is not on your PATH. Add `--password` if your MySQL account needs a password (the client will prompt for it).

```powershell
mysql --user=root --execute="source database/schema.sql"
mysql --user=root --execute="source database/seed.sql"
```

The schema creates the `pos_db` database and the exact `customers` and `users` columns required by TFA2. The seed script adds five fictional records to each table on a fresh database. Re-running it does not overwrite rows with the same ID or username.

For submission, [database/pos_db_export.sql](database/pos_db_export.sql) is a self-contained SQL export of that schema and fictional sample data. It has no credentials and can be imported into a fresh MySQL or MariaDB installation with:

```powershell
mysql --user=root --execute="source database/pos_db_export.sql"
```

The export contains synthetic sample records, not a dump of an existing local database that may contain private customer information.

## Run the application

Start CodeIgniter's development server:

```bash
php spark serve
```

Open <http://localhost:8080/> in a browser.

## Routes

| URL | Page | Controller |
| --- | --- | --- |
| `/` | Landing page | `Pages::home` |
| `/about` | About page | `Pages::about` |
| `/customers` | Customer Accounts | `Customers::index` |
| `/users` | User Accounts | `Users::index` |

All four pages share the main navigation and use framework URL helpers for links. The two listing controllers call `CustomerModel` and `UserModel`; their views still render and escape each row with `foreach`. The Users page shows `created_at` where TFA1 showed a role because the TFA2 `users` table has no `role` column.

## Data scope

Customer and staff records are stored in MySQL, not static controller arrays. The SQL files make the database setup repeatable; the application only reads these records and does not require edit forms.

## Student submission steps

The project repository is available at <https://github.com/Nathanielnaw/Tech2-EMBUSCADO->.

1. Import the SQL, set your local `.env`, run the project, and verify the four routes.
2. Submit the GitHub repository URL above.
3. Submit `database/pos_db_export.sql` as the database export.
4. Deploy the application to an authorized hosting service whose document root points to the `public` directory, then submit the hosted URL. No hosted application has been created or verified yet.
