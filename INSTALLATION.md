# Installation Guide

## Quick Installation (5 Minutes)

### Step 1: Install Plugin

**Option A: Via WordPress Admin (Recommended)**
1. Download this repository as ZIP
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin"
4. Choose the ZIP file
5. Click "Install Now"
6. Click "Activate Plugin"

**Option B: Manual Upload**
1. Download/clone this repository
2. Upload the `simple-llm-chatbot` folder to your WordPress site's `wp-content/plugins/` directory
3. Go to WordPress Admin → Plugins
4. Find "Simple LLM Chatbot with Analytics"
5. Click "Activate"

### Step 2: Get OpenRouter API Key
1. Visit [https://openrouter.ai/keys](https://openrouter.ai/keys)
2. Sign up or log in (free tier available)
3. Click "Create Key"
4. Copy your API key

### Step 3: Configure Settings
1. In WordPress Admin, go to **Settings → LLM Chatbot**
2. Paste your OpenRouter API Key
3. (Optional) Change the model:
   - For lowest cost: `anthropic/claude-3-haiku`
   - For balance: `openai/gpt-3.5-turbo` (default)
   - For best quality: `openai/gpt-4-turbo`
4. Update the **System Prompt** (see examples below)
5. Add your **Knowledge Base** (see examples below)
6. Click **Save Changes**

### Step 4: Test
1. Visit your website homepage
2. Look for the chat bubble (💬) in the bottom-right corner
3. Click the bubble to open chat
4. Type a test message
5. Verify you get a response

## Configuration Examples

### System Prompt
```
You are a helpful customer support assistant for [Your Company]. 
Be friendly, professional, and concise. 
Answer questions based on the knowledge base provided.
If you don't know the answer, suggest contacting support@yourcompany.com.
```

### Knowledge Base
```
COMPANY: Your Company Name
WEBSITE: yourwebsite.com
EMAIL: support@yourcompany.com
PHONE: +1 (555) 123-4567

BUSINESS HOURS:
Monday to Friday: 9 AM - 6 PM EST
Saturday: 10 AM - 4 PM EST
Sunday: Closed

SERVICES:
- Web Development: Custom WordPress sites and themes
- Consulting: Technical consulting and strategy
- Support: Ongoing maintenance and support

PRICING:
- Basic Plan: $99/month
- Pro Plan: $299/month
- Enterprise: Custom pricing

FAQ:
Q: How do I get started?
A: Contact us via email or use this chat to discuss your needs.

Q: What payment methods do you accept?
A: We accept credit cards, PayPal, and bank transfers.

Q: Do you offer refunds?
A: Yes, we offer a 30-day money-back guarantee.

Q: How long does setup take?
A: Most projects are completed within 2-4 weeks.
```

## Verify Installation

### Check Plugin is Active
1. Go to WordPress Admin → Plugins
2. "Simple LLM Chatbot with Analytics" should show as "Active"

### Check Settings Page
1. Go to Settings → LLM Chatbot
2. You should see fields for API Key, Model, System Prompt, and Knowledge Base

### Check Analytics Page
1. Look for "Chat Analytics" in the WordPress admin sidebar
2. Click it to view the analytics dashboard

### Check Frontend Widget
1. Visit any page on your website
2. The chat bubble should appear in the bottom-right corner
3. Click it to open the chat window

## Troubleshooting

### Plugin doesn't appear in Plugins list
- Ensure the folder is named `simple-llm-chatbot` (not `simple-llm-chatbot-wp` or `simple-llm-chatbot-main`)
- Check that `simple-llm-chatbot.php` is in the root of the plugin folder

### Chat bubble not appearing
- Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
- Check browser console for JavaScript errors (F12)
- Ensure you're viewing a public page (not admin)

### "API Key not configured" error
- Go to Settings → LLM Chatbot
- Verify API key is entered correctly (no extra spaces)
- Click Save Changes

### No response from chatbot
- Check your OpenRouter account has credits
- Verify API key is valid
- Check browser console for errors
- Try a different model

### Database table not created
- Deactivate the plugin
- Reactivate the plugin (this triggers table creation)
- Check with your hosting provider if you have database permissions

## Next Steps

After installation:
1. ✅ Test the chat with a few questions
2. ✅ Check the Analytics dashboard
3. ✅ Customize the appearance (optional)
4. ✅ Monitor usage and costs in OpenRouter dashboard
5. ✅ Refine knowledge base based on user questions

## Support

For issues or questions:
- Check the [README.md](README.md) for detailed documentation
- Open an issue on GitHub
- Contact: support@ainfinity.shop

---

**Estimated Setup Time:** 5 minutes  
**Difficulty:** Beginner-friendly
