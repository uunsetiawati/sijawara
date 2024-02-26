<template>
</template>

<script>
    import postscribe from 'postscribe';
    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                
            }
        },
        methods: {
            checkOauthLogin() {
                var vm = this;
                if(this.$route.query.type && this.$route.query.otp && this.$route.query.email) {
                    vm.$auth.login({
                        data: {
                            email: this.$route.query.email,
                            otp: this.$route.query.otp,
                            type: 'gotp'
                        },
                        success: function(res) {
                            setTimeout(function(){
                                postscribe('#core', `<script src="${process.env.MIX_APP_URL}/assets/js/scripts.bundle.js"><\/script>`);
                            }, 2000);
                        },
                        error: function (err) {
                            vm.$router.push({name: 'login'});
                        },
                        rememberMe: true,
                        redirect: ((localStorage.getItem('redirect_login')) ? JSON.parse(atob(localStorage.getItem('redirect_login'))) : {name: 'home'}),
                        fetchUser: true
                    });
                }
            },
        },
        created() {
            this.checkOauthLogin()
        }
    }
</script>