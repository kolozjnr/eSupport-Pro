// If you're using Alpine.js
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

// If you're using AOS (Animate On Scroll)
// import AOS from 'aos'
// import 'aos/dist/aos.css'
// AOS.init()

// Example: simple scroll listener
window.addEventListener('scroll', () => {
    console.log('Scrolled!');
});

// Add your custom JS here
console.log('Landing page JS loaded');
