# POS Foundations (CodeIgniter 4)

This project continues the IT0049 POS activities through **TFA3: Making It Editable**. The original four pages and navigation remain in place. Customer and user records live in MySQL and can now be created and edited through validated forms. User avatars can be uploaded when editing a record.

## Prerequisites

- PHP 8.2 or newer
- Composer
- PHP extensions `intl`, `mbstring`, `mysqli`, `fileinfo`, and `gd`; `zip` is useful for Composer archive downloads
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

Use your actual MySQL credentials if they differ. `.env` is ignored by Git; `.env.example` contains no credentials. Change `app.baseURL` when running at a different URL. In XAMPP, enable `extension=gd` (and `extension=fileinfo` if disabled) in `php.ini` and restart PHP/Apache before testing uploads. PHP's `upload_tmp_dir` must also point to a writable directory.

## Database setup

From the project directory, import the schema and sample data into MySQL. These commands work with the MySQL command-line client in PowerShell; use `C:\xampp\mysql\bin\mysql.exe` in place of `mysql` if it is not on your PATH. Add `--password` if your MySQL account needs a password (the client will prompt for it).

```powershell
mysql --user=root --execute="source database/schema.sql"
mysql --user=root --execute="source database/seed.sql"
```

The schema creates the `pos_db` database and the TFA2 tables, including TFA3's nullable `users.avatar` column. The seed script adds five fictional records to each table on a fresh database. Re-running it does not overwrite rows with the same ID or username.

If you already have the TFA2 database, preserve its existing rows and add the avatar column with:

```bash
php spark migrate
```

The `AddAvatarToUsers` migration checks whether the column exists, so it also works after importing the updated schema or export. If your existing TFA2 database was created before this migration, run it once before opening the Users page. Do not re-import the SQL export over private data.

For submission, [database/pos_db_export.sql](database/pos_db_export.sql) is a self-contained SQL export of the fresh TFA3 schema and fictional sample data. It has no credentials and can be imported into a fresh MySQL or MariaDB installation with:

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
| `/customers/new` | New Customer form | `Customers::create` |
| `/customers/{id}/edit` | Edit Customer form | `Customers::edit` |
| `/users` | User Accounts | `Users::index` |
| `/users/new` | New User form | `Users::create` |
| `/users/{id}/edit` | Edit User form and optional avatar upload | `Users::edit` |

The forms submit by POST to `/customers`, `/customers/{id}`, `/users`, and `/users/{id}`. All forms include CodeIgniter CSRF tokens. The two listing controllers call `CustomerModel` and `UserModel`; their views render and escape each row with `foreach`. The Users page shows `created_at` where TFA1 showed a role because the TFA2 schema has no `role` column.

## Data scope

Customer and staff records are stored in MySQL, not static controller arrays. Names and email addresses are validated; usernames must be unique, including when editing an existing user. Images are optional and can be uploaded on the user edit form only. The server accepts actual JPG/JPEG or PNG images of at most 2 MB, makes a 160×160 display copy with CodeIgniter's Image service, and saves it under `public/uploads/avatars/` using a random generated filename. Only that filename is stored in the database. Uploaded images are ignored by Git; back up that directory separately if you need to preserve real avatars. The listing uses `public/images/avatar-placeholder.svg` when no usable avatar exists.

## Student submission steps

The TFA3 repository is <https://github.com/Nathanielnaw/Tech3-EMBUSCADO->.

1. Import the SQL (or migrate an existing TFA2 database), set your local `.env`, run the project, and verify the listing and form routes.
2. Submit the TFA3 GitHub repository URL above.
3. Submit `database/pos_db_export.sql` as the database export. It contains only fictional seed data, not private records or uploaded images.
4. Deploy the application to an authorized hosting service whose document root points to `public`, configure its own database/environment securely, and submit the hosted URL. No hosted application has been created or verified yet.
