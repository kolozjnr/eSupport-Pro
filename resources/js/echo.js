// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: "78dd72cf727a312f6ef2", // Your actual key from .env
//     cluster: "eu",
//     forceTLS: true,
//     enabledTransports: ['ws', 'wss'],
//     disabledTransports: ['xhr_polling', 'xhr_streaming', 'sockjs'],
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
//         }
//     }
// });

// console.log('Echo initialized with direct credentials');


// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });



//Pusher Global Echo



// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? "mt1",
//     forceTLS: true,
//     // For web auth, Laravel uses session + CSRF token
//     authEndpoint: "/broadcasting/auth",
//     auth: {
//         headers: {
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
//         },
//     },
// });
