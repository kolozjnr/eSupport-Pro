import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/landing/**/*.{html,js}', // <-- landing files included
  ],

  darkMode: 'class',

  theme: {
    fontFamily: {
      heading: "'Lexend', sans-serif",
      body: "'Inter', sans-serif",
      sans: ['Figtree', ...defaultTheme.fontFamily.sans],
    },

    container: {
      center: true,
      padding: '1rem',
    },

    colors: {
      current: 'currentColor',
      transparent: 'transparent',
      white: '#FFFFFF',
      primary: '#4A6CF7',
      'dark-text': '#79808A',
      dark: '#111722',
      stroke: '#e5e7eb',
    },

    screens: {
      xs: '500px',
      sm: '540px',
      md: '768px',
      lg: '992px',
      xl: '1140px',
      '2xl': '1320px',
    },

    extend: {
      backgroundImage: {
        'noise-pattern': "url('../images/NoisePattern.svg')",
      },
      dropShadow: {
        light: 'drop-shadow(0px 1px 5px rgba(0, 0, 0, 0.1))',
      },
    },
  },

  plugins: [forms],
};
