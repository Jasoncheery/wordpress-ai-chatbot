# Project Structure

## 📁 Repository Structure

```
simple-llm-chatbot-wp/
├── simple-llm-chatbot.php    # Main plugin file (28KB)
├── README.md                  # Main documentation
├── INSTALLATION.md            # Installation guide
├── QUICK_START.md             # 5-minute setup guide
├── TESTING_GUIDE.md           # How to test locally
├── CHANGELOG.md               # Version history
├── CONTRIBUTING.md            # Contribution guidelines
├── LICENSE                    # GPL v2 License
├── .gitignore                 # Git ignore rules
└── screenshots/               # Plugin screenshots (for WordPress.org)
    └── .gitkeep
```

## 📍 Where Files Are Located

### GitHub Repository
```
https://github.com/Jasoncheery/wordpress-ai-chatbot
```

### Local Development (Your Machine)
```
~/Github Projects/simple-llm-chatbot-wp/
```

### Local WordPress Installation (For Testing)
```
~/Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/
```

### Production WordPress (After Upload)
```
your-domain.com/wp-content/plugins/simple-llm-chatbot/
```

## 🔧 Key Files Explained

### `simple-llm-chatbot.php` (Main Plugin File)
**Lines 1-15:** Plugin header and constants  
**Lines 17-45:** Database table creation with indexes  
**Lines 47-68:** Admin menu registration  
**Lines 70-130:** Settings page with nonce security  
**Lines 132-220:** Analytics dashboard with bounded queries  
**Lines 222-240:** Settings registration  
**Lines 242-290:** REST API endpoint registration  
**Lines 292-370:** Chat handler (OpenRouter API integration)  
**Lines 372-395:** Feedback handler  
**Lines 397-410:** Asset enqueuing (frontend only)  
**Lines 412-650:** Chat widget HTML/CSS/JavaScript  
**Lines 652-660:** Settings link on plugins page

### `README.md`
- Overview and features
- Installation methods
- Configuration examples
- Cost estimates
- Troubleshooting

### `INSTALLATION.md`
- Detailed installation steps
- Configuration examples
- Verification steps

### `QUICK_START.md`
- 5-minute setup guide
- Copy/paste examples
- Testing checklist

### `TESTING_GUIDE.md`
- Local testing instructions
- Verification steps
- Browser console debugging
- Production deployment

## 🎯 WordPress Admin Pages

### Settings Page
**Location:** Settings → LLM Chatbot  
**URL:** `wp-admin/options-general.php?page=simple-llm-chatbot`  
**Capability Required:** `manage_options` (Admin only)

**Fields:**
- OpenRouter API Key (password field)
- Model selection (text field)
- System Prompt (textarea)
- Knowledge Base (textarea)

### Analytics Dashboard
**Location:** Chat Analytics (sidebar)  
**URL:** `wp-admin/admin.php?page=simple-llm-analytics`  
**Capability Required:** `manage_options` (Admin only)

**Displays:**
- Total conversations (COUNT DISTINCT session_id)
- Total messages (COUNT *)
- Success rate (helpful / total_rated * 100)
- Top 10 FAQs (GROUP BY user_message)
- Last 50 interactions (ORDER BY created_at DESC LIMIT 50)

## 🗄️ Database Structure

### Table: `wp_simple_llm_logs`

**Indexes for Performance:**
- PRIMARY KEY on `id`
- KEY on `session_id` (for grouping conversations)
- KEY on `created_at` (for time-based queries)
- KEY on `is_helpful` (for success rate calculations)

**Storage Estimate:**
- 1000 conversations ≈ 2-5 MB
- 10,000 conversations ≈ 20-50 MB
- Minimal database impact

## 🌐 REST API Endpoints

### Chat Endpoint
```
POST /wp-json/simple-llm/v1/chat
```
**Handler:** `slc_handle_chat()`  
**File:** `simple-llm-chatbot.php` (lines 292-370)

### Feedback Endpoint
```
POST /wp-json/simple-llm/v1/feedback
```
**Handler:** `slc_handle_feedback()`  
**File:** `simple-llm-chatbot.php` (lines 372-395)

## 🎨 Frontend Components

### Chat Widget HTML
**Location:** `simple-llm-chatbot.php` (lines 550-570)  
**Elements:**
- `#slc-chat-widget` - Container
- `#slc-chat-button` - Floating bubble
- `#slc-chat-window` - Chat interface
- `#slc-chat-header` - Header with close button
- `#slc-chat-messages` - Message container
- `#slc-chat-input-area` - Input field and send button

### Chat Widget CSS
**Location:** `simple-llm-chatbot.php` (lines 420-540)  
**Features:**
- Gradient backgrounds
- Smooth transitions
- Mobile responsive
- Accessibility (aria-labels)

### Chat Widget JavaScript
**Location:** `simple-llm-chatbot.php` (lines 575-650)  
**Functions:**
- `slcToggleChat()` - Open/close chat
- `slcSendMessage()` - Send message to API
- `slcAddMessage()` - Add message to UI
- `slcAddFeedback()` - Add feedback buttons
- `slcSendFeedback()` - Send feedback to API

## 🔐 Security Layers

1. **Input Validation:** REST API validates all parameters
2. **Sanitization:** All inputs sanitized (text, textarea)
3. **Nonces:** Settings form uses `wp_nonce_field()`
4. **Capability Checks:** Admin pages check `manage_options`
5. **Prepared Statements:** All database queries use `%s`, `%d`
6. **Escaping:** All output escaped (`esc_attr`, `esc_html`, `esc_url`)
7. **SSL Verification:** API calls use `sslverify: true`

## 📦 Distribution

### For WordPress.org (Future)
- Add banner image: `assets/banner-772x250.png`
- Add icon: `assets/icon-256x256.png`
- Add screenshots: `screenshots/screenshot-1.png`, etc.
- Update readme.txt (WordPress format)

### For GitHub Releases
- Create release: `git tag v1.0.0 && git push --tags`
- Upload ZIP to release
- Users can download directly

### For Private Distribution
- Share GitHub link: `https://github.com/Jasoncheery/wordpress-ai-chatbot`
- Or share ZIP file: `~/Github Projects/simple-llm-chatbot.zip`

## 🔄 Update Workflow

When you make changes:

1. **Edit in GitHub project:**
   ```bash
   cd ~/Github Projects/simple-llm-chatbot-wp
   # Make changes
   git add -A
   git commit -m "Description"
   git push
   ```

2. **Update Local WordPress:**
   ```bash
   cp -r ~/Github\ Projects/simple-llm-chatbot-wp/* "/Users/jasyuen/Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/"
   ```

3. **Test locally** before deploying to production

## 📞 Support Resources

- **GitHub Repo:** [https://github.com/Jasoncheery/wordpress-ai-chatbot](https://github.com/Jasoncheery/wordpress-ai-chatbot)
- **Issues:** [Report bugs](https://github.com/Jasoncheery/wordpress-ai-chatbot/issues)
- **OpenRouter Docs:** [https://openrouter.ai/docs](https://openrouter.ai/docs)
- **WordPress Plugin Handbook:** [https://developer.wordpress.org/plugins/](https://developer.wordpress.org/plugins/)

---

**Last Updated:** February 22, 2026  
**Version:** 1.0.0
