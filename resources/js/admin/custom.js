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

// Get notification when user register (Start)
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


// Get notification when user register 
function showNotificationToast(userName) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse z-50';
    toast.innerHTML = `✅ <strong>${userName}</strong> has registered!`;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 5000);
}


function handleNewUserNotification(e) {
    console.log("Processing notification:", e);
    let message = e.data?.message || e.message || 'New notification';
    let userName = e.data?.user_name || e.user_name || 'User';
    let userEmail = e.data?.user_email || e.user_email || '';
    let list = document.getElementById("notification-list");
    if (list) {
        const noNotifMsg = list.querySelector('.text-gray-500');
        if (noNotifMsg) {
            noNotifMsg.remove();
        }
        const notifDiv = document.createElement('div');
        notifDiv.className = 'px-4 py-3 border-b hover:bg-gray-100 transition cursor-pointer';
        if (userEmail) {
            notifDiv.title = userEmail;
        }
        notifDiv.innerHTML = `<strong>${userName}</strong> just registered`;
        list.insertBefore(notifDiv, list.firstChild);
    }
    showNotificationToast(userName);
    document.dispatchEvent(new CustomEvent('new-notification'));
    $('#showdots').removeClass('hidden');
}
// Get notification when user register (End)

// Genrate password js for admin  (Start)
$(document).ready(function () {
    $("#generatePasswordBtn").click(function () {
        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$!";
        let password = "";
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $("#passwordField").val(password);
    });
});
// Genrate password js for admin  (Start)



// menu js Start
$(function(){

    let menuItems = [];

    const menuSelect = $('#menuSelect');
    const menuName = $('#menuName');
    const menuIdInput = $('#menu_id');
    const container = $('#menuItemsContainer');
    const menuData = $('#menuData');

    // =============================
    // HELPERS
    // =============================

    function resetMenuUI(){
        menuItems = [];
        container.html('<p class="text-gray-500 text-sm">No menu items added</p>');
        menuData.val('');
        menuName.val('');
        menuIdInput.val('');
        $('input[name="settings[]"]').prop('checked', false);
    }

    function renderMenuItems(){
        if(!menuItems.length){
            return container.html('<p class="text-gray-500 text-sm">No menu items added</p>');
        }

        let html = menuItems.map(item => `
            <div class="border border-gray-300 rounded p-2 flex justify-between items-center">
                <span>${item.title}</span>
                <button type="button" class="text-red-600 text-sm removeItemBtn">Remove</button>
            </div>
        `).join('');

        container.html(html);
    }

    function updateHiddenData(){
        menuData.val(JSON.stringify(menuItems));
    }

    function applySettings(settings = {}){
        $('input[name="settings[]"]').prop('checked', false);

        if(settings.auto_add_pages){
            $('input[value="auto_add"]').prop('checked', true);
        }

        if(settings.location){
            $('input[value="'+settings.location+'"]').prop('checked', true);
        }
    }

    // =============================
    // CREATE MENU CLICK
    // =============================
    $('#create_menu').click(function(){
        $('#menuName_outer').removeClass('hidden');
        menuSelect.val('');
        resetMenuUI();
    });

    // =============================
    // LOAD MENU FROM DROPDOWN
    // =============================
    menuSelect.change(function(){

        let id = $(this).val();
        let text = $.trim($(this).find(':selected').text());

        $('#menuName_outer').removeClass('hidden');
        menuName.val(text);
        menuIdInput.val(id);

        if(!id) return resetMenuUI();

        $.get('/ace-admin/menu/' + id)
        .done(function(res){
            menuItems = res.data || [];
            renderMenuItems();
            updateHiddenData();
            applySettings(res.settings);
        })
        .fail(() => alert('Failed to load menu'));
    });

    // =============================
    // AUTO LOAD SELECTED MENU
    // =============================
    if(menuSelect.val()) menuSelect.trigger('change');

    // =============================
    // ADD MENU ITEMS
    // =============================
    $('#addMenuBtn').click(function(){

        $('.page-checkbox:checked').each(function(){

            let parent = $(this).closest('label');

            menuItems.push({
                id: $(this).val(),
                title: parent.find('span').text(),
                slug: parent.find('.page-slug').val(),
                url: '/' + parent.find('.page-slug').val(),
                parent_id: null
            });

            $(this).prop('checked', false);
        });

        renderMenuItems();
        updateHiddenData();
    });

    // =============================
    // REMOVE MENU ITEM
    // =============================
    container.on('click', '.removeItemBtn', function(){
        let index = $(this).closest('div').index();
        menuItems.splice(index, 1);
        renderMenuItems();
        updateHiddenData();
    });

    // =============================
    // DELETE MENU
    // =============================
    $('#clearMenuBtn').click(function(){

        let id = menuSelect.val();

        if(!id) return alert('Please select a menu first');
        if(!confirm('Delete this menu?')) return;

        $.ajax({
            url: '/ace-admin/menu/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(){
                alert('Menu deleted successfully');
                menuSelect.find(':selected').remove();
                resetMenuUI();
            }
        });
    });

});
// menu js End