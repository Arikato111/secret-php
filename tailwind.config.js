/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./pages/**/*.{html,php}", "./components/**/*.{html,php}"],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}
