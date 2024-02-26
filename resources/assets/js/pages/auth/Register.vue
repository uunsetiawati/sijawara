<template>
    <!--begin::Login-->
    <div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
        <!--begin::Content-->
        <div class="login-container d-flex flex-center flex-row flex-row-fluid order-2 order-lg-1 flex-row-fluid bg-white py-lg-0 pb-lg-0 pt-15 pb-12">
            <!--begin::Container-->
            <div class="login-content login-content-signup d-flex flex-column">
                <!--begin::Aside Top-->
                <div class="d-flex flex-column-auto flex-column px-10 pt-10">
                    <!--begin::Aside header-->
                    <router-link :to="{name: 'login'}" class="login-logo pb-lg-4 pb-10">
                        <img v-if="$parent.setting.logodarkdir" :src="$parent.setting.logodarkdir" class="max-w-200px max-w-md-300px max-w-sm-200px" alt="Logo" />
                        <!-- <img src="assets/media/logos/logo-4.png" class="max-h-70px" alt="" /> -->
                    </router-link>
                    <!--end::Aside header-->
                    <!--begin: Wizard Nav-->
                    <oauth-button v-if="!oauthStatus"></oauth-button>
                    <div v-if="!oauthStatus" class="border-bottom my-10"></div>
                    <div class="wizard-nav pb-2">
                        <!--begin::Wizard Steps-->
                        <div class="wizard-steps d-flex flex-column flex-sm-row">
                            <!--begin::Wizard Step 1 Nav-->
                            <!-- <div class="wizard-step flex-grow-1 flex-basis-0" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper pr-7">
                                    <div class="wizard-icon">
                                        <i class="wizard-check ki ki-check"></i>
                                        <span class="wizard-number">1</span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Daftar</h3>
                                        <div class="wizard-desc">Daftar No. HP</div>
                                    </div>
                                    <span class="svg-icon pl-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div> -->
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper pr-7">
                                    <div class="wizard-icon">
                                        <i class="wizard-check ki ki-check"></i>
                                        <span class="wizard-number">1</span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Isi Data</h3>
                                        <div class="wizard-desc">Verifikasi Data</div>
                                    </div>
                                    <span class="svg-icon pl-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!--end::Wizard Step 2 Nav-->
                            <!--begin::Wizard Step 3 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <i class="wizard-check ki ki-check"></i>
                                        <span class="wizard-number">2</span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Selesai</h3>
                                        <div class="wizard-desc">Kirim Data</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 3 Nav-->
                        </div>
                        <!--end::Wizard Steps-->
                    </div>
                    <!--end: Wizard Nav-->
                    <div class="" style="text-align: right;">Sudah memiliki akun?
                                <router-link :to="{name: 'login'}" class="text-primary font-weight-bolder">Masuk</router-link></div>
                </div>
                <!--end::Aside Top-->
                <!--begin::Signin-->
                <div class="login-form">
                    <!--begin::Form-->
                    <form class="form px-10" id="kt_login_signup_form" method="POST" @submit.prevent="sendInfo" onkeydown="return event.key != 'Enter';">
                        <!--begin: Wizard Step 1-->
                        <!-- <div class="" data-wizard-type="step-content" data-wizard-state="current">
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Nama</label>
                                <input type="text" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="name" placeholder="Nama" v-model="user.name" required/>
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">No. Whatsapp</label>
                                <input type="text" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="phone" placeholder="No. Whatsapp" v-model="user.phone" oninput="$(this).val($(this).val().replace(/[^0-9]/g, ''));" />
                                <a @click="sendVerification" class="text-primary font-weight-bolder float-right" style="cursor: pointer;">Kirim Kode Verifikasi</a>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
                                        <div v-if="sendOtpSuccess" class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Kode Verifikasi</label>
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
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div> -->
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <!--begin::Title-->
                            <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
                                <div class="row"> <!-- v-if="sendOtpSuccess" -->
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Nama</label>
                                            <input type="text" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Nama" v-model="user.name" required name="name">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Email</label>
                                            <input type="email" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Email" v-model="user.email" required name="email" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Nomor Whatsapp</label>
                                            <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Nomor Whatsapp" v-model="user.phone" required name="phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Jenis</label>
                                            <select name="jenis" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" v-model="user.jenis" required>
                                                <option value="">Pilih Jenis</option>
                                                <option value="UKM">UKM</option>
                                                <option value="KOPERASI">KOPERASI</option>
                                                <option value="INSTANSI">INSTANSI</option>
                                                <option value="UMUM">UMUM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Password</label>
                                            <input type="password" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Password" v-model="user.password" required name="password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="font-size-h6 font-weight-bolder text-dark-65">Konfirmasi Password</label>
                                            <input type="password" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Konfirmasi Password" v-model="user.password_confirmation" required name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </transition>
                            <div class="row">
                                <button type="button" class="btn btn-next btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-next">Next
                                <span class="svg-icon svg-icon-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                </span></button>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end: Wizard Step 2-->
                        <!--begin: Wizard Step 3-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Complete</h3>
                                <div class="text-muted font-weight-bold font-size-h4">Complete Your Signup And Become A Member!</div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <h4 class="font-weight-bolder mb-3">Account Settings:</h4>
                            <div class="text-dark-50 font-weight-bold line-height-lg mb-8">
                                <div>{{ user.name }}</div>
                                <div>{{ user.email }}</div>
                                <div>{{ user.jenis }}</div>
                            </div>
                            <!--end::Section-->
                            <div class="d-flex justify-content-between pt-7">
                                <div class="mr-2">
                                    <button type="button" class="btn btn-light-primary font-weight-bolder font-size-h6 pr-8 pl-6 py-4 my-3 mr-3" data-wizard-type="action-prev">
                                    <span class="svg-icon svg-icon-md mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
                                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span>Previous</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-submit" type="submit" id="kt_login_signup_form_submit_button">Submit
                                    <span class="svg-icon svg-icon-md ml-2">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span></button>
                                    <!-- <button type="button" class="btn btn-next btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-next">Next
                                    <span class="svg-icon svg-icon-md ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span></button> -->
                                </div>
                        </div>
                        </div>
                        <!--end: Wizard Step 5-->
                        <!--begin: Wizard Actions-->
                        <!--end: Wizard Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Container-->
        </div>
        <!--begin::Content-->
        <!--begin::Aside-->
        <div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right" :style="(($parent.setting.backgrounddir ) ? 'background-image: url('+$parent.setting.backgrounddir+');' : '')"></div>
        <!--end::Aside-->
    </div>
    <!--end::Login-->
</template>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND
    import OtpInput from "@bachdgvn/vue-otp-input";

    export default {
        components: {
            'v-otp-input': OtpInput
        },
        data() {
            return {
                user: {name: "", jenis: ""},
                sendOtpSuccess: false,
                otpSuccess: false,
                KTW: null,
                provinces: [],
                citys: [],
                oauthStatus: false
            }
        },
        methods: {
            handleOnChange(v) {
                $('.formOtp').toggleClass('otp-invalid', false);
                this.user.otp = v;
            },
            handleOnComplete(v) {
                this.user.otp = v;
                this.submitOtp();
            },
            loadJS() {
                var vm = this;
                var KTLogin = {
                    init: function() {
                        var t, i = KTUtil.getById("kt_login"),
                            o = KTUtil.getById("kt_login_signup_form"),
                            e = [];
                        var fv;
                        o && (e.push(FormValidation.formValidation(o, {
                            fields: {
                                name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Name is required"
                                        }
                                    }
                                },
                                phone: {
                                    validators: {
                                        numeric: {
                                            message: "The value must be numeric"
                                        },
                                    }
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap
                            }
                        })), 
                        e.push(FormValidation.formValidation(o, {
                            fields: {
                                name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Nama is required"
                                        }
                                    }
                                },
                                email: {
                                    validators: {
                                        notEmpty: {
                                            message: "Email is required"
                                        },
                                        emailAddress: {
                                            message: "The value is not a valid email address"
                                        },
                                        remote: {
                                            data: {
                                                type: 'email',
                                            },
                                            message: 'Email telah digunakan',
                                            method: 'POST',
                                            url: '/api/v1/auth/checkEmail',
                                            validKey: 'status',
                                        }
                                    }
                                },
                                jenis: {
                                    validators: {
                                        notEmpty: {
                                            message: "Jenis Instansi is required"
                                        }
                                    }
                                },
                                password: {
                                    validators: {
                                        notEmpty: {
                                            message: 'The password is required'
                                        }
                                    }
                                },
                                password_confirmation: {
                                    validators: {
                                        identical: {
                                            compare: function() {
                                                return o.querySelector('[name="password"]').value;
                                            },
                                            message: 'The password confirmation are not the same'
                                        }
                                    }
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap
                            }
                        })), 
                        e.push(FormValidation.formValidation(o, {
                            fields: {
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap
                            }
                        })), 
                        (vm.KTW = t = new KTWizard(i, {
                            startStep: 1,
                            clickableSteps: !1
                        })).on("beforeNext", function(i) {
                            e[i.getStep() - 1].validate().then(function(i) {
                                if ("Valid" == i) {
                                    t.goNext()
                                    KTUtil.scrollTop()
                                }else{
                                    KTUtil.scrollTop()
                                }
                            }), t.stop()
                        }), 
                        t.on("change", function(t) {
                            KTUtil.scrollTop()
                        }))
                        o.querySelector('[name="password"]').addEventListener('input', function() {
                            e[1].revalidateField('password_confirmation');
                        });
                        if (vm.$route.query.name && vm.$route.query.email && vm.$route.query.type == 'oauth' && vm.$route.query.otp) {
                            vm.user.name = vm.$route.query.name;
                            vm.user.email = vm.$route.query.email;
                            vm.registerType = vm.$route.query.type;
                            vm.user.otp = vm.$route.query.otp;
                            vm.submitOtp();
                        }
                    }
                }; 
                jQuery(document).ready(function() {
                    KTLogin.init()
                });         
            },
            checkNik() {
                var vm = this;
                vm.$http({
                    url: '/secure/register/checkNik',
                    method: 'POST',
                    data: {nik: vm.user.nik}
                }).then((res) => {
                    
                }).catch((error) => {
                    
                });
            },
            checkEmail() {
                var vm = this;
                vm.$http({
                    url: '/secure/register/checkEmail',
                    method: 'POST',
                    data: {email: vm.user.email}
                }).then((res) => {
                    
                }).catch((error) => {
                    
                });
            },
            sendVerification() {
                var vm = this;
                if(vm.user.phone.length <= 9) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Masukkan Nomor dengan benar.',
                    })
                    return;
                }

                if(vm.user.name.length <= 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Masukkan Nama dengan benar.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Kami akan mengirimkan Kode verifikasi ke Nomor Whatsapp '+vm.user.phone,
                    showCancelButton: true,
                    icon: 'question',
                    iconHtml: '?',
                    confirmButtonText: 'Ya',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return vm.$http({
                            url: '/secure/register/getOtp',
                            method: 'POST',
                            data: vm.user
                        }).then((res) => {
                            vm.sendOtpSuccess = true;                            
                            return res.data
                        }).catch((error) => {
                            vm.sendOtpSuccess = false;
                            Swal.showValidationMessage(error.response.data.message)
                        });
                    },
                    allowOutsideClick: () => false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil mengirim Kode Aktivasi.',
                        })
                    }
                })
            },
            submitOtp() {
                var vm = this;
                KTApp.block($('#kt_login_signup_form'));
                $('.formOtp').toggleClass('otp-invalid', false);
                $('.formOtp').toggleClass('otp-valid', false);
                const url = vm.registerType == 'oauth' ? '/secure/register/checkOtpOauth' : '/secure/register/checkOtp';
                vm.$http({
                    url,
                    method: 'POST',
                    data: vm.user
                }).then((res) => {
                    KTApp.unblock($('#kt_login_signup_form'));
                    // vm.KTW.goNext()
                    KTUtil.scrollTop()
                    vm.otpSuccess = res.data.data.access_token;
                    // $('.formOtp').toggleClass('otp-valid', true);
                    // $('.formOtp').toggleClass('otp-invalid', false);
                    // $('.tgl_lahir').datepicker({
                    //     format: "yyyy-mm-dd",
                    //     language: "id"
                    // })
                    // .val(vm.user.birth_date)
                    // .on('change', function(v) {
                    //     vm.user.birth_date = $('.tgl_lahir').val();
                    // });
                    // vm.getProvince();
                    vm.oauthStatus = true;
                }).catch((error) => {
                    KTApp.unblock($('#kt_login_signup_form'));
                    $('.formOtp').toggleClass('otp-valid', false);
                    $('.formOtp').toggleClass('otp-invalid', true);
                    vm.$router.push({name: 'login'});
                });
            },
            sendInfo() {
                var vm = this;
                KTApp.block($('#kt_login_signup_form'));
                const url = vm.registerType == 'oauth' ? '/secure/register/updateInfo' : '/secure/register';
                vm.$http({
                    url,
                    method: 'POST',
                    data: vm.user,
                    headers: {
                        'Authorization': 'Bearer '+vm.otpSuccess
                    }
                }).then((res) => {
                    KTApp.unblock($('#kt_login_signup_form'));
                    toastr.success('Berhasil mendaftar akun.<br/>Silakan login ulang.')
                    vm.$router.push((localStorage.getItem('redirect_login')) ? JSON.parse(atob(localStorage.getItem('redirect_login'))) : {name: 'home'});
                }).catch((error) => {
                    KTApp.unblock($('#kt_login_signup_form'));
                    toastr.error(error.response.data.message);
                });
            },
            getProvince() {
                var vm = this;
                vm.$http({
                    url: '/province/show',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer '+vm.otpSuccess
                    }
                }).then((res) => {
                    vm.provinces = res.data.data;
                    $('.province').select2({
                        placeholder: 'Pilih Provinsi'
                    })
                    .val(vm.user.province_id)
                    .on('change', function(v) {
                        vm.user.province_id = $('.province').val()
                        vm.citys = [];
                        vm.getCity(vm.user.province_id)
                    });
                }).catch((error) => {
                    toastr.error(error.response.data.message);
                });
            },
            getCity(id) {
                var vm = this;
                KTApp.block($('.select2-container'));
                vm.$http({
                    url: '/city/show?province_id='+id,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer '+vm.otpSuccess
                    }
                }).then((res) => {
                    KTApp.unblock($('.select2-container'));
                    vm.citys = res.data.data;
                    setTimeout(function() {
                        $('.city').select2({
                            placeholder: 'Pilih Kabupaten/Kota'
                        })
                        .val(vm.user.city_id)
                        .on('change', function(v) {
                            vm.user.city_id = $('.city').val()
                        });
                    },100);
                }).catch((error) => {
                    KTApp.unblock($('.select2-container'));
                    toastr.error(error.response.data.message);
                });
            },
        },
        mounted() {
            var vm = this;
            setTimeout(function() {
                vm.loadJS();
            });
        },
        style: `
        .formOtp {width: 37px!important;}
        .otp-invalid {border-color: #f64e60!important;}
        .otp-valid {border-color: #9ee1ae!important;}
        .login.login-4 .login-container .login-content{width:450px}.login.login-4 .login-container .login-content .wizard-nav{padding:0}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step{padding:.75rem 0;-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease;margin-bottom:1.5rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-wrapper{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-icon{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease;width:46px;height:46px;border-radius:12px;background-color:#f3f6f9;margin-right:1rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-icon .wizard-check{display:none;font-size:1.4rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-icon .wizard-number{font-weight:600;color:#3f4254;font-size:1.35rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-label{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title{color:#181c32;font-weight:600;font-size:1.24rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-desc{color:#b5b5c3;font-size:.925rem}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=done] .wizard-icon{-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease;background-color:#c9f7f5}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=done] .wizard-icon .wizard-check{color:#1bc5bd;display:inline-block}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=done] .wizard-icon .wizard-number{display:none}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=done] .wizard-label .wizard-title{color:#b5b5c3}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=done] .wizard-label .wizard-desc{color:#d1d3e0}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current]{-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon{-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease;background-color:#c9f7f5}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon .wizard-check{color:#1bc5bd;display:none}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon .wizard-number{color:#1bc5bd}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-label .wizard-title{color:#181c32}.login.login-4 .login-container .login-content .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-label .wizard-desc{color:#b5b5c3}.login.login-4 .login-container .login-content.login-content-signup{width:700px}.login.login-4 .login-aside{background:linear-gradient(147.04deg,#ca7b70 .74%,#5a2119 99.61%);width:700px}.login.login-4 .login-aside .login-conteiner{height:100%}@media (min-width:992px){.login.login-4 .login-aside .login-conteiner{min-height:610px!important;background-size:580px}}@media (min-width:992px) and (max-width:1399.98px){.login.login-4 .login-aside .login-conteiner{min-height:420px!important;background-size:400px}}@media (max-width:991.98px){.login.login-4 .login-container .wizard-nav{padding:0;-ms-flex-line-pack:center;align-content:center}.login.login-4 .login-container .wizard-nav .wizard-steps .wizard-step{margin-bottom:.5rem}.login.login-4 .login-aside{width:100%!important}.login.login-4 .login-aside .login-conteiner{min-height:210px!important;background-size:200px}}@media (max-width:575.98px){.login.login-4 .login-container{width:100%}.login.login-4 .login-container .wizard-nav .wizard-steps{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.login.login-4 .login-container .wizard-nav .wizard-steps .wizard-step{width:100%}.login.login-4 .login-container .wizard-nav .wizard-steps .wizard-step .wizard-wrapper .svg-icon{display:none}.login.login-4 .login-container .login-content{width:100%}.login.login-4 .login-container .login-content.login-content-signup{width:100%}.login.login-4 .login-aside{width:100%!important}}@media (max-width:1800px){.login.login-4 .login-aside{width:600px}}`
    }
</script>
