## Pull Request Description

### Summary
<!-- Provide a brief summary of the changes -->

### Type of Change
<!-- Mark the relevant option with an 'x' -->

- [ ] 🐛 Bug fix (non-breaking change which fixes an issue)
- [ ] ✨ New feature (non-breaking change which adds functionality)
- [ ] 💥 Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] 📝 Documentation update
- [ ] 🎨 Code style update (formatting, renaming)
- [ ] ♻️ Code refactoring (no functional changes)
- [ ] ⚡ Performance improvement
- [ ] ✅ Test updates
- [ ] 🔧 Configuration changes
- [ ] 🔨 Build or CI/CD changes

### Related Issues
<!-- Link to related issues -->
Closes #
Relates to #

### Changes Made
<!-- List the main changes made in this PR -->

- 
- 
- 

### Testing Performed

#### Test Coverage
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Integration tests added/updated
- [ ] Manual testing performed

#### Test Results
```bash
# Paste test results here
```

### Screenshots (if applicable)
<!-- Add screenshots for UI changes -->

**Before:**


**After:**


### Checklist

#### Code Quality
- [ ] My code follows the project's style guidelines (PSR-12)
- [ ] I have performed a self-review of my code
- [ ] I have commented my code, particularly in hard-to-understand areas
- [ ] My changes generate no new warnings or errors
- [ ] I have run `vendor/bin/pint` and fixed all style issues
- [ ] I have run `vendor/bin/phpstan analyse` with no errors

#### Testing
- [ ] I have added tests that prove my fix is effective or that my feature works
- [ ] New and existing unit tests pass locally with my changes
- [ ] All tests pass: `php artisan test`

#### Documentation
- [ ] I have updated the documentation accordingly
- [ ] I have updated the CHANGELOG.md
- [ ] I have updated API documentation (if API changes were made)
- [ ] I have updated the README (if needed)

#### Database
- [ ] I have created/updated migrations (if database changes were made)
- [ ] I have updated seeders (if needed)
- [ ] Migrations are reversible (`down()` method implemented)

#### Security
- [ ] I have checked for security vulnerabilities
- [ ] No sensitive data is exposed in logs or responses
- [ ] Input validation is implemented where needed
- [ ] SQL injection prevention is in place

#### Performance
- [ ] I have considered the performance impact of my changes
- [ ] Database queries are optimized
- [ ] No N+1 query problems introduced

### Breaking Changes
<!-- If this PR introduces breaking changes, describe them here -->

**Does this PR introduce breaking changes?**
- [ ] Yes
- [ ] No

**If yes, describe the breaking changes and migration path:**


### Deployment Notes
<!-- Any special deployment considerations? -->

- [ ] Requires database migration
- [ ] Requires cache clearing
- [ ] Requires configuration changes
- [ ] Requires environment variable updates
- [ ] No special deployment steps needed

**Deployment commands:**
```bash
# List any commands that need to be run during deployment
```

### Dependencies
<!-- List any new dependencies added -->

**New packages added:**
- 
- 

### Rollback Plan
<!-- Describe how to rollback these changes if needed -->


### Additional Context
<!-- Add any other context about the PR here -->


### Reviewer Guidelines

**For reviewers, please check:**
- [ ] Code follows project conventions and standards
- [ ] Tests are comprehensive and pass
- [ ] Documentation is clear and complete
- [ ] No obvious security issues
- [ ] Performance impact is acceptable
- [ ] Breaking changes are justified and documented

---

<!-- 
Please ensure:
1. All CI/CD checks pass
2. Branch is up to date with target branch
3. At least one approval is obtained
4. All review comments are addressed
-->
