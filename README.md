# Simple LLM Chatbot - WordPress Plugin

A professional WordPress plugin that adds an AI-powered chatbot to any WordPress site using OpenRouter LLM, with knowledge base management and comprehensive analytics.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.8%2B-blue.svg)
![PHP](https://img.shields.io/badge/php-7.4%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL%20v2-green.svg)

## Features

- **Beautiful Chat Widget**: Floating chat bubble with modern gradient design
- **OpenRouter Integration**: Use any LLM model (GPT-3.5, GPT-4, Claude, etc.)
- **Knowledge Base Management**: Update FAQs and context directly from WordPress admin
- **System Prompt Control**: Customize chatbot personality and behavior
- **Analytics Dashboard**: Track conversations, success rates, and frequently asked questions
- **User Feedback System**: Thumbs up/down on responses for quality tracking
- **Mobile Responsive**: Seamless experience on all devices
- **Performance Optimized**: REST API, database indexes, bounded queries
- **Secure**: Nonces, capability checks, input sanitization, prepared statements

## Installation

### Method 1: Download and Upload
1. Download this repository as ZIP
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Upload the ZIP file
4. Click "Activate Plugin"

### Method 2: Manual Installation
1. Download/clone this repository
2. Copy the `simple-llm-chatbot` folder to `wp-content/plugins/`
3. Go to WordPress Admin → Plugins
4. Find "Simple LLM Chatbot with Analytics"
5. Click "Activate"

### Method 3: Git Clone (For Developers)
```bash
cd wp-content/plugins/
git clone https://github.com/YOUR_USERNAME/simple-llm-chatbot-wp.git simple-llm-chatbot
```

## Quick Setup (5 Minutes)

### Step 1: Get OpenRouter API Key
1. Visit [OpenRouter.ai](https://openrouter.ai/keys)
2. Sign up (free tier available)
3. Create an API key
4. Copy the key

### Step 2: Configure Plugin
1. Go to **WordPress Admin → Settings → LLM Chatbot**
2. Paste your OpenRouter API Key
3. (Optional) Change model (default: `openai/gpt-3.5-turbo`)
4. Customize the System Prompt
5. Add your Knowledge Base content
6. Click **Save Changes**

### Step 3: Test
1. Visit your website
2. Look for the chat bubble (💬) in bottom-right corner
3. Click and start chatting!

## Configuration

### System Prompt Example
```
You are a helpful customer support assistant for [Your Company Name]. 
Be friendly, professional, and concise. 
If you don't know the answer, suggest contacting support@yourcompany.com.
```

### Knowledge Base Example
```
COMPANY: Your Company Name
WEBSITE: yourwebsite.com
EMAIL: support@yourcompany.com
PHONE: +1 (555) 123-4567

BUSINESS HOURS:
Monday to Friday: 9 AM - 6 PM EST
Weekends: Closed

SERVICES:
- Service 1: Description
- Service 2: Description
- Service 3: Description

FAQ:
Q: How do I get a quote?
A: Contact us via email or use this chat to describe your project.

Q: What are your payment terms?
A: We accept credit cards, PayPal, and bank transfers.

Q: Do you offer support?
A: Yes, we offer 24/7 email support and live chat during business hours.
```

## Analytics Dashboard

Access via **WordPress Admin → Chat Analytics**

View:
- Total conversations count
- Total messages sent
- Success rate (based on user feedback)
- Top 10 frequently asked questions
- Last 50 interactions

## Supported Models

| Model | Speed | Cost | Best For |
|-------|-------|------|----------|
| `openai/gpt-3.5-turbo` | Fast | Low | General support |
| `openai/gpt-4-turbo` | Medium | Medium | Complex queries |
| `anthropic/claude-3-haiku` | Fast | Very Low | Quick responses |
| `anthropic/claude-3-sonnet` | Medium | Medium | Balanced quality |
| `anthropic/claude-3-opus` | Slow | High | Best quality |

See all models at [OpenRouter Models](https://openrouter.ai/models)

## Cost Estimates

Using `anthropic/claude-3-haiku` (most affordable):
- 100 conversations/month: ~$0.08
- 500 conversations/month: ~$0.38
- 1000 conversations/month: ~$0.75

Using `openai/gpt-3.5-turbo`:
- 100 conversations/month: ~$0.15
- 500 conversations/month: ~$0.75
- 1000 conversations/month: ~$1.50

## Performance Features

- ✅ REST API endpoints (faster than admin-ajax.php)
- ✅ Database indexes on frequently queried columns
- ✅ All queries use LIMIT clauses (no unbounded queries)
- ✅ Prepared SQL statements for security and performance
- ✅ Inline CSS/JS (no extra HTTP requests)
- ✅ Frontend-only asset loading
- ✅ 30-second API timeout
- ✅ Input validation on all endpoints

## Security Features

- ✅ Nonce verification on all forms and AJAX requests
- ✅ Capability checks (`manage_options` for admin pages)
- ✅ Input sanitization and validation
- ✅ Prepared SQL statements (prevents SQL injection)
- ✅ SSL verification on API requests
- ✅ No sensitive data in frontend JavaScript

## Customization

### Change Chat Bubble Color
Edit line ~230 in `simple-llm-chatbot.php`:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Change Position
Edit line ~220 in `simple-llm-chatbot.php`:
```css
bottom: 20px;  /* Distance from bottom */
right: 20px;   /* Distance from right */
```

### Change Welcome Message
Edit line ~480 in `simple-llm-chatbot.php`:
```javascript
slcAddMessage('Hello! How can I help you today?', 'bot');
```

## Troubleshooting

### Chat bubble not appearing
- Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
- Check browser console for errors (F12)
- Ensure plugin is activated

### "API Key not configured" error
- Go to Settings → LLM Chatbot
- Enter your OpenRouter API key
- Click Save Changes

### Responses not using knowledge base
- Ensure Knowledge Base field is filled in Settings
- Try asking more specific questions
- Verify the model supports context (GPT and Claude models do)

### High API costs
- Switch to `anthropic/claude-3-haiku` (cheapest)
- Reduce knowledge base size
- Monitor usage in OpenRouter dashboard

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- OpenRouter API account (free tier available)
- Internet connection for API calls

## Database Schema

**Table:** `{prefix}_simple_llm_logs`

| Column | Type | Index | Purpose |
|--------|------|-------|---------|
| id | mediumint(9) | PRIMARY | Unique identifier |
| session_id | varchar(100) | KEY | Group messages by conversation |
| user_message | text | - | User's question |
| bot_response | text | - | AI's answer |
| is_helpful | tinyint(1) | KEY | User feedback (1=yes, 0=no, NULL=no feedback) |
| created_at | datetime | KEY | Timestamp for analytics |

## API Endpoints

### POST `/wp-json/simple-llm/v1/chat`
Send message and get AI response.

**Request:**
```json
{
  "message": "What are your business hours?",
  "session_id": "sess_abc123_1234567890"
}
```

**Response:**
```json
{
  "reply": "Our business hours are Monday to Friday, 9 AM - 6 PM EST.",
  "log_id": 42
}
```

### POST `/wp-json/simple-llm/v1/feedback`
Record user feedback on responses.

**Request:**
```json
{
  "log_id": 42,
  "is_helpful": true
}
```

## Changelog

### Version 1.0.0 - February 22, 2026
- Initial release
- OpenRouter LLM integration
- Knowledge base management
- Analytics dashboard
- User feedback system
- Mobile responsive design
- Performance optimizations

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

GPL v2 or later - see [LICENSE](LICENSE) for details.

## Support

For issues or feature requests, please open an issue on GitHub.

## Credits

Developed by AI Infinity Team  
Website: [ainfinity.shop](https://ainfinity.shop)

---

**Made with ❤️ for the WordPress community**
