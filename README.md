<p>
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Symfony-7.4-000000?style=flat-square&logo=symfony&logoColor=white" alt="Symfony">
  <img src="https://img.shields.io/badge/PostgreSQL-16-336791?style=flat-square&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Doctrine-ORM%203.x-FC6A31?style=flat-square&logo=doctrine&logoColor=white" alt="Doctrine ORM">
  <img src="https://img.shields.io/badge/Twig-3.x-85EA2D?style=flat-square&logo=twig&logoColor=black" alt="Twig">
  <img src="https://img.shields.io/badge/Docker-Containerized-2496ED?style=flat-square&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/GitHub%20Actions-CI-2088FF?style=flat-square&logo=githubactions&logoColor=white" alt="GitHub Actions">
</p>

<p>
  <img src="https://img.shields.io/badge/PHPUnit-Tests-6C3483?style=flat-square" alt="PHPUnit">
  <img src="https://img.shields.io/badge/PHPStan-Static%20Analysis-4B32C3?style=flat-square" alt="PHPStan">
  <img src="https://img.shields.io/badge/PHP%20CS%20Fixer-Code%20Style-8A2BE2?style=flat-square" alt="PHP CS Fixer">
</p>

<p>
  <img src="https://img.shields.io/badge/Symfony%20Mailer-Mailer-000000?style=flat-square&logo=symfony&logoColor=white" alt="Symfony Mailer">
  <img src="https://img.shields.io/badge/LiipImagineBundle-Images-4CAF50?style=flat-square" alt="LiipImagineBundle">
  <img src="https://img.shields.io/badge/SensioLabs%20Minify-Minify-FF9800?style=flat-square" alt="SensioLabs Minify Bundle">
  <img src="https://img.shields.io/badge/Zenstruck%20Foundry-Foundry-009688?style=flat-square" alt="Zenstruck Foundry">
  <img src="https://img.shields.io/badge/DAMA%20Doctrine-Test%20Bundle-3F51B5?style=flat-square" alt="DAMA Doctrine Test Bundle">
  <img src="https://img.shields.io/badge/Doctrine%20Fixtures-Fixtures-FC6A31?style=flat-square&logo=doctrine&logoColor=white" alt="Doctrine Fixtures Bundle">
</p>

---

# Optimization of a Photography Portfolio Website

---

<p align="center">
  <img src="docs/coverage_report.png" alt="Coverage report" width="300">
</p>

## Project description

Ina Zaoui is a photography portfolio web application developed with Symfony. 

This application is divided into two main areas:

### Front Office

The public area of the website, where visitors can browse the portfolio and discover Ina Zaoui’s photography work.

### Back Office / Admin

The private area of the website, where authenticated users can manage content according to their role:

- **Admin** can manage albums, all media, and guest accounts
- **Guests** can manage only their own media

### Improvements implemented

This project focused on modernizing, securing, and improving the application.  

The following enhancements have been implemented:
 1. migrated the project from **Symfony 5.4** to **Symfony 7.4 (LTS)**
 2. secured media uploads and authentication handling
 3. add **guest account management** with email invitations and password setup
 4. improved performance by fixing **N+1 queries**, compressing images, and minifying CSS files
 5. improved code quality with **automated tests and static analysis**
 6. wrote **technical documentation** for future developers
 7. set up a **continuous integration pipeline**.

---

## Prerequisites

- PHP : 8.2+
- Composer
- Symfony CLI
- PostgreSQL: 16+

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/JingFERMENT/OC-P15-inazaoui
cd OC-P15-inazaoui
```

### 2. Install dependencies
```bash
compose install 
```

### 3. Configure environment variables

Create or update your .env.local file with your local configuration:

```bash
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/ina_zaoui?serverVersion=16&charset=utf8"
MAILER_DSN=null://null
```

- `DATABASE_URL`: configure with your PostgreSQL credentials
- `MAILER_DSN`: configure with your mail service, or keep `null://null` to disable emails in development

### 4. Create the database
```bash
php bin/console doctrine:database:create
```

### 5. Run migrations
```bash
php bin/console doctrine:migrations:migrate
```

### 6. Load fixtures(optional)
```bash
php bin/console doctrine:fixtures:load
```

## Usage

### Start the Symfony server

```bash
symfony server:start
```

Then open your browser and go to:
http://127.0.0.1:8000


### Run the tests

PHPUnit
```bash
php bin/phpunit
```

Run tests with coverage and open the coverage report
```bash
php bin/phpunit --coverage-html var/coverage
open var/coverage/index.html
```

Run quality commands
PHPStan:
```bash
vendor/bin/phpstan analyse
```
PHP CS Fixer:
```bash
vendor/bin/php-cs-fixer fix
```

## PERFORMANCE IMPROVEMENTS

### Guests page
![Guests Page Before](docs/Guests_page_performance_before.png)
![Guests Page Before](docs/Guests_page_performance_before.png)

## Improve the query
### Add CACHE
### Add Paginations 
### Minfiy the css file
### Compress the images from jpg to webp





## CONTRIBUTION 
To contribute to this project, please read [CONTRIBUTING.md](CONTRIBUTING.md).


