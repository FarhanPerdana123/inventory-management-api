# Contributing to Inventory API

Thank you for considering contributing to the Inventory API project! This document provides guidelines and instructions for contributing.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Commit Message Guidelines](#commit-message-guidelines)
- [Pull Request Process](#pull-request-process)
- [Issue Reporting](#issue-reporting)

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inspiring community for all. Please be respectful and constructive in your interactions.

### Expected Behavior

- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0 or higher
- Docker & Docker Compose (optional)
- Git

### Initial Setup

1. **Fork the repository**
   ```bash
   # Click the "Fork" button on GitHub
   ```

2. **Clone your fork**
   ```bash
   git clone https://github.com/FarhanPerdana123/inventory-management-api.git
   cd inventory-api
   ```

3. **Add upstream remote**
   ```bash
   git remote add upstream https://github.com/FarhanPerdana123/inventory-management-api.git
   ```

4. **Install dependencies**
   ```bash
   composer install
   ```

5. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Run the application**
   ```bash
   php artisan serve
   ```

## Development Workflow

### Branching Strategy

- `main` - Production-ready code
- `develop` - Integration branch
- `feature/*` - New features
- `bugfix/*` - Bug fixes
- `hotfix/*` - Urgent production fixes

### Creating a Feature Branch

```bash
# Update develop branch
git checkout develop
git pull upstream develop

# Create feature branch
git checkout -b feature/your-feature-name
```

### Keeping Your Branch Updated

```bash
# Fetch latest changes
git fetch upstream

# Rebase on develop
git rebase upstream/develop
```

## Coding Standards

### PHP Standards

This project follows **PSR-12** coding standards.

**Run code style checker:**
```bash
vendor/bin/phpcs --standard=PSR12 app/
```

**Auto-fix code style:**
```bash
vendor/bin/pint
```

### Laravel Best Practices

- Use Eloquent ORM for database operations
- Follow RESTful conventions for API endpoints
- Use Form Requests for validation
- Use Resource classes for API responses
- Keep controllers thin, use services for business logic
- Use dependency injection

### Code Organization

```
app/
├── Http/
│   ├── Controllers/     # Handle HTTP requests
│   ├── Requests/        # Form validation
│   ├── Resources/       # API responses
│   └── Middleware/      # Request filtering
├── Models/              # Eloquent models
├── Services/            # Business logic
└── Repositories/        # Data access layer (if needed)
```

### Naming Conventions

- **Classes**: PascalCase (`ProductController`, `UserService`)
- **Methods**: camelCase (`getProducts()`, `createUser()`)
- **Variables**: camelCase (`$userName`, `$productList`)
- **Constants**: UPPER_SNAKE_CASE (`MAX_UPLOAD_SIZE`)
- **Database tables**: snake_case, plural (`products`, `user_roles`)
- **Model attributes**: snake_case (`first_name`, `created_at`)

## Testing Guidelines

### Writing Tests

- Write tests for all new features
- Maintain minimum 70% code coverage
- Use descriptive test names
- Follow AAA pattern (Arrange, Act, Assert)

### Test Structure

```php
public function test_user_can_create_product()
{
    // Arrange
    $user = User::factory()->create();
    $productData = ['name' => 'Test Product', 'price' => 100];
    
    // Act
    $response = $this->actingAs($user)
        ->postJson('/api/products', $productData);
    
    // Assert
    $response->assertStatus(201);
    $this->assertDatabaseHas('products', $productData);
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run with coverage
php artisan test --coverage

# Run PHPUnit directly
vendor/bin/phpunit
```

### Test Categories

- **Unit Tests**: Test individual methods/classes
- **Feature Tests**: Test HTTP endpoints and workflows
- **Integration Tests**: Test interaction between components

## Commit Message Guidelines

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks
- `perf`: Performance improvements

### Examples

```bash
feat(products): add bulk import functionality

Implement CSV import for products with validation
and error handling for large files.

Closes #123
```

```bash
fix(auth): resolve token expiration issue

Fixed bug where refresh tokens were expiring too early.
Updated token lifetime configuration.

Fixes #456
```

### Best Practices

- Use imperative mood ("add" not "added")
- Keep subject line under 50 characters
- Capitalize subject line
- Don't end subject with period
- Separate subject from body with blank line
- Wrap body at 72 characters
- Reference issues and PRs in footer

## Pull Request Process

### Before Submitting

1. **Update your branch**
   ```bash
   git fetch upstream
   git rebase upstream/develop
   ```

2. **Run tests**
   ```bash
   php artisan test
   ```

3. **Check code quality**
   ```bash
   vendor/bin/pint --test
   vendor/bin/phpstan analyse
   ```

4. **Update documentation** if needed

### Creating Pull Request

1. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

2. **Open PR on GitHub**
   - Use a clear, descriptive title
   - Fill out the PR template completely
   - Link related issues
   - Add screenshots for UI changes
   - Request reviewers

### PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tests pass locally
- [ ] Added new tests
- [ ] Updated existing tests

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-reviewed the code
- [ ] Commented complex code sections
- [ ] Updated documentation
- [ ] No new warnings generated
- [ ] Added tests for changes
- [ ] All tests pass
```

### Review Process

- At least 1 approval required
- All CI checks must pass
- Address reviewer feedback promptly
- Keep discussions professional
- Update PR based on feedback

## Issue Reporting

### Bug Reports

Include the following information:

```markdown
## Bug Description
Clear description of the bug

## Steps to Reproduce
1. Step one
2. Step two
3. See error

## Expected Behavior
What should happen

## Actual Behavior
What actually happens

## Environment
- OS: [e.g., Ubuntu 22.04]
- PHP Version: [e.g., 8.2]
- Laravel Version: [e.g., 11.x]
- Database: [e.g., MySQL 8.0]

## Additional Context
Screenshots, logs, etc.
```

### Feature Requests

```markdown
## Feature Description
What feature would you like?

## Problem It Solves
Why is this needed?

## Proposed Solution
How should it work?

## Alternatives Considered
Other approaches you've thought about

## Additional Context
Any other relevant information
```

## Development Tips

### Using Docker

```bash
# Start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Run tests
docker-compose exec app php artisan test
```

### Database Management

```bash
# Fresh database
php artisan migrate:fresh --seed

# Rollback
php artisan migrate:rollback

# Create migration
php artisan make:migration create_table_name
```

### Debugging

```bash
# Enable debug mode
APP_DEBUG=true

# View logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Code Review Guidelines

### As a Reviewer

- Be constructive and respectful
- Explain the "why" behind suggestions
- Approve if changes are satisfactory
- Request changes if issues exist
- Comment for questions or discussions

### As an Author

- Don't take feedback personally
- Respond to all comments
- Ask questions if unclear
- Thank reviewers for their time
- Update PR based on valid feedback

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Git Best Practices](https://git-scm.com/book/en/v2)
- [How to Write a Git Commit Message](https://chris.beams.io/posts/git-commit/)

## Questions?

- Open a discussion on GitHub
- Check existing issues and PRs
- Review project documentation

## License

By contributing, you agree that your contributions will be licensed under the same license as the project.

---

**Thank you for contributing! 🎉**
