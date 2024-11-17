export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.svelte',
    ],
    theme: {
        extend: {
            fontFamily: {
                grandstander: ['Grandstander Variable', 'system-ui'],
                rubik: ['Rubik Variable', 'sans-serif']
            },
            colors: {
                user_gained: 'green',
                user_lost: 'red',
                game_added: 'blue',
                game_removed: 'orange',
                paper: 'efefef',
                box: 'dedede'
            }
        },
    },
    plugins: [],
}