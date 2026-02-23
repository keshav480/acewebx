import $ from "jquery";

window.autoHideMessage = function (selector = ".message", delay = 4000) {
    const $msg = $(selector);

    if (!$msg.length) return;

    setTimeout(function () {
        $msg.fadeOut(500, function () {
            $(this).remove();
        });
    }, delay);
};

$(document).ready(function () {
    autoHideMessage();
});

document.addEventListener("DOMContentLoaded", function () {

    let userId = document.querySelector('meta[name="user-id"]')?.content;
    let userRole = document.querySelector('meta[name="user-role"]')?.content;

    if (!userId) {
        return;
    }
    if (typeof window.Echo === 'undefined') {
        console.error("Laravel Echo not initialized");
        return;
    }

    // Admin channel for new user registration notifications
    if (userRole === 'admin') {        
        window.Echo.channel('admin-notifications')
            .subscribed(() => {})
            .error((error) => {
                console.error("❌ Error subscribing to admin-notifications:", error);
            })
            .listen('.NewUserRegistered', (e) => {
                handleNewUserNotification(e);
            })
            .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
                console.log("🔥 Event BroadcastNotificationCreated received:", e);
                handleNewUserNotification(e);
            });
    }

    // Private channel for user's own notifications
    window.Echo.private(`App.Models.User.${userId}`)
        .subscribed(() => {})
        .error((error) => {
            console.error("❌ Error subscribing to private channel:", error);
        })
        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
            console.log("🔥 Private notification received:", e);
            handleNewUserNotification(e);
        });

});

// Toast notification function
function showNotificationToast(userName) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse z-50';
    toast.innerHTML = `✅ <strong>${userName}</strong> has registered!`;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 5000);
}

// Handle new user notification
function handleNewUserNotification(e) {
    console.log("Processing notification:", e);
    
    let message = e.data?.message || e.message || 'New notification';
    let userName = e.data?.user_name || e.user_name || 'User';
    let userEmail = e.data?.user_email || e.user_email || '';

    let list = document.getElementById("notification-list");

    if (list) {
        // Remove "No new notifications" message if it exists
        const noNotifMsg = list.querySelector('.text-gray-500');
        if (noNotifMsg) {
            noNotifMsg.remove();
        }

        // Add new notification at the top
        const notifDiv = document.createElement('div');
        notifDiv.className = 'px-4 py-3 border-b hover:bg-gray-100 transition cursor-pointer';
        if (userEmail) {
            notifDiv.title = userEmail;
        }
        notifDiv.innerHTML = `<strong>${userName}</strong> just registered`;
        
        list.insertBefore(notifDiv, list.firstChild);
    }

    // Show toast notification
    showNotificationToast(userName);

    // trigger Alpine orange dot to show notification badge
    document.dispatchEvent(new CustomEvent('new-notification'));
}
