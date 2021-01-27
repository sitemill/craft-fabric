module.exports = {
    purge: false,
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            spacing: {
                'sidebar': '275px',
                'dialog': '500px',
                'dropdown': '130px',
            },
            maxWidth: {
                'brand': '230px',
                'action-page-card': '350px'
            },
            colors: {
                primary: '#6816D0',
            },
            animation: {
                loader: 'loader .5s linear infinite',
            },
            keyframes: {
                loader: {
                    '0%': {left: '-100%'},
                    '100%': {left: '100%'}
                }
            }
        },
        container: {
            center: true,
            maxWidth: '100%',
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
