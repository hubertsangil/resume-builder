/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        'dm-sans': ['DM Sans', 'sans-serif'],
      },
      colors: {
        'resume-dark': '#000000',
        'resume-light': '#ffffff',
        'resume-gray': {
          100: 'rgba(255,255,255,0.08)',
          200: 'rgba(255,255,255,0.12)',
          300: 'rgba(255,255,255,0.18)',
          400: 'rgba(255,255,255,0.3)',
          500: 'rgba(255,255,255,0.5)',
        },
        'timeline': {
          line: 'rgb(39, 39, 39)',
          dot: '#222222',
          border: '#606060',
        },
      },
      gridTemplateAreas: {
        'bento': [
          'about experience',
          'tech-stack experience',
          'education projects',
        ],
        'bento-mobile': [
          'about',
          'tech-stack',
          'experience',
          'education',
          'projects',
        ],
      },
      animation: {
        'fade-in-up': 'fadeInUp 1s ease-out forwards',
      },
      keyframes: {
        fadeInUp: {
          '0%': {
            opacity: '0',
            transform: 'translateY(30px)',
          },
          '100%': {
            opacity: '1',
            transform: 'translateY(0)',
          },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}