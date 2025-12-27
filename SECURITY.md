# Security Policy

## Supported Versions

We release patches for security vulnerabilities. Which versions are eligible for receiving such patches depends on the CVSS v3.0 Rating:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take the security of our software seriously. If you believe you have found a security vulnerability in our Inventory API, we encourage you to let us know right away.

**Please do NOT report security vulnerabilities through public GitHub issues.**

### How to Report a Security Vulnerability?

Instead, please report them via email to:

📧 **security@example.com**

You should receive a response within 48 hours. If for some reason you do not, please follow up via email to ensure we received your original message.

### What to Include in Your Report

Please include the following information in your report:

- **Type of vulnerability** (e.g., SQL injection, XSS, authentication bypass, etc.)
- **Full paths of source file(s)** related to the manifestation of the vulnerability
- **Location of the affected source code** (tag/branch/commit or direct URL)
- **Step-by-step instructions** to reproduce the issue
- **Proof-of-concept or exploit code** (if possible)
- **Impact of the vulnerability**, including how an attacker might exploit it
- **Any special configuration** required to reproduce the issue

### What to Expect

After you've submitted a vulnerability report:

1. **Acknowledgment** - We'll acknowledge receipt of your vulnerability report within 48 hours
2. **Investigation** - We'll investigate and validate the vulnerability (typically within 5 business days)
3. **Communication** - We'll keep you informed about the progress of fixing the vulnerability
4. **Fix & Release** - We'll work on a fix and release it as soon as possible
5. **Credit** - We'll publicly acknowledge your responsible disclosure (if you wish)

## Security Vulnerability Response

### Timeline

- **Initial Response**: Within 48 hours
- **Vulnerability Assessment**: Within 5 business days
- **Fix Development**: Depending on severity (Critical: 7 days, High: 14 days, Medium: 30 days)
- **Public Disclosure**: After fix is deployed and users have been notified

### Severity Levels

We use the CVSS v3.0 standard to assess the severity:

- **Critical (9.0-10.0)**: Requires immediate attention
- **High (7.0-8.9)**: Should be fixed as soon as possible
- **Medium (4.0-6.9)**: Should be fixed in a reasonable timeframe
- **Low (0.1-3.9)**: Nice to have fixes

## Security Best Practices

### For Users

1. **Keep Updated**: Always use the latest version of the API
2. **Secure Configuration**: Follow our security configuration guidelines
3. **Environment Variables**: Never commit `.env` files or expose sensitive credentials
4. **HTTPS Only**: Always use HTTPS in production
5. **Regular Backups**: Maintain regular database backups
6. **Monitor Logs**: Regularly check application logs for suspicious activity

### For Developers

1. **Input Validation**: Always validate and sanitize user inputs
2. **SQL Injection**: Use parameterized queries (Laravel ORM handles this)
3. **XSS Prevention**: Escape output properly
4. **Authentication**: Use strong password policies and multi-factor authentication
5. **Authorization**: Implement proper role-based access control
6. **Dependency Updates**: Regularly update dependencies using `composer audit`
7. **Secrets Management**: Use environment variables for sensitive data
8. **Rate Limiting**: Implement rate limiting on API endpoints
9. **CORS Configuration**: Properly configure CORS policies
10. **Logging**: Log security events but never log sensitive information

## Known Security Considerations

### Authentication
- JWT tokens expire after 24 hours by default
- Tokens should be stored securely on the client side
- Refresh token mechanism should be implemented for long-lived sessions

### Database
- All database queries use Laravel's Eloquent ORM (prevents SQL injection)
- Database credentials should never be committed to version control
- Use separate database users with minimal required permissions

### API Rate Limiting
- Default rate limit: 60 requests per minute per IP
- Can be configured in `config/throttle.php`

### File Uploads
- Currently not implemented, but if added:
  - Validate file types and sizes
  - Store files outside web root
  - Scan for malware

## Security Updates

We will notify users of security updates through:

1. GitHub Security Advisories
2. Release notes in CHANGELOG.md
3. Email notifications (for critical vulnerabilities)

## Compliance

This project aims to comply with:

- OWASP Top 10 security risks
- Laravel security best practices
- RESTful API security standards

## Bug Bounty Program

Currently, we do not have a bug bounty program. However, we greatly appreciate security researchers who responsibly disclose vulnerabilities to us.

## Hall of Fame

We recognize security researchers who have helped us improve our security:

<!-- List of contributors will be added here -->
*No vulnerabilities reported yet*

## Contact

For security concerns, please contact:

- 📧 Email: security@example.com
- 🔒 PGP Key: [Not yet available]

For general questions, please use:
- 💬 GitHub Discussions: https://github.com/FarhanPerdana123/inventory-management-api/discussions
- 🐛 GitHub Issues: https://github.com/FarhanPerdana123/inventory-management-api/issues

---

**Note**: This security policy is subject to change. Please check back regularly for updates.

**Last Updated**: December 27, 2025
