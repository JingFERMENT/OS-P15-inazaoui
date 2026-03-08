# Contributing To Ina Zaoui's Photography Portfolio Website

Thank you for contributing to this project.

This file explains how to report an issue, suggest an improvement, or contribute code, tests, or documentation.

---

## Table of Contents

- [Report an Issue](#report-an-issue)
- [Suggest a Feature](#suggest-a-feature)
- [Contribute Code](#contribute-code)
- [Code Conventions](#code-conventions)
- [Code Quality](#code-quality)
- [Tests](#tests)
- [Create a Pull Request](#create-a-pull-request)
- [Documentation](#documentation)
- [Commit Messages](#commit-messages)

---

## Report an Issue

If you encounter a bug or unexpected behavior, please open an issue and describe:

- what the problem is
- how to reproduce it
- what you expected to happen
- what actually happened

If possible, include screenshots, logs, or error messages.

Clear and reproducible issues help maintain the project more efficiently.

## Suggest a Feature

If you want to suggest a new feature or improvement, please explain:

- what you want to add
- why it would be useful
- how it could improve the project

## Contribute Code

Before starting:

1. read the `README.md`
2. check all the existing documentations
3. create a dedicated branch

Examples:

```bash
git checkout -b feature/new-feature
git checkout -b fix/bug-name
git checkout -b docs/update-readme
```

## Code Conventions

Please try to: 

- respect **PSR-12** formatting rules
- follow **Symfony best practices**
- keep controllers focused on handling requests
- move reusable logic to **services or repositories** when needed
- write clear variable and method names
- keep Twig templates simple and readable

## Code Quality

Please try to follow the existing project structure and write clear, readable code.

Before submitting your work, run:

```bash
vendor/bin/phpstan analyse
vendor/bin/php-cs-fixer fix
```
## Tests

Tests are important to ensure the application remains stable.

If you modify the code:
- make sure existing tests still pass
- add tests when relevant
- ensure the test coverage remains above 70%

Run the test suite with:
```bash
php bin/phpunit
```

## Create a Pull Request

When your work is ready:
- push your branch to GitHub
- open a Pull Request
- describe the changes you made

Before creating a pull request, make sure that:
- the code works correctly
- tests pass
- code quality checks pass

## Documentation

If your change affects how the project works, also update the documentation if needed.

Main files to update may include:

- README.md
- technical-documentation.md
- CONTRIBUTING.md

## Commit Messages

Write simple and clear commit messages.

Examples:
```bash
feat: add guest invitation workflow
fix: secure media upload validation
docs: update readme
test: add guest access tests
Pull Request
```
Clear commit messages make it easier to understand the history of the project.

---

Thank you for your contribution.