# Contributing To Ina Zaoui's Photography Portfolio Website

Thank you for contributing to this project.

This document explains how to contribute to the project and which rules to follow before submitting your work.

---

## Table of Contents

- [Report an Issue](#report-an-issue)
- [Suggest a Feature](#suggest-a-feature)
- [Contribution Workflow](#contribution-workflow)
- [Branch Naming Convention](#branch-naming-convention)
- [Commit Message Convention](#commit-message-convention)
- [Code Conventions](#code-conventions)
- [Code Quality](#code-quality)
- [Tests](#tests)
- [Documentation](#documentation)
- [Pull Request Guidelines](#pull-request-guidelines)
- [Contribution Validation Policy](#contribution-validation-policy)
- [Review checklist](#review-checklist)
- [Good Practices](#good-practices)

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

## Contribution Workflow

To contribute to the project, please follow these steps:

1. Read the `README.md` and the relevant project documentation.
2. Check whether an issue or feature request already exists.
3. Create a dedicated branch from `main`.
4. Implement your changes.
5. Run code quality tools and tests locally.
6. Update the documentation if needed.
7. Commit your changes using a clear and consistent commit message.
8. Push your branch to GitHub.
9. Open a Pull Request describing your contribution.
10. Address review comments and requested changes before merge.

Direct commits to the `main` branch should be avoided. All changes should go through a dedicated branch and a Pull Request.

## Branch Naming Convention

Each contribution must be developed in a dedicated branch.

Use the following naming convention:

- `feat/short-description`
- `fix/short-description`
- `docs/short-description`
- `test/short-description`
- `refactor/short-description`
- `chore/short-description`

Examples:

```bash
git checkout -b feat/add-album-pagination
git checkout -b fix/guest-access-control
git checkout -b docs/update-installation-guide
git checkout -b test/add-homepage-functional-tests
git checkout -b refactor/simplify-media-query
git checkout -b chore/update-dependencies
```

## Commit Message Convention

Commit messages should be clear, concise, and consistent.

This project follows a convention inspired by Conventional Commits.

Recommended prefixes:
- feat: for a new feature
- fix: for a bug fix
- docs: for documentation changes
- test: for test-related changes
- refactor: for code refactoring without functional changes
- chore: for maintenance or technical tasks

Examples:
```bash
feat: add guest invitation workflow
fix: secure media upload validation
docs: update installation instructions
test: add guest access tests
refactor: simplify album repository query
chore: update development dependencies
```

## Code Conventions

Contributors should follow the existing project structure and coding style.

Please respect the following rules:

- follow PSR-12 formatting rules
- follow Symfony best practices
- keep controllers focused on HTTP request handling
- move reusable business logic to services or repositories
- write clear and explicit variable, class, and method names
- keep Twig templates simple, readable, and maintainable
- avoid duplicated code whenever possible

Any new code should integrate naturally with the existing architecture.

## Code Quality

Before submitting your work, run the project quality tools locally:

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

## Documentation

If your change affects how the project works, also update the documentation if needed.

Main files to update may include:

- README.md
- technical-documentation.md
- CONTRIBUTING.md

## Pull Request Guidelines

When your work is ready:
- push your branch to GitHub
- open a Pull Request
- write a clear title and description
- explain the purpose of the change
- mention any important technical details
- link the related issue if applicable

Before opening a Pull Request, make sure that:

- the code works correctly
- tests pass
- code quality checks pass
- documentation is updated if necessary

Pull Requests should remain focused on a single subject whenever possible.

## Contribution Validation Policy

A contribution can be merged only if:
- the code is functional
- automated tests pass
- code quality checks pass
- the contribution respects the project conventions
- the documentation is updated when necessary
- no critical regression has been identified
- the Pull Request has been reviewed and approved

If one or more of these conditions are not met, changes may be requested before the contribution can be merged.

Direct pushes to the main branch are discouraged. Contributions should be validated through the Pull Request process.

## Review Checklist

- [x] Tests pass
- [x] PHPStan passes
- [x] PHP-CS-Fixer passes
- [x] Documentation updated
- [x] No regression identified

## Good Practices

To keep the project maintainable, contributors are encouraged to follow these good practices:

- keep each Pull Request focused on one topic
- avoid mixing unrelated changes in the same branch
- do not leave commented-out code or debug statements
- add or update tests when application behavior changes
- update documentation when needed
- respect the existing Symfony architecture
- verify migrations carefully before submitting database changes
- pay attention to performance when working with database queries, media loading, or front-end rendering
- prefer readable and maintainable code over overly complex solutions

Consistency, readability, and reliability are important for the long-term maintenance of the project.

---

Thank you for your contribution.