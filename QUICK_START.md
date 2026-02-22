# Quick Start Guide

Get your chatbot running in 5 minutes!

## 🚀 For Local Testing (Your Current Setup)

### The plugin is ALREADY installed in your Local WordPress:
```
Location: Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/
```

### Activate Now:

1. **Open Local WordPress Admin:**
   ```
   http://ainfinity-local.local/wp-admin
   ```

2. **Go to Plugins → Activate "Simple LLM Chatbot with Analytics"**

3. **Get API Key:**
   - Visit: [https://openrouter.ai/keys](https://openrouter.ai/keys)
   - Sign up (free $1 credit)
   - Create key → Copy it

4. **Configure:**
   - Settings → LLM Chatbot
   - Paste API key
   - Model: `anthropic/claude-3-haiku` (cheapest for testing)
   - Add your knowledge base (see example below)
   - Save

5. **Test:**
   - Visit: `http://ainfinity-local.local`
   - Click chat bubble (💬)
   - Ask: "What are your business hours?"
   - ✅ Should get a response!

## 📝 Example Knowledge Base (Copy/Paste)

```
COMPANY: AI Infinity
WEBSITE: ainfinity.shop
EMAIL: support@ainfinity.shop

BUSINESS HOURS:
Monday to Friday: 9 AM - 6 PM EST
Weekends: Closed

SERVICES:
- WordPress Development: Custom themes and plugins
- AI Integration: Chatbot solutions
- Web Design: Modern, responsive websites

FAQ:
Q: What are your business hours?
A: Monday to Friday, 9 AM - 6 PM EST. Closed weekends.

Q: How do I get a quote?
A: Email support@ainfinity.shop or use this chat.

Q: What services do you offer?
A: WordPress development, AI integration, and web design.
```

## 🎯 Verify It's Working

### Frontend Test:
1. Visit your website
2. See chat bubble (💬) bottom-right? ✅
3. Click it → Opens chat window? ✅
4. Type message → Get response? ✅
5. Click 👍 or 👎 → Button highlights? ✅

### Admin Test:
1. Go to Chat Analytics
2. See your test conversation? ✅
3. See message count? ✅
4. See FAQ list? ✅

## 📦 For Production Deployment

### Method 1: Download & Upload
1. **Download from GitHub:**
   ```
   https://github.com/Jasoncheery/wordpress-ai-chatbot
   ```
   Click "Code" → "Download ZIP"

2. **Upload to WordPress:**
   - Admin → Plugins → Add New → Upload Plugin
   - Choose ZIP file
   - Install & Activate

3. **Configure:**
   - Settings → LLM Chatbot
   - Enter production API key
   - Update knowledge base
   - Save

### Method 2: Direct Install (If you have FTP/SFTP)
1. Upload the `simple-llm-chatbot` folder to:
   ```
   your-site.com/wp-content/plugins/
   ```

2. Activate in WordPress Admin → Plugins

3. Configure settings as above

## 🔑 Yes, Users (Admins) Can Input the LLM Key

**In WordPress Admin:**
- Go to **Settings → LLM Chatbot**
- There's a password field for "OpenRouter API Key"
- Only users with `manage_options` capability (Admins) can access this
- The key is stored securely in WordPress options table
- Never exposed in frontend JavaScript

**Security Features:**
- ✅ Only admins can see/edit the key
- ✅ Field is type="password" (hidden)
- ✅ Nonce verification on save
- ✅ Sanitized before storage
- ✅ Never sent to frontend

## 💡 Pro Tips

### For Testing:
- Use `anthropic/claude-3-haiku` (cheapest: $0.00025/1K tokens)
- Free $1 credit = ~4000 test messages
- Monitor usage: [https://openrouter.ai/activity](https://openrouter.ai/activity)

### For Production:
- Use `openai/gpt-3.5-turbo` (good balance: $0.0015/1K tokens)
- Or `anthropic/claude-3-sonnet` (better quality: $0.003/1K tokens)
- Set up billing alerts in OpenRouter

## 🐛 Common Issues

### Issue: Plugin not showing in Plugins list
**Solution:** 
- Check folder name is exactly `simple-llm-chatbot`
- Check `simple-llm-chatbot.php` is in the folder root

### Issue: Chat bubble not appearing
**Solution:**
- Clear browser cache (Cmd+Shift+R)
- Check plugin is activated
- View page source, search for "slc-chat-widget"

### Issue: "API Key not configured"
**Solution:**
- Go to Settings → LLM Chatbot
- Enter API key
- Click Save Changes
- Refresh your website

### Issue: Response is "Sorry, I could not process your request"
**Solution:**
- Check OpenRouter account has credits
- Verify API key is correct
- Check model name is valid
- Open browser console (F12) for detailed error

## 📊 Monitoring During Testing

### Check OpenRouter Dashboard:
- Visit: [https://openrouter.ai/activity](https://openrouter.ai/activity)
- See your requests in real-time
- Monitor token usage
- Check costs

### Check WordPress Analytics:
- Go to: Chat Analytics
- See conversations count
- Review recent interactions
- Check success rate

## ✅ Testing Checklist

Before deploying to production:

- [ ] Plugin activates without errors
- [ ] Settings page accessible
- [ ] API key saves correctly
- [ ] Chat bubble appears on frontend
- [ ] Chat window opens/closes
- [ ] Messages send successfully
- [ ] Responses use knowledge base
- [ ] Feedback buttons work
- [ ] Analytics dashboard updates
- [ ] Mobile responsive (test on phone)
- [ ] No console errors (F12)
- [ ] Works on different pages
- [ ] Welcome message appears

## 🎓 Understanding the Flow

```
User visits website
    ↓
Sees chat bubble (💬)
    ↓
Clicks bubble → Chat window opens
    ↓
Types message → Sends to REST API
    ↓
REST API → Adds knowledge base → Calls OpenRouter
    ↓
OpenRouter → Returns AI response
    ↓
Response displayed → User can rate (👍/👎)
    ↓
All logged to database
    ↓
Admin can view in Analytics dashboard
```

## 📞 Need Help?

- **Documentation:** [README.md](README.md)
- **Installation:** [INSTALLATION.md](INSTALLATION.md)
- **GitHub Issues:** [Report a bug](https://github.com/Jasoncheery/wordpress-ai-chatbot/issues)

---

**Estimated Testing Time:** 10 minutes  
**Cost During Testing:** < $0.01 with free credits  
**Ready for Production:** After checklist complete ✅
