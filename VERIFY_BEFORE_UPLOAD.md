# ✅ Verify Before Upload - Quick Checklist

## 🎯 The plugin is ALREADY in your Local WordPress!

**Location:** `Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/`

## 📋 5-Minute Verification

### ✅ Step 1: Activate (30 seconds)
```
1. Open: http://ainfinity-local.local/wp-admin
2. Click: Plugins
3. Find: "Simple LLM Chatbot with Analytics"
4. Click: Activate
```
**Expected:** Green success message

---

### ✅ Step 2: Get API Key (2 minutes)
```
1. Visit: https://openrouter.ai/keys
2. Sign up (free $1 credit - no card required)
3. Click: Create Key
4. Copy the key
```
**Expected:** A key like `sk-or-v1-xxxxx...`

---

### ✅ Step 3: Configure (1 minute)
```
1. WordPress Admin → Settings → LLM Chatbot
2. Paste API key
3. Model: anthropic/claude-3-haiku
4. System Prompt: "You are a helpful assistant for AI Infinity."
5. Knowledge Base: (see below)
6. Click: Save Changes
```

**Knowledge Base (Copy This):**
```
COMPANY: AI Infinity
EMAIL: support@ainfinity.shop
HOURS: Monday-Friday 9AM-6PM EST

FAQ:
Q: What are your business hours?
A: Monday to Friday, 9 AM - 6 PM EST.

Q: How do I contact you?
A: Email support@ainfinity.shop or use this chat.
```

**Expected:** "Settings saved successfully!"

---

### ✅ Step 4: Test Frontend (1 minute)
```
1. Visit: http://ainfinity-local.local
2. Look bottom-right corner
3. See chat bubble (💬)?
4. Click it
5. Type: "What are your business hours?"
6. Press Enter
```

**Expected:** 
- Chat window opens
- You see "Hello! How can I help you today?"
- After sending, you get: "Monday to Friday, 9 AM - 6 PM EST."
- You see 👍 👎 buttons

---

### ✅ Step 5: Test Analytics (30 seconds)
```
1. WordPress Admin → Chat Analytics
2. Check the dashboard
```

**Expected:**
- Total Conversations: 1
- Total Messages: 2+
- Your question appears in "Recent Interactions"
- Your question appears in "Top 10 FAQs"

---

## ✅ All Tests Passed?

### You're Ready to Upload!

**For Production Upload:**

**Option A: Download from GitHub**
1. Go to: [https://github.com/Jasoncheery/wordpress-ai-chatbot](https://github.com/Jasoncheery/wordpress-ai-chatbot)
2. Click: Code → Download ZIP
3. Production WordPress → Plugins → Add New → Upload Plugin
4. Upload ZIP → Install → Activate
5. Settings → LLM Chatbot → Enter production API key

**Option B: Use Local Copy**
1. Zip the folder: `~/Local Sites/ainfinity-local/app/public/wp-content/plugins/simple-llm-chatbot/`
2. Upload to production WordPress
3. Activate and configure

---

## 🐛 Troubleshooting

### ❌ Chat bubble not appearing
```bash
# Clear browser cache
Cmd + Shift + R (Mac)
Ctrl + Shift + R (Windows)
```

### ❌ "API Key not configured" error
```
1. Settings → LLM Chatbot
2. Re-enter API key
3. Save Changes
4. Refresh website
```

### ❌ No response from chatbot
```
1. Check OpenRouter dashboard: https://openrouter.ai/activity
2. Verify you have credits
3. Check API key is correct
4. Try different model
```

### ❌ Plugin not in Plugins list
```
1. Check folder name is: simple-llm-chatbot
2. Check simple-llm-chatbot.php is in folder root
3. Refresh Plugins page
```

---

## 🎉 Success Indicators

- ✅ Chat bubble visible on website
- ✅ Chat opens and closes smoothly
- ✅ Messages send and receive
- ✅ Responses use your knowledge base
- ✅ Feedback buttons work
- ✅ Analytics update correctly
- ✅ No errors in browser console (F12)

---

## 📊 Monitor Costs

**During Testing:**
- Check: [https://openrouter.ai/activity](https://openrouter.ai/activity)
- With Claude Haiku: 100 tests ≈ $0.01 (1 cent)

**In Production:**
- Set up billing alerts
- Monitor daily usage
- Typical site: $1-5/month

---

## 🔐 Security Reminder

**Before Production:**
- [ ] Use production API key (not test key)
- [ ] Don't share API key publicly
- [ ] Remove test data from knowledge base
- [ ] Test on staging first (if available)

---

**Testing Time:** 5 minutes  
**Cost:** < $0.01 with free credits  
**Difficulty:** Beginner-friendly ✅
