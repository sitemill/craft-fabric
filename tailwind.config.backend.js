module.exports = {
    purge: false,
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
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
