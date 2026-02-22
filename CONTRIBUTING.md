# Contributing to Simple LLM Chatbot

Thank you for considering contributing to this project! We welcome contributions from the community.

## How to Contribute

### Reporting Bugs
1. Check if the bug has already been reported in Issues
2. If not, create a new issue with:
   - Clear description of the bug
   - Steps to reproduce
   - Expected behavior
   - Actual behavior
   - WordPress version
   - PHP version
   - Browser (if frontend issue)

### Suggesting Features
1. Check if the feature has already been suggested
2. Create a new issue with:
   - Clear description of the feature
   - Use case / why it's needed
   - Proposed implementation (optional)

### Submitting Pull Requests
1. Fork the repository
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Make your changes
4. Test thoroughly
5. Commit with clear messages: `git commit -m "Add feature: description"`
6. Push to your fork: `git push origin feature/your-feature-name`
7. Create a Pull Request

## Development Guidelines

### Code Standards
- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- Use proper indentation (tabs for PHP, spaces for JS/CSS)
- Add comments for complex logic
- Use meaningful variable names

### Security
- Always sanitize input
- Always escape output
- Use nonces for forms and AJAX
- Use prepared statements for database queries
- Check user capabilities

### Performance
- Avoid unbounded database queries (always use LIMIT)
- Use indexes on frequently queried columns
- Cache expensive operations when possible
- Minimize HTTP requests
- Use REST API instead of admin-ajax.php

### Testing
Before submitting a PR, test:
- Plugin activation/deactivation
- Settings page functionality
- Chat widget on frontend
- Analytics dashboard
- Mobile responsiveness
- Different WordPress versions (if possible)

## Code Review Process

1. Maintainers will review your PR
2. Feedback may be provided for improvements
3. Once approved, your PR will be merged
4. You'll be credited in the CHANGELOG

## Questions?

Feel free to open an issue for any questions about contributing.

## License

By contributing, you agree that your contributions will be licensed under the GPL v2 License.
