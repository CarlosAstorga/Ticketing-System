window._ = require('lodash');
window.bootstrap = require('bootstrap');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

// Event listeners
if (document.getElementById('logout') && document.getElementById('logoutForm')) {
    const form = document.getElementById('logoutForm');
    const link = document.getElementById('logout');
    link.addEventListener('click', e => {
        e.preventDefault();
        form.submit();
    });
}

if (document.getElementById('saveBtn') && document.getElementById('form')) {
    const form = document.getElementById('form');
    const btn = document.getElementById('saveBtn');
    btn.addEventListener('click', e => {
        e.target.disabled = true;
        e.target.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="visually-hidden">Loading...</span>`;
        form.submit();
    });
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
