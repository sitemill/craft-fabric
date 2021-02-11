module.exports = {
    purge: false,
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            spacing: {
                'sidebar': '250px',
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
            },
            boxShadow: {
                '3xl': '0 0px 60px -15px rgba(0, 0, 0, 0.3)',
            },
            screens: {
                '3xl': '1800px',
                '4xl': '2200px'
            }
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '3rem',
                xl: '3rem',
                '2xl': '3rem'
            },

        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        function({addComponents}) {
            addComponents({
                '.container-full': {
                    "@apply container": {},
                    '@screen sm': {
                        maxWidth: '100%',
                    },
                    '@screen md': {
                        maxWidth: '100%',
                    },
                    '@screen lg': {
                        maxWidth: '100%',
                    },
                    '@screen xl': {
                        maxWidth: '100%',
                    },
                }
            })
        }
    ],
}
