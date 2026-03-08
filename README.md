# Optimization of Ina Zaoui's Photography Portfolio Website

A Symfony-based photography portfolio application optimized for performance, security, and maintainability.

---

<p align="center">

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/Symfony-7.4-000000?style=flat-square&logo=symfony&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat-square&logo=postgresql&logoColor=white)
![Tests](https://img.shields.io/badge/tests-PHPUnit-green)
![CI](https://img.shields.io/badge/CI-GitHub_Actions-blue)

</p>

## Table of Contents

- [Project Context](#project-context)
- [Project Description](#project-description)
- [Main Features](#main-features)
- [Improvements Implemented](#improvements-implemented)
- [Technical stack](#technical-stack)
- [Prerequisites](#prerequisites)
- [Key Dependencies](#key-dependencies)
- [Installation](#installation)
- [Usage](#usage)
- [Performance Optimization](#performance-optimization)
- [Technical Documentation](#technical-documentation)
- [Contributing](#contributing)
- [Credits](#credits)

---

## Project Context

This project was carried out as part of an OpenClassrooms training project.

The objective was not only to improve and secure the application, but also to prepare a proper handover for the next developer. 

---

## Project Description

Ina Zaoui is a photography portfolio web application developed with Symfony.

It includes a public front office for visitors and a secured back office for authenticated users.  
The application allows an administrator to manage albums, media, and guest accounts, while guest users can manage only their own media.

---

## Main Features

- Public portfolio browsing
- Album management
- Media management
- Guest account creation and administration
- Guest authentication
- Role-based access control
- Secure media upload handling

---

## Improvements Implemented

- [x] Migrated the project from **Symfony 5.4 to Symfony 7.4 (LTS)**
- [x] Secured **media uploads and authentication handling**
- [x] Added **guest account management** with email invitations and password setup
- [x] Improved performance by **removing N+1 queries, compressing images, and minifying assets**
- [x] Improved code quality with **automated tests and static analysis**
- [x] Wrote **documentations** for future developers
- [x] Set up a **continuous integration pipeline**

---

## Technical Stack

### Core Stack
- Framework: Symfony 7.4
- Language: PHP 8.4
- Database: PostgreSQL 16
- ORM: Doctrine ORM 3.x
- Templating Engine: Twig 3.x

### Development and Quality Tools
- Testing: PHPUnit
- Static Analysis: PHPStan
- Coding Standards: PHP CS Fixer

### Performance and Media Optimization
- Image Optimization: LiipImagineBundle
- Asset Minification: SensioLabs Minify Bundle

### Testing Utilities
- Test Data / Fixtures: Zenstruck Foundry, Doctrine Fixtures Bundle
- Database Test Isolation: DAMA Doctrine Test Bundle

### Automation
- Continuous Integration: GitHub Actions

## Prerequisites

Before installing and running this project, make sure you have:
- PHP : 8.2+
- Composer
- Symfony CLI
- PostgreSQL: 16+

Recommended tools:
- Docker
- PHPUnit
- PHPStan
- PHP CS Fixer

---

## Key Dependencies

- Symfony Mailer
- LiipImagineBundle
- SensioLabs Minify Bundle
- Zenstruck Foundry
- DAMA Doctrine Test Bundle
- Doctrine Fixtures Bundle

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/JingFERMENT/OC-P15-inazaoui
cd OC-P15-inazaoui
```

### 2. Install dependencies
```bash
composer install 
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

Run the tests with PHPUnit
```bash
php bin/phpunit
```

### Generate the coverage report
```bash
php bin/phpunit --coverage-html var/coverage
open var/coverage/index.html
```

**Test coverage** reaches **81.5%**, exceeding the required 70%.
See the full report here: [Coverage Report](public/coverage-report.html)

### Run code quality checks

Run static analysis:

```bash
vendor/bin/phpstan analyse
```
Run coding standards checks:

```bash
vendor/bin/php-cs-fixer fix
```

## Performance Optimization

Main optimization areas:

- **Database query optimization** to reduce N+1 query issues
- **Caching** to improve response time for frequently accessed pages
- **Pagination** to limit the number of large images loaded at once
- **Image optimization** using LiipImagineBundle
- **CSS and asset minification** using SensioLabs Minify Bundle

These improvements help reduce server workload and improve page loading speed.

For detailed analysis and measurements, see the full report:  
[Performance Report](docs/performance-report.pdf)

## Technical Documentation

For a more detailed explanation of the application structure, entities, main flows, and implementation choices, see:[Technical Documentation](technical-documentation.md)

## Contributing

To contribute to this project, please read [CONTRIBUTING.md](CONTRIBUTING.md).

## Credits

- Original project: OpenClassrooms Student Center
- Portfolio project: Ina Zaoui
- Development, optimization, testing, and documentation: Jing Zhang Ferment
