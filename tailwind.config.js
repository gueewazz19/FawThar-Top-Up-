/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#ecfeff',
          100: '#cffafe',
          200: '#a5f3fc',
          300: '#67e8f9',
          400: '#22d3ee',
          500: '#06b6d4',
          600: '#0891b2',
          700: '#0e7490',
          800: '#155e75',
          900: '#164e63',
          950: '#083344',
        },
        dark: {
          bg: '#080C14',
          surface: '#0F1626',
          card: '#141E34',
          border: '#1F2E4A',
          hover: '#1B2844',
        },
        neon: {
          emerald: '#10B981',
          cyan: '#06B6D4',
          amber: '#F59E0B',
          purple: '#8B5CF6',
        }
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        display: ['Outfit', 'Inter', 'sans-serif'],
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(24px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        pulseSlow: {
          '0%, 100%': { opacity: '0.15', transform: 'scale(1)' },
          '50%': { opacity: '0.3', transform: 'scale(1.08)' },
        },
        slideInRight: {
          '0%': { opacity: '0', transform: 'translateX(60px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideInLeft: {
          '0%': { opacity: '0', transform: 'translateX(-60px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        shimmer: {
          '0%': { transform: 'translateX(-100%)' },
          '100%': { transform: 'translateX(100%)' },
        }
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both',
        'fade-in': 'fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both',
        'slide-in-right': 'slideInRight 0.85s cubic-bezier(0.16, 1, 0.3, 1) both',
        'slide-in-left': 'slideInLeft 0.85s cubic-bezier(0.16, 1, 0.3, 1) both',
        'float': 'float 5s ease-in-out infinite',
        'pulse-slow': 'pulseSlow 7s ease-in-out infinite',
        'shimmer': 'shimmer 2.5s infinite',
      },
      boxShadow: {
        'glow-emerald': '0 0 20px -3px rgba(16, 185, 129, 0.45)',
        'glow-cyan': '0 0 20px -3px rgba(6, 182, 212, 0.45)',
        'glow-amber': '0 0 20px -3px rgba(245, 158, 11, 0.45)',
      }
    },
  },
  plugins: [],
}
