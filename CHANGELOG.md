# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-22

### Added
- Initial release of Simple LLM Chatbot plugin
- OpenRouter LLM integration with support for all available models
- Admin settings page for API key, model selection, system prompt, and knowledge base
- Floating chat widget on frontend (bottom-right corner)
- Beautiful gradient UI with smooth animations
- Real-time chat interface with typing indicator
- User feedback system (thumbs up/down)
- Analytics dashboard showing:
  - Total conversations count
  - Total messages count
  - Success rate based on user feedback
  - Top 10 frequently asked questions
  - Last 50 interactions
- Database logging with proper indexes
- REST API endpoints for chat and feedback
- Mobile responsive design
- Security features (nonces, capability checks, input sanitization)
- Performance optimizations (REST API, indexed queries, bounded queries)

### Security
- Nonce verification on all forms and AJAX requests
- Capability checks for admin pages
- Input sanitization and validation
- Prepared SQL statements
- SSL verification on API requests

### Performance
- REST API instead of admin-ajax.php
- Database indexes on session_id, created_at, is_helpful
- LIMIT clauses on all queries
- Inline CSS/JS to avoid extra HTTP requests
- Frontend-only asset loading
- 30-second API timeout

## [Unreleased]

### Planned Features
- Conversation history per user (requires authentication)
- Export analytics to CSV
- Multi-language support
- Email chat transcripts to admin
- Rate limiting to prevent abuse
- Response caching for repeated questions
- Custom styling options in admin
- Integration with popular form plugins
- Webhook support for external integrations

---

For upgrade instructions and migration notes, see [README.md](README.md)
