# Real-Time Notifications Debugging Guide

## Quick Checklist

### 1. **Start the Reverb Server** (CRITICAL)
```bash
cd /Users/keshav/Desktop/local/git/acewebx
php artisan reverb:start
```
The server will run on `http://127.0.0.1:8081`

### 2. **Build Frontend Assets**
```bash
cd /Users/keshav/Desktop/local/git/acewebx
npm run build
```
Or for development:
```bash
npm run dev
```

### 3. **Test Notification Manually**
```bash
cd /Users/keshav/Desktop/local/git/acewebx
php test_notification.php
```

---

## Browser Console Debugging

Open your browser's Developer Tools (F12) and go to Console tab. You should see:

```
✅ Setting up notifications for User ID: 1 Role: admin
✅ Admin detected, setting up admin notification channel...
✅ Successfully subscribed to admin-notifications channel
✅ Successfully subscribed to private user channel
```

When a user registers, you should see:
```
🔥 Event .NewUserRegistered received: {...}
🔥 Processing notification: {...}
```

---

## Network Tab Debugging

1. Open Developer Tools → Network tab
2. Filter by "WS" (WebSocket)
3. You should see a WebSocket connection to `127.0.0.1:8081`
4. Status should be `101 Switching Protocols` (green)

If you don't see this:
- ❌ Reverb server is not running
- ❌ Port 8081 is blocked
- ❌ Firewall issue

---

## Common Issues & Solutions

### Issue: No WebSocket connection
**Solution:**
```bash
# Check if port 8081 is in use
lsof -i :8081

# Check Reverb config
cat .env | grep REVERB
```

### Issue: "No user ID found"
**Solution:** Ensure you're logged in as admin user

### Issue: Event not received
**Solution:** Check if notification is actually being saved to database:
```bash
php artisan tinker
>>> User::find(1)->notifications;
```

### Issue: CSRF token error
**Solution:** Already fixed - added CSRF token to Echo config

---

## Files Modified

1. `resources/js/echo.js` - Echo configuration
2. `resources/js/admin/custom.js` - Notification listener
3. `resources/views/admin/layouts/app.blade.php` - Added meta tags
4. `resources/views/admin/components/header.blade.php` - Notification UI
5. `app/Notifications/NewUserRegisteredNotification.php` - Notification class
6. `routes/channels.php` - Broadcast channel
7. `app/Http/Controllers/Auth/AuthController.php` - Send notification

---

## Step-by-Step Testing

1. **Terminal 1:** Start Reverb
   ```bash
   php artisan reverb:start
   ```

2. **Terminal 2:** Start Laravel dev server (if not using built-in)
   ```bash
   php artisan serve
   ```

3. **Browser:** 
   - Login as admin
   - Open Dev Tools (F12)
   - Go to Console tab
   - You should see subscription logs

4. **Terminal 3:** Register a new user OR run:
   ```bash
   php test_notification.php
   ```

5. **Browser:** 
   - Should see toast notification appear
   - Should see notification in dropdown
   - Should see logs in console

---

## Database Check

If notifications are in DB but not showing in real-time:

```bash
php artisan tinker
>>> $admin = User::where('role', 'admin')->first();
>>> $admin->notifications()->latest()->first();
```

This will show if notification was saved.

---

## Version Info
- Laravel Echo: 2.3.0+
- Reverb: Latest (in Laravel 11+)
- Browser: Modern browser with WebSocket support
