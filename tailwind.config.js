/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                themeblack: "#0B0E2D",
                blue_secondary: "#1275EE",
                input_black: "#1A1D3F",
                border_input: "#2C3059",
            },
            fontFamily: {
                sans: ["Source Sans 3", "sans-serif"],
                hanken: ["Hanken Grotesk", "sans-serif"],
                inter: ["Inter", "sans-serif"],
                cal: ["Cal Sans", "sans-serif"],
            },
        },
    },
    plugins: [require("flowbite/plugin-windicss")],
};
