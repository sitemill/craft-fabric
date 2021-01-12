module.exports = {
    purge: false,
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            spacing: {
                'sidebar': '275px',
                'sidebar-negative': '-275px',
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
