import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],
    theme: {
        extend: {
            colors: {
                "secondary-fixed": "#d7e2ff", "outline": "#727970", "secondary": "#115cb9", "on-tertiary-fixed-variant": "#5a4300",
                "inverse-surface": "#2f312e", "on-secondary-fixed": "#001a40", "surface-dim": "#d9dad6", "on-secondary": "#ffffff",
                "error-container": "#ffdad6", "on-error-container": "#93000a", "error": "#ba1a1a", "surface-container-high": "#e8e9e4",
                "inverse-on-surface": "#f0f1ec", "tertiary-fixed-dim": "#f2c03a", "inverse-primary": "#a4d2a9", "secondary-container": "#659dfe",
                "on-secondary-container": "#003370", "primary-fixed": "#c0eec4", "on-tertiary": "#ffffff", "surface-container-low": "#f3f4ef",
                "primary-fixed-dim": "#a4d2a9", "surface-container-highest": "#e2e3de", "on-tertiary-container": "#b78c00", "on-primary-fixed": "#00210b",
                "on-primary-fixed-variant": "#274f30", "tertiary": "#1f1500", "surface-container": "#edeee9", "on-tertiary-fixed": "#251a00",
                "primary-container": "#073216", "surface-variant": "#e2e3de", "surface": "#f9faf5", "surface-tint": "#3e6746",
                "primary": "#001b08", "on-primary-container": "#719c77", "tertiary-container": "#382900", "on-surface-variant": "#424941",
                "on-error": "#ffffff", "outline-variant": "#c1c9bf", "tertiary-fixed": "#ffdf98", "surface-bright": "#f9faf5",
                "on-surface": "#1a1c19", "secondary-fixed-dim": "#acc7ff", "background": "#f9faf5", "on-background": "#1a1c19",
                "on-secondary-fixed-variant": "#004591", "surface-container-lowest": "#ffffff", "on-primary": "#ffffff"
            },
            fontFamily: {
                "body-lg": ["Inter", ...defaultTheme.fontFamily.sans],
                "h1": ["Manrope", ...defaultTheme.fontFamily.sans],
                "h3": ["Manrope", ...defaultTheme.fontFamily.sans],
                "label-sm": ["Inter", ...defaultTheme.fontFamily.sans],
                "body-md": ["Inter", ...defaultTheme.fontFamily.sans],
                "h2": ["Manrope", ...defaultTheme.fontFamily.sans],
                "caption": ["Inter", ...defaultTheme.fontFamily.sans]
            },
            fontSize: {
                "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                "h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                "h3": ["24px", { "lineHeight": "1.3", "fontWeight": "600" }],
                "label-sm": ["14px", { "lineHeight": "1.4", "letterSpacing": "0.01em", "fontWeight": "600" }],
                "body-md": ["16px", { "lineHeight": "1.5", "fontWeight": "400" }],
                "h2": ["36px", { "lineHeight": "1.25", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                "caption": ["12px", { "lineHeight": "1.4", "fontWeight": "400" }]
            }
        },
    },
    plugins: [forms],
};