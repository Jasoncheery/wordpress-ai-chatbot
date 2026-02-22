# Testing Guide - Verify Before Upload

This guide shows you how to test the plugin locally in your WordPress installation before deploying to production.

## ✅ Plugin is Already Installed Locally

The plugin is already copied to your Local WordPress installation:
```
/Users/jasyuen/Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/
```

## 🧪 Step-by-Step Testing

### Step 1: Activate Plugin (1 minute)

1. Open your Local WordPress site admin panel:
   - URL: `http://ainfinity-local.local/wp-admin`
   - (Or whatever your Local site URL is)

2. Go to **Plugins** in the left sidebar

3. Find **"Simple LLM Chatbot with Analytics"**

4. Click **Activate**

5. ✅ You should see a success message

### Step 2: Get OpenRouter API Key (2 minutes)

**Option A: Use Free Test Key**
1. Visit [https://openrouter.ai/keys](https://openrouter.ai/keys)
2. Sign up (no credit card required for testing)
3. You get $1 free credit (enough for ~500 test messages)
4. Click "Create Key"
5. Copy the key

**Option B: Use Existing Key**
- If you already have an OpenRouter account, just copy your existing key

### Step 3: Configure Settings (2 minutes)

1. In WordPress Admin, go to **Settings → LLM Chatbot**

2. **Paste your API Key** in the "OpenRouter API Key" field

3. **Choose a Model** (for testing, use the cheapest):
   ```
   anthropic/claude-3-haiku
   ```
   (This costs only $0.00025 per 1K tokens - very cheap for testing)

4. **Update System Prompt** (copy/paste this):
   ```
   You are a helpful customer support assistant for AI Infinity. 
   Be friendly, professional, and concise. 
   Answer questions based on the knowledge base provided.
   If you don't know something, suggest contacting support@ainfinity.shop.
   ```

5. **Add Knowledge Base** (copy/paste this example):
   ```
   COMPANY: AI Infinity
   WEBSITE: ainfinity.shop
   EMAIL: support@ainfinity.shop

   BUSINESS HOURS:
   Monday to Friday: 9 AM - 6 PM EST
   Weekends: Closed

   SERVICES:
   - WordPress Development: Custom themes and plugins
   - AI Integration: Chatbot solutions and LLM integration
   - Web Design: Modern, responsive websites

   FAQ:
   Q: What are your business hours?
   A: We're open Monday to Friday, 9 AM - 6 PM EST. Closed on weekends.

   Q: How do I get a quote?
   A: Contact us at support@ainfinity.shop or use this chat to describe your project.

   Q: What services do you offer?
   A: We specialize in WordPress development, AI integration, and modern web design.

   Q: Do you offer maintenance?
   A: Yes, we offer monthly maintenance packages starting at $99/month.
   ```

6. Click **Save Changes**

7. ✅ You should see "Settings saved successfully!"

### Step 4: Test Frontend Chat (3 minutes)

1. **Open your website** (not admin):
   - URL: `http://ainfinity-local.local`

2. **Look for the chat bubble** (💬) in the bottom-right corner
   - ✅ If you see it, great!
   - ❌ If not, clear cache (Cmd+Shift+R) and refresh

3. **Click the chat bubble**
   - ✅ Chat window should open
   - ✅ You should see "Hello! How can I help you today?"

4. **Test a knowledge-based question**:
   - Type: "What are your business hours?"
   - Press Enter or click Send
   - ✅ You should get: "We're open Monday to Friday, 9 AM - 6 PM EST. Closed on weekends."

5. **Test the feedback system**:
   - After receiving a response, look for 👍 👎 buttons
   - Click one
   - ✅ Button should highlight and the other should disable

6. **Test another question**:
   - Type: "What services do you offer?"
   - ✅ Should mention WordPress, AI, and web design

### Step 5: Test Analytics Dashboard (2 minutes)

1. Go back to WordPress Admin

2. Click **Chat Analytics** in the left sidebar

3. ✅ You should see:
   - **Total Conversations**: 1 (or more)
   - **Total Messages**: 2+ (your test messages)
   - **Success Rate**: Shows percentage if you clicked feedback

4. Scroll down to **"Top 10 Frequently Asked Questions"**
   - ✅ Your test questions should appear here

5. Scroll to **"Recent Interactions"**
   - ✅ Your conversation should be logged with timestamps

### Step 6: Test Error Handling (1 minute)

1. Go to **Settings → LLM Chatbot**

2. **Temporarily remove** the API key (delete it)

3. Click **Save Changes**

4. Go to your website and try to send a message

5. ✅ You should see: "API Key not configured. Please configure in Settings > LLM Chatbot."

6. **Go back and re-enter your API key** and save

## 🎯 What to Look For During Testing

### ✅ Success Indicators
- Chat bubble appears on all public pages
- Chat window opens/closes smoothly
- Messages send and receive correctly
- Responses use your knowledge base
- Feedback buttons work
- Analytics update in real-time
- No JavaScript errors in browser console (F12)

### ❌ Issues to Check
- Chat bubble not appearing → Clear cache
- "API Key not configured" → Re-enter API key in settings
- No response → Check OpenRouter account has credits
- Generic responses → Verify knowledge base is saved
- Console errors → Check browser console (F12)

## 🔍 Browser Console Testing

1. Open your website
2. Press **F12** (or Cmd+Option+I on Mac)
3. Go to **Console** tab
4. Send a test message in the chat
5. ✅ Should see: "Chat error:" messages = problem
6. ✅ Should see: No errors = working correctly

## 📊 Verify Analytics Are Working

After sending 3-5 test messages:

1. Go to **Chat Analytics**
2. Check these metrics update:
   - Total Conversations should be 1+
   - Total Messages should match your test count
   - Recent Interactions should show your messages
   - Top FAQs should list your questions

## 💰 Cost Tracking

During testing with `anthropic/claude-3-haiku`:
- 10 test messages ≈ $0.001 (less than 1 cent)
- 100 test messages ≈ $0.01 (1 cent)

You can monitor usage at [OpenRouter Dashboard](https://openrouter.ai/activity)

## 🚀 Ready to Deploy?

Once all tests pass locally:

### Option A: Upload Plugin Folder
1. Zip the plugin folder: `simple-llm-chatbot/`
2. Upload to production site via:
   - WordPress Admin → Plugins → Add New → Upload
   - Or FTP to `wp-content/plugins/`
3. Activate on production
4. **Important:** Re-enter API key (don't export sensitive data)

### Option B: Use All-in-One WP Migration
1. Export from Local (includes plugin)
2. Import to production site
3. **Important:** Update API key in production settings

## 🔐 Security Checklist Before Production

- [ ] Using production API key (not test key)
- [ ] Knowledge base has no sensitive information
- [ ] Tested on mobile device
- [ ] Checked browser console for errors
- [ ] Verified analytics are logging correctly
- [ ] Set up monitoring for OpenRouter usage/costs

## 📝 Test Scenarios

### Scenario 1: Knowledge Base Question
**Ask:** "What are your business hours?"  
**Expected:** Should return the hours from your knowledge base

### Scenario 2: Service Question
**Ask:** "What services do you offer?"  
**Expected:** Should list your services

### Scenario 3: Unknown Question
**Ask:** "What's the weather today?"  
**Expected:** Should suggest contacting support (not in knowledge base)

### Scenario 4: Follow-up Question
**Ask:** "How much does WordPress development cost?"  
**Expected:** Should provide relevant info or suggest contacting for quote

## 🎨 Visual Testing

### Desktop (1920x1080)
- [ ] Chat bubble visible in bottom-right
- [ ] Chat window opens smoothly
- [ ] Messages display correctly
- [ ] Scrolling works in message area

### Tablet (768x1024)
- [ ] Chat bubble visible
- [ ] Chat window responsive
- [ ] Text input works

### Mobile (375x667)
- [ ] Chat bubble visible
- [ ] Chat window full-screen on mobile
- [ ] Keyboard doesn't cover input

## 📞 Support

If you encounter issues during testing:
1. Check browser console (F12) for errors
2. Review [INSTALLATION.md](INSTALLATION.md)
3. Check OpenRouter dashboard for API errors
4. Open an issue on GitHub

---

**Testing Time:** ~10 minutes  
**Ready for Production:** After all tests pass ✅
