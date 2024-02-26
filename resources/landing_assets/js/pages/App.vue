<template>
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header header-fixed bg-success">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Header Menu Wrapper-->
                    <div class="header-menu-wrapper header-menu-wrapper-left">
                        <!--begin::Header Menu-->
                        <div class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Header Nav-->
                            <a :href="`${base_url}/landing`" class="header-brand">
                                <img v-if="setting.logowhitedir" :src="setting.logowhitedir" class="h-45px mt-3" alt="Logo">
                            </a>
                            <!--end::Header Nav-->
                        </div>

                        <!--end::Header Menu-->
                    </div>
                    <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                        <!--begin::Header Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Header Nav-->
                            <ul class="menu-nav">
                                <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'home'}">
                                    <router-link :to="{name: 'home'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.home') }}</span>
                                    </router-link>
                                </li>
                                <!-- <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'blog'}">
                                    <router-link :to="{name: 'blog'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.news') }}</span>
                                    </router-link>
                                </li> -->
                                <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'jadwal'}">
                                    <router-link :to="{name: 'jadwal'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('home.webinar') }}</span>
                                    </router-link>
                                </li>
                                <!-- <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'contact'}">
                                    <router-link :to="{name: 'contact'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.contact') }}</span>
                                    </router-link>
                                </li>
                                <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'about'}">
                                    <router-link :to="{name: 'about'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.profile') }}</span>
                                    </router-link>
                                </li>
                                <li class="menu-item" :class="{'menu-item-here menu-item-active': $route.name == 'team'}">
                                    <router-link :to="{name: 'team'}" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.team') }}</span>
                                    </router-link>
                                </li>
                                <li class="menu-item">
                                    <a :href="`${base_url}/panduan/sijawara.pdf`" target="_blank" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.guide') }}</span>
                                    </a>
                                </li> -->
                                <li class="menu-item">
                                    <a :href="((localStorage.getItem('authToken')) ? `${base_url}` : `${base_url}/login` )" class="menu-link">
                                        <span class="menu-text text-white">{{ $t('menu.login') }}</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <div class="dropdown">
                                        <!--begin::Toggle-->
                                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                                            <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                                                <img class="h-20px w-20px rounded-sm" :src="localeFlags[$i18n.locale].icon" alt="">
                                            </div>
                                        </div>
                                        <!--end::Toggle-->
                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right" style="">
                                            <!--begin::Nav-->
                                            <ul class="navi navi-hover py-4">
                                                <!--begin::Item-->
                                                <li v-for="localeFlag in localeFlags" :key="localeFlag.id" class="navi-item active">
                                                    <a href="javascript:void(0);" @click="locale=localeFlag.locale" class="navi-link">
                                                        <span class="symbol symbol-20 mr-3">
                                                            <img :src="localeFlag.icon" alt="">
                                                        </span>
                                                        <span class="navi-text">{{ localeFlag.name }}</span>
                                                    </a>
                                                </li>
                                                <!--end::Item-->
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                </li>
                            </ul>
                            <!--end::Header Nav-->
                        </div>
                    </div>
                    <!--end::Header Menu Wrapper-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid mt-md-35 mt-18" id="kt_content">
                <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                    <div class="container-fluid d-flex align-items-center flex-nowrap">
                        <!-- <div class="d-flex align-items-center flex-wrap mr-2"> -->
                            <!--begin::Page Title-->
                            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $t('announcement') }}</h5>
                            <!--end::Page Title-->
                            <!--begin::Actions-->
                            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                            <span style="width: 100%;"><marquee scrolldelay="100" behavior="2" onmouseover="this.stop();" onmouseout="this.start();" direction="left" v-html="announcements.map(function(elem){return elem.content;}).join('&nbsp;&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;&nbsp;')"></marquee></span>
                            <!--end::Actions-->
                        <!-- </div> -->
                    </div>
                </div>
                <router-view></router-view>
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer footer-sijawara py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">{{ new Date().getFullYear() }} &copy;</span>
                        <a :href="`${base_url}/login`" class="text-dark-75 text-hover-primary">{{ setting.name }}</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark">
                        <!-- <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-5">About</a>
                        <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-5">Team</a>
                        <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-0">Contact</a> -->
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
</template>

<style>
    .text-sijawara {
        color: #a0b920!important;
    }
    .footer-sijawara {
        background-color: #a0b920!important;
    }

    .bg-success {
        background-color: #a0b920!important;
    }

    .btn-success {
        background-color: #a0b920!important;
        border-color: #8ca217!important;
    }

    .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled) {
        background-color: rgba(77,89,149,.06)!important;
    }

    .show .btn.btn-clean.btn-dropdown {
        background-color: rgba(77,89,149,.06)!important;
    }

    .svg-icon.svg-icon-success svg g [fill] {
        -webkit-transition:fill .3s ease;
        transition:fill .3s ease;
        fill:#a0b920!important;
    }

    .bg-diagonal-success:before {
        background-color:#a0b920!important
    }

    .wave.wave-success .svg-icon svg g [fill] {
        fill:#a0b920!important;
    }
    .wave.wave-success {
        background-color: rgba(160,185,33,.1)!important;

    }
</style>

<script>
    import postscribe from 'postscribe';
    
    export default {
        data() {
            return {
                localStorage: window.localStorage,
                setting: {backgrounddir: null, logodarkdir: null, logowhitedir: null},
                announcements: [],
                getColorName: 'success',
                locale: localStorage.getItem('locale') ? localStorage.getItem('locale') : 'id',
                localeFlags: {
                    'id': {
                        locale: 'id',
                        name: 'Indonesian',
                        icon: '/assets/media/svg/flags/004-indonesia.svg',   
                    },
                    'en': {
                        locale: 'en',
                        name: 'English',
                        icon: '/assets/media/svg/flags/226-united-states.svg'
                    }
                }
            }
        },
        watch: {
            locale (val) {
                this.$i18n.locale = val;
                localStorage.setItem('locale', val);
                // this.$forceUpdate();
                this.$router.go(0);
            }
        },
        methods: {
            getConfig() {
                var vm = this;
                vm.$http({
                    url: '/setting',
                    method: 'GET',
                }).then((res) => {
                    vm.setting = res.data.data;
                    document.querySelector("meta[name='title']").setAttribute("content", vm.setting.name);
                }).catch((error) => {
                    
                });
            },
            getAnnouncement() {
                var vm = this;
                vm.$http({
                    url: '../front/announcement/show',
                    method: 'GET',
                }).then((res) => {
                    vm.announcements = res.data.data;
                }).catch((error) => {
                    
                });
            },
            randomColorName() {
                var app = this;
                var items = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark'];
                setInterval(function() {
                    app.getColorName = items[Math.floor(Math.random()*items.length)];
                }, 200)
            },
        },
        mounted() {
            this.getConfig();
            this.getAnnouncement();
            this.randomColorName();
            setTimeout(function() {
                postscribe('#core', `<script src="${process.env.MIX_APP_URL}/assets/js/scripts.bundle.js"><\/script>`);
            }, 500);
        }
    }
</script>