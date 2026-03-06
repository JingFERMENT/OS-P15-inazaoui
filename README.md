# Ina Zaoui

![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![Symfony](https://img.shields.io/badge/Symfony-7.4-black)
![Tests](https://img.shields.io/badge/tests-PHPUnit-green)
![Docker](https://img.shields.io/badge/Docker-enabled-blue)

## Project description

Ina Zaoui is a photography portfolio web application developed with Symfony. 
The project aims to modernize and improve an existing website used to showcase landscape photography from around the world.

The application includes:
- a **front office** for visitors to explore the portfolio;
- a **back office** for the administrator to manage albums, media, and guest accounts, and for **guest photographers**, allowing them to manage their own media.

The main objectives of the project were to:
- migrate the application to a more recent version;
- improve application security and maintainability;
- secure media uploads;
- implement guest account management;
- optimize page performance;
- add automated tests;
- write technical documentation for future developers;
- implement a continuous integration pipeline.

This project also contributed to the development of professional skills such as responsibility, time management, communication, and collaboration.

---

## Technical Stack

- **Language:** PHP 8.4
- **Framework:** Symfony 7.4
- **Database:** PostgreSQL 16
- **ORM:** Doctrine ORM 3.x
- **Templating Engine:** Twig 3.x
- **Containerization:** Docker and Docker Compose
- **Continuous Integration:** GitHub Actions

### Development and Code Quality Tools

- **PHPUnit** for automated testing
- **PHPStan** for static analysis
- **PHP CS Fixer** for coding standards

## Key Dependencies

This project relies on several Symfony bundles and PHP packages, including:

- **Symfony Mailer**
- **LiipImagineBundle**
- **SensioLabs Minify Bundle**
- **Zenstruck Foundry**
- **DAMA Doctrine Test Bundle**
- **Doctrine Fixtures Bundle**

---

## Prerequisites

Before starting, make sure you have installed:

- PHP : >8.2
- Composer
- Symfony CLI
- PostgreSQL

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/JingFERMENT/OC-P15-inazaoui
cd ina-zaoui

### 2. Install dependencies
compse install 

3. Configure environment variables

Create or update your .env.local file with your local configuration:

APP_ENV=dev

DATABASE_URL="postgresql://username:password@127.0.0.1:5432/ina_zaoui?serverVersion=16&charset=utf8"

MAILER_DSN=null://null

4. Create the database
php bin/console doctrine:database:create

5. Run migrations
php bin/console doctrine:migrations:migrate

6. Load fixtures if available
php bin/console doctrine:fixtures:load

How to install and run the project

Start the Symfony server
symfony server:start

Then open your browser and go to:
http://127.0.0.1:8000

USAGE
The application contains two main parts:

Front Office

The front office is the public part of the website.
Visitors can browse the portfolio pages and discover Ina Zaoui’s photography work.

Back Office / Admin

The admin area allows authenticated users to manage content.

Depending on the role:

Ina (admin) can manage albums, all media, and guests,

Guests can only access and manage their own media.


Main features include:

viewing albums and media,

uploading images,

managing guest accounts,

blocking or deleting guests,

accessing guest pages. 

Tests
The project requires a code coverage report above 70%.
This project includes automated tests to ensure the front office works correctly and to maintain code quality.

Run PHPUnit tests
php bin/phpunit

Run tests with coverage
php bin/phpunit --coverage-html var/coverage

After running this command, open the coverage report in:
open var/coverage/index.html

Useful quality commands
Run PHPStan:
vendor/bin/phpstan analyse

Run PHP CS Fixer:
vendor/bin/php-cs-fixer fix

Contribute to the project
Please refer to CONTRIBUTING.md


