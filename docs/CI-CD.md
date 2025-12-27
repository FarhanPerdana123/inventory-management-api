# CI/CD Pipeline Documentation

## Overview

This project uses GitHub Actions for continuous integration and continuous deployment (CI/CD). The pipeline automatically builds, tests, and deploys the application whenever code is pushed to the repository.

## Pipeline Stages

### 1. Build Stage
- **Trigger**: Push to `main` or `develop` branches, or pull requests
- **Actions**:
  - Checkout code
  - Build Docker image
  - Push image to GitHub Container Registry (ghcr.io)
  - Tag images with branch name, commit SHA, and `latest` tag

### 2. Test Stage

#### a. Test Quality
- **Purpose**: Ensure code quality and adherence to standards
- **Tools**:
  - **PHP CodeSniffer**: Checks PSR-12 coding standards
  - **PHPStan**: Static analysis (level 5)
  - **Laravel Pint**: Code style formatting
- **Note**: Failures are non-blocking (continue-on-error: true)

#### b. Test Security
- **Purpose**: Identify security vulnerabilities
- **Tools**:
  - **Composer Audit**: Checks dependencies for known vulnerabilities
- **Note**: Failures are non-blocking (continue-on-error: true)

#### c. Test Unit
- **Purpose**: Run automated tests
- **Environment**:
  - PHP 8.2 with required extensions
  - MySQL 8.0 database service
- **Actions**:
  - Install dependencies
  - Configure environment
  - Run database migrations
  - Execute PHPUnit tests with coverage
  - Upload test logs as artifacts

### 3. Deploy Stage

#### a. Deploy to Staging
- **Trigger**: Push to `develop` branch
- **Target**: Staging server
- **Actions**:
  - SSH to staging server
  - Pull latest code from `develop` branch
  - Install production dependencies
  - Run database migrations
  - Clear and cache configuration
  - Restart PHP-FPM service

#### b. Deploy to Production
- **Trigger**: Push to `main` branch
- **Target**: Production server
- **Actions**:
  - SSH to production server
  - Pull latest code from `main` branch
  - Install production dependencies
  - Run database migrations
  - Clear and cache configuration
  - Restart PHP-FPM service

## Workflow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                          TRIGGER                             │
│         Push to main/develop or Pull Request                │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
            ┌────────────────┐
            │     BUILD      │
            │  Docker Image  │
            └────────┬───────┘
                     │
        ┌────────────┼────────────┐
        │            │            │
        ▼            ▼            ▼
  ┌──────────┐ ┌──────────┐ ┌──────────┐
  │  QUALITY │ │ SECURITY │ │   UNIT   │
  │   TEST   │ │   TEST   │ │   TEST   │
  └────┬─────┘ └────┬─────┘ └────┬─────┘
       │            │            │
       └────────────┼────────────┘
                    │
                    ▼
         ┌──────────────────────┐
         │  All Tests Passed    │
         └──────────┬───────────┘
                    │
        ┌───────────┴───────────┐
        │                       │
        ▼                       ▼
  ┌──────────┐          ┌──────────────┐
  │ STAGING  │          │ PRODUCTION   │
  │ (develop)│          │   (main)     │
  └──────────┘          └──────────────┘
```

## Configuration

### GitHub Secrets Required

Navigate to: **Repository Settings → Secrets and variables → Actions → New repository secret**

#### SSH Configuration
- `SSH_PRIVATE_KEY` - Private SSH key for server access
- `SSH_PORT` - SSH port (default: 22, optional)

#### Staging Environment
- `STAGING_SERVER` - Hostname or IP address
- `STAGING_USER` - SSH username
- `STAGING_PATH` - Deployment path (e.g., `/var/www/staging`)

#### Production Environment
- `PRODUCTION_SERVER` - Hostname or IP address
- `PRODUCTION_USER` - SSH username
- `PRODUCTION_PATH` - Deployment path (e.g., `/var/www/production`)

### GitHub Variables

Navigate to: **Repository Settings → Secrets and variables → Actions → Variables**

- `STAGING_URL` - Staging environment URL
- `PRODUCTION_URL` - Production environment URL

### Environment Protection Rules

1. Go to **Repository Settings → Environments**
2. Configure `staging` environment:
   - Add required reviewers (optional)
   - Set deployment branches to `develop`
3. Configure `production` environment:
   - Add required reviewers (recommended)
   - Set deployment branches to `main`
   - Enable "Wait timer" for delayed deployments (optional)

## Docker Image Registry

Images are stored in GitHub Container Registry:
- Registry: `ghcr.io`
- Image: `ghcr.io/[username]/[repository]`
- Authentication: Automatic via `GITHUB_TOKEN`

### Image Tags
- `latest` - Latest build from default branch
- `main-<sha>` - Specific commit from main branch
- `develop-<sha>` - Specific commit from develop branch

## Branching Strategy

### Main Branch (`main`)
- Production-ready code
- Protected branch
- Requires pull request reviews
- Auto-deploys to production

### Develop Branch (`develop`)
- Integration branch for features
- Auto-deploys to staging
- Used for pre-production testing

### Feature Branches
- Created from `develop`
- Naming: `feature/description`
- Merged back to `develop` via PR

### Hotfix Branches
- Created from `main`
- Naming: `hotfix/description`
- Merged to both `main` and `develop`

## Local Development

### Running Tests Locally

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Run tests
php artisan test
# or
vendor/bin/phpunit
```

### Code Quality Checks

```bash
# Install dev dependencies
composer require --dev squizlabs/php_codesniffer
composer require --dev phpstan/phpstan
composer require --dev laravel/pint

# Run PHP CodeSniffer
vendor/bin/phpcs --standard=PSR12 app/

# Run PHPStan
vendor/bin/phpstan analyse app --level=5

# Run Laravel Pint
vendor/bin/pint --test
```

### Security Audit

```bash
# Check for vulnerabilities
composer audit
```

## Troubleshooting

### Pipeline Fails at Build Stage

**Issue**: Docker build fails
- Check Dockerfile syntax
- Ensure all dependencies are available
- Verify base image exists

### Pipeline Fails at Test Stage

**Issue**: Tests fail
- Run tests locally first
- Check database configuration
- Verify all migrations run successfully

**Issue**: Code quality checks fail
- Run quality tools locally
- Fix reported issues
- Consider adjusting PHPStan level if needed

### Pipeline Fails at Deploy Stage

**Issue**: SSH connection fails
- Verify `SSH_PRIVATE_KEY` is correct
- Check server firewall rules
- Ensure user has proper permissions

**Issue**: Deployment script fails
- Verify deployment path exists
- Check file permissions on server
- Ensure required services are running

## Monitoring

### Viewing Pipeline Runs
1. Go to **Actions** tab in GitHub
2. Select the workflow run
3. View individual job logs

### Artifacts
Test logs are automatically uploaded and retained for 7 days:
- Navigate to workflow run
- Scroll to "Artifacts" section
- Download `test-logs`

### Notifications
Configure notifications in GitHub Settings:
- **Settings → Notifications → Actions**
- Enable email/web notifications for failed runs

## Best Practices

1. **Always create pull requests** - Never push directly to `main` or `develop`
2. **Write tests** - Maintain high test coverage
3. **Review code quality** - Address linter warnings
4. **Check security** - Fix vulnerabilities before merging
5. **Monitor deployments** - Verify successful deployments
6. **Keep dependencies updated** - Regularly update composer packages
7. **Use semantic versioning** - Tag releases appropriately
8. **Document changes** - Update CHANGELOG.md

## Additional Resources

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)
- [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [PHPStan](https://phpstan.org/)
- [Laravel Pint](https://laravel.com/docs/pint)

## Support

For issues related to CI/CD pipeline:
1. Check workflow logs in Actions tab
2. Review this documentation
3. Open an issue in the repository
4. Contact the DevOps team

---

**Last Updated**: December 27, 2025
