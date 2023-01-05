/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./pages/**/*.{html,php}", "./components/**/*.{html,php}"],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}
