/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js", // 👈 Add this
    ],
    theme: {
        extend: {
            fontFamily: {
                khmer: ["Battambang", "sans-serif"],
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
