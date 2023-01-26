/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    'templates/**/*.html.twig',
    'assets/js/**/*.js',
    'assets/js/**/*.jsx',
  ],
  theme: {
    extend: {
      fontFamily : {
        'font1' : ['serif', 'Arial'], 
        'font2' : ['serif', 'Calibri'], 
      }, 
      colors: {
        'blue1' : '#355689', 
        'blue2' : '#D8E5F8', 
        'pink'  : "#A41C66", 
        'grey1' : '#424242', 
        'grey2' : '#5B5B5B', 
        'grey4' : '#686868', 
        'grey4' : '#EBEBEB', 
        'grey5' : '#F0F0F0', 
        "white" : '#FFFFFF',
      }
    },
  },
  plugins: [],
}