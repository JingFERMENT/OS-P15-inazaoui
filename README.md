# Optimization of a Photography Portfolio Website

## Project description

Ina Zaoui is a photography portfolio web application developed with Symfony. 
<p align="center">
  <img src="docs/apercu_site" alt="aperçu du site" width="500">
</p>

This application is divided into two main areas:

### Front Office

The public area of the website, where visitors can browse the portfolio and discover Ina Zaoui’s photography work.

### Back Office

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

## Technical Stack

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/Symfony-7.4-000000?style=flat-square&logo=symfony&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat-square&logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)
![PHPUnit](https://img.shields.io/badge/Tests-PHPUnit-6C3483?style=flat-square)
![CI](https://img.shields.io/badge/CI-GitHub_Actions-2088FF?style=flat-square&logo=githubactions&logoColor=white)

## Key Dependencies

- Symfony Mailer
- LiipImagineBundle
- SensioLabs Minify Bundle
- Zenstruck Foundry
- DAMA Doctrine Test Bundle
- Doctrine Fixtures Bundle

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


