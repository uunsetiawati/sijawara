<template>
    <!-- <div class="d-flex flex-column flex-root"> -->
            <!--begin::Login-->
            <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
                <!--begin::Aside-->
                <div class="login-aside d-flex flex-column flex-row-auto bgi-no-repeat" :style="(($parent.setting.backgrounddir ) ? 'background-image: url('+$parent.setting.backgrounddir+');' : '')">
                    <!--begin::Aside Top-->
                    <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                        <!--begin::Aside header-->
                        <span class="text-center mb-23">
                            <!-- <img v-if="$parent.setting.logodarkdir" :src="$parent.setting.logodarkdir" class="max-h-70px" alt="Logo" style="width: 210px" /> -->
                        </span>
                        <!--end::Aside header-->
                        <!--begin::Aside title-->
                        <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #986923;"></h3>
                        <!--end::Aside title-->
                    </div>
                    <!--end::Aside Top-->
                    <!--begin::Aside Bottom-->
                    <div class="aside-img d-flex flex-row-fluid" style="height: 100%; min-height: 580px;"></div>
                    <!--end::Aside Bottom-->
                </div>
                <!--begin::Aside-->
                <!--begin::Content-->
                <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
                    <!--begin::Content body-->
                    <div class="d-flex flex-column-fluid flex-center">
                        <!--begin::Signin-->
                        <div class="login-form login-signin">
                            <!--begin::Form-->
                            <form class="form" novalidate="novalidate" @submit.prevent="submitCheck" id="kt_login_signin_form">
                                <!--begin::Title-->
                                <div class="pb-13 pt-lg-0 pt-5">
                                    <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg text-center">
                                        <a :href="`${base_url}/landing`" class="">
                                            <img v-if="$parent.setting.logodarkdir" :src="$parent.setting.logodarkdir" class="max-h-70px" alt="Logo" />
                                        </a>
                                    </h3>
                                    <!-- <span class="text-muted font-weight-bold font-size-h4">New Here?
                                    <a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder">Create an Account</a></span> -->
                                </div>
                                <oauth-button></oauth-button>
                                <div class="border-bottom my-10"></div>
                                <div id="emessage"></div>
                                <!--begin::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark-65">{{ $t('login.email_phone') }}</label>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" tabindex="1" type="text" name="auth" v-model="user.auth" @input="resetAction" :placeholder="$t('login.email_phone')" />
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
                                    <div v-if="loginType == 'email'" class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark-65">{{ $t('login.password') }}</label>
                                        <input tabindex="2" id="pwdIndex" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" v-model="user.password" :placeholder="$t('login.password')" />
                                    </div>
                                </transition>
                                <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
                                    <div v-if="loginType == 'phone'" class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark-65">{{ $t('login.otp_code') }}</label>
                                        <!-- <input tabindex="2" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="number" name="otp" v-model="user.otp" placeholder="Kode OTP" /> -->
                                        <div style="display: flex; flex-direction: row; width: 300px;">
                                            <v-otp-input
                                                ref="otpInput"
                                                input-classes="form-control formOtp"
                                                separator="&nbsp;&nbsp;&nbsp;&nbsp;"
                                                :num-inputs="6"
                                                :should-auto-focus="true"
                                                :is-input-num="true"
                                                @on-change="handleOnChange"
                                                @on-complete="handleOnComplete"
                                            />
                                        </div>
                                        <div class="d-flex  mt-5">
                                            <label for="">{{ $t('login.not_recive_code') }} </label>
                                            <a href="javascript:void(0);" @click="getOtp" class="text-primary font-weight-bolder text-hover-primary pl-1" id="otp_resend">{{ $t('login.resend') }} <span>{{ countDown }}</span></a>
                                        </div>
                                    </div>
                                </transition>
                                <div v-if="loginType == 'email'" class="d-flex justify-content-between mt-5">
                                    <label for=""></label>
                                    <router-link :to="{name: 'forgot'}" class="text-primary font-weight-bolder text-hover-primary">{{ $t('login.forgot') }}</router-link>
                                </div>
                                <div class="d-flex mt-5 font-size-h6">
                                    <label for="">{{ $t('login.dont_have_acc') }}&nbsp;</label>
                                    <oauth-button>
                                        <template slot="register">
                                            <a class="text-primary font-weight-bolder text-hover-primary cursor-pointer">{{ $t('login.register') }}</a>
                                        </template>
                                    </oauth-button>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="pb-lg-0 pb-5">
                                    <button id="btnMasuk" tabindex="3" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3 btn-caption" data-caption="Masuk" type="submit">{{ $t('login.signin') }}</button>
                                </div>
                                <!--end::Action-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Signin-->
                    </div>
                    <!--end::Content body-->
                    <!--begin::Content footer-->
                    <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                        <!-- <a href="#" class="text-primary font-weight-bolder font-size-h5">Terms</a> -->
                        <!-- <a href="#" class="text-primary ml-10 font-weight-bolder font-size-h5">Plans</a> -->
                        <!-- <a href="#" class="text-primary ml-10 font-weight-bolder font-size-h5">Contact Us</a> -->
                    </div>
                    <!--end::Content footer-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Login-->
        <!-- </div> -->
</template>

<script>
    import postscribe from 'postscribe';
    import OtpInput from "@bachdgvn/vue-otp-input";
    export default {
        components: {
            'v-otp-input': OtpInput
        },
        data() {
            return {
                user: {},
                loginType: null,
                countDown: null,
                cdInterval: null,
            }
        },
        methods: {
            handleOnChange(v) {
                $('.formOtp').toggleClass('otp-invalid', false);
                this.user.otp = v;
            },
            handleOnComplete(v) {
                this.user.otp = v;
                this.submitCheck();
            },
            submitCheck() {
                if (this.loginType == null) {
                    this.checkCredentials();
                }else {
                    this.login();
                }
            },
            resetAction() {
                this.loginType = null;
            },
            checkCredentials() {
                var vm = this;
                var emessage = $('#emessage');
                var btn = KTUtil.getById('btnMasuk');
                KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");
                emessage.html('')
                vm.$http({
                    url: '/secure/checkCredentials',
                    method: 'POST',
                    data: {auth: vm.user.auth}
                }).then((res) => {
                    KTUtil.btnRelease(btn);
                    vm.loginType = res.data.data.login_type;
                    if(vm.loginType == 'phone') {
                        vm.user.auth = res.data.data.phone;
                        vm.getOtp();
                    }
                }).catch((error) => {
                    emessage.html('<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert"><div class="alert-icon"><i class="flaticon-warning"></i></div><div class="alert-text">'+error.response.data.message+'</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                    KTUtil.btnRelease(btn);
                });
            },
            getOtp() {
                var vm = this;
                var emessage = $('#emessage');
                var btn = KTUtil.getById('btnMasuk');
                KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");
                emessage.html('')
                if(vm.cdInterval){
                    clearInterval(vm.cdInterval);
                }
                vm.cdInterval = null;
                setTimeout(function() {
                    $('#otp_resend').toggleClass('disabled', true);
                })
                vm.$http({
                    url: '/secure/getOtp',
                    method: 'POST',
                    data: {phone: vm.user.auth}
                }).then((res) => {
                    KTUtil.btnRelease(btn);
                    emessage.html('<div class="alert alert-custom alert-notice alert-light-success fade show" role="alert"><div class="alert-icon"><i class="flaticon2-check-mark"></i></div><div class="alert-text">'+res.data.data.message+'</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                    var to = res.data.data.resend_time;
                    vm.cdInterval = setInterval(function() {
                        vm.countDown = "("+to+")";
                        to--;
                        if (to == -1) {
                            clearInterval(vm.cdInterval);
                            vm.countDown = null;
                            $('#otp_resend').toggleClass('disabled', false);

                        }
                    }, 1000);
                }).catch((error) => {
                    KTUtil.btnRelease(btn);
                    emessage.html('<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert"><div class="alert-icon"><i class="flaticon-warning"></i></div><div class="alert-text">'+error.response.data.message+'</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                    if (error.response.data.data.resend_time) {
                        var to = error.response.data.data.resend_time;
                        vm.cdInterval = setInterval(function() {
                            vm.countDown = "("+to+")";
                            emessage.html('<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert"><div class="alert-icon"><i class="flaticon-warning"></i></div><div class="alert-text">Tunggu '+to+' detik.</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                            to--;
                            if (to == -1) {
                                emessage.html('')
                                clearInterval(vm.cdInterval);
                                vm.countDown = null;
                                $('#otp_resend').toggleClass('disabled', false);

                            }
                        }, 1000);
                    }
                    
                });
            },
            login() {
                var app = this;
                // KTApp.progress(e[0]);
                var btn = KTUtil.getById('btnMasuk');
                var emessage = $('#emessage');
                KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");

                var datasend = {};
                $('.formOtp').toggleClass('otp-invalid', false);

                if (this.loginType == 'email') {
                    datasend.email = app.user.auth;
                    datasend.password = app.user.password;
                    datasend.type = this.loginType;
                }else{
                    datasend.phone = app.user.auth;
                    datasend.otp = app.user.otp;
                    datasend.type = this.loginType;
                }

                // let redirect = app.$auth.redirect();
                // console.log(redirect)

                app.$auth.login({
                    data: datasend,
                    success: function(res) {
                        emessage.html('<div class="alert alert-custom alert-notice alert-light-success fade show" role="alert"><div class="alert-icon"><i class="flaticon2-check-mark"></i></div><div class="alert-text">Welcome!</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                        KTUtil.btnRelease(btn);
                        setTimeout(function(){
                            postscribe('#core', `<script src="${process.env.MIX_APP_URL}/assets/js/scripts.bundle.js"><\/script>`);
                        }, 2000);
                    },
                    error: function(err) {
                        if(app.loginType == 'phone') {
                            $('.formOtp').toggleClass('otp-invalid', true);
                        }
                        emessage.html('<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert"><div class="alert-icon"><i class="flaticon-warning"></i></div><div class="alert-text">'+err.response.data.message+'</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>');
                        KTUtil.btnRelease(btn);
                    },
                    rememberMe: false,
                    redirect: ((localStorage.getItem('redirect_login')) ? JSON.parse(atob(localStorage.getItem('redirect_login'))) : {name: 'home'}),
                    fetchUser: true
                });
            },
        },
        mounted() {
            var app = this;
        },
        style: `
        a.disabled {
          pointer-events: none;
          cursor: default;
        }
        .formOtp {width: 37px!important;}
        .otp-invalid {border-color: #f64e60!important;}
        .login.login-1 .login-aside .aside-img{min-height:450px}.login.login-1 .login-forgot,.login.login-1 .login-signin,.login.login-1 .login-signup{display:none}.login.login-1.login-signin-on .login-signup{display:none}.login.login-1.login-signin-on .login-signin{display:block}.login.login-1.login-signin-on .login-forgot{display:none}.login.login-1.login-signup-on .login-signup{display:block}.login.login-1.login-signup-on .login-signin{display:none}.login.login-1.login-signup-on .login-forgot{display:none}.login.login-1.login-forgot-on .login-signup{display:none}.login.login-1.login-forgot-on .login-signin{display:none}.login.login-1.login-forgot-on .login-forgot{display:block}@media (min-width:992px){.login.login-1 .login-aside{width:100%;max-width: 920px;}.login.login-1 .login-content{width:100%;max-width: 480px;}.login.login-1 .login-content .login-form{width:100%;max-width:450px}}@media (min-width:992px) and (max-width:1399.98px){.login.login-1 .login-aside{width:100%;max-width:820px}}@media (max-width:991.98px){.login.login-1 .login-content .login-form{width:100%;max-width:400px}}@media (max-width:575.98px){.login.login-1 .aside-img{min-height:300px!important;background-size:400px}.login.login-1 .login-content .login-form{width:100%;max-width:100%}}
        `
    }
</script>
