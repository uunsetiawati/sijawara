<template>
    <main :class="{'d-flex flex-column flex-root': $route.name == 'login' || $route.name == 'notfound' || $route.name == 'notfound404' || $route.name == 'register' || $route.name == 'forgot'}">
        <router-view v-if="$auth.ready() && !$auth.check() || $route.name == 'callback.oauth' || $route.name == 'notfound'"></router-view>
        <!--begin::Header Mobile-->
        <div v-if="$auth.ready() && $auth.check() && $route.name != 'callback.oauth' && $route.name != 'notfound'" id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
            <!--begin::Logo-->
            <router-link :to="{name: 'home'}" class="brand-logo">
                <img v-if="setting.logodarkdir" :src="setting.logodarkdir" alt="Logo" style="width: 180px" />
            </router-link>
            <!--end::Logo-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Aside Mobile Toggle-->
                <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Aside Mobile Toggle-->
                <!--begin::Header Menu Mobile Toggle-->
                <!-- <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                    <span></span>
                </button> -->
                <!--end::Header Menu Mobile Toggle-->
                <!--begin::Topbar Mobile Toggle-->
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
                <!--end::Topbar Mobile Toggle-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
        <div v-if="$auth.ready() && $auth.check() && $route.name != 'callback.oauth' && $route.name != 'notfound'" class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                <!--begin::Aside-->
                <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                    <!--begin::Brand-->
                    <div class="brand flex-column-auto" id="kt_brand">
                        <!--begin::Logo-->
                        <router-link :to="{name: 'home'}" class="brand-logo">
                            <img v-if="setting.logodarkdir" :src="setting.logodarkdir" alt="Logo" style="width: 180px" />
                        </router-link>
                        <!--end::Logo-->
                        <!--begin::Toggle-->
                        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                            <span class="svg-icon svg-icon svg-icon-xl">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </button>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Brand-->
                    <!--begin::Aside Menu-->
                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                        <!--begin::Menu Container-->
                        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                            <!--begin::Menu Nav-->
                            <ul class="menu-nav">
                                <template v-for="route in routes[$auth.user().level]">
                                <li v-if="!route.child && route.divider" class="menu-section">
                                    <h4 class="menu-text">{{ route.name }}</h4>
                                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                                <li v-if="!route.child && !route.divider" class="menu-item" :class="{'menu-item-active': (route.path == 'home') ? isActive($auth.user().level) : ((route.path_child) ? isActive(route.path, route.path_child) : isActive(route.path))}" aria-haspopup="true">
                                    <router-link :to="{name: route.path}" class="menu-link" active-class="menu-item-active">
                                        <i class="menu-icon" :class="route.icon"></i></span>
                                        <span class="menu-text">{{ route.name }}</span>
                                    </router-link>
                                </li>
                                <li v-if="route.child && !route.divider" class="menu-item menu-item-submenu" :class="{'menu-item-active': (route.path == 'home') ? isActive($auth.user().level) : isActive(route.path)}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <i class="menu-icon" :class="route.icon"></i>
                                        </span>
                                        <span class="menu-text">{{ route.name }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                <span class="menu-link">
                                                    <span class="menu-text">{{ route.name }}</span>
                                                </span>
                                            </li>
                                            <template v-for="child1 in route.child">
                                            <li v-if="!child1.child" class="menu-item" aria-haspopup="true" :class="{'menu-item-active': (child1.path == 'home') ? isActive($auth.user().level) : ((child1.path_child) ? isActive(child1.path, child1.path_child) : isActive(child1.path))}">
                                                <router-link :to="{name: child1.path}" class="menu-link" active-class="menu-item-active">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">{{ child1.name }}</span>
                                                    <span v-if="child1.isNew" class="menu-label">
                                                        <span class="label label-danger label-inline">new</span>
                                                    </span>
                                                </router-link>
                                            </li>
                                            <li v-if="child1.child" class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <i class="menu-bullet menu-bullet-line">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">{{ child1.name }}</span>
                                                    <i class="menu-arrow"></i>
                                                </a>
                                                <div class="menu-submenu">
                                                    <i class="menu-arrow"></i>
                                                    <ul class="menu-subnav">
                                                        <template v-for="child2 in child1.child">
                                                        <li v-if="child2.child" class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">{{ child2.name }}</span>
                                                                <i class="menu-arrow"></i>
                                                            </a>
                                                            <div class="menu-submenu">
                                                                <i class="menu-arrow"></i>
                                                                <ul class="menu-subnav">
                                                                    <li class="menu-item" aria-haspopup="true">
                                                                        <router-link :to="{name: child2.path}" class="menu-link" active-class="menu-item-active">
                                                                            <i class="menu-bullet menu-bullet-line">
                                                                                <span></span>
                                                                            </i>
                                                                            <span class="menu-text">{{ child2.name }}</span>
                                                                            <span v-if="child2.isNew" class="menu-label">
                                                                                <span class="label label-danger label-inline">new</span>
                                                                            </span>
                                                                        </router-link>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li v-if="!child2.child" class="menu-item" aria-haspopup="true">
                                                            <router-link :to="{name: child2.path}" class="menu-link">
                                                                <i class="menu-bullet menu-bullet-dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="menu-text">{{ child2.name }}</span>
                                                            </router-link>
                                                        </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </li>
                                            </template>
                                        </ul>
                                    </div>
                                </li>
                                </template>
                                <li v-if="$auth.ready() && $auth.check() && $auth.user().level == 'user' && ($auth.user().jenis && $auth.user().jenis.toLowerCase() == 'ukm')" class="menu-item" :class="{'menu-item-active': isActive('user.ukm')}" aria-haspopup="true">
                                    <router-link :to="{name: 'user.ukm'}" class="menu-link" active-class="menu-item-active">
                                        <i class="menu-icon fas fa-shield-alt"></i></span>
                                        <span class="menu-text">Data UKM</span>
                                    </router-link>
                                </li>
                                <li v-if="$auth.ready() && $auth.check() && $auth.user().level == 'user' && ($auth.user().jenis && $auth.user().jenis.toLowerCase() == 'koperasi')" class="menu-item" :class="{'menu-item-active': isActive('user.koperasi')}" aria-haspopup="true">
                                    <router-link :to="{name: 'user.koperasi'}" class="menu-link" active-class="menu-item-active">
                                        <i class="menu-icon fas fa-shield-alt"></i></span>
                                        <span class="menu-text">{{ $t('menu.cooperative_data') }}</span>
                                    </router-link>
                                </li>
                            </ul>
                            <!--end::Menu Nav-->
                        </div>
                        <!--end::Menu Container-->
                    </div>
                    <!--end::Aside Menu-->
                </div>
                <!--end::Aside-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header header-fixed">
                        <!--begin::Container-->
                        <div class="container-fluid d-flex align-items-stretch justify-content-between">
                            <!--begin::Header Menu Wrapper-->
                            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                <!--begin::Header Menu-->
                                <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                    <ul class="menu-nav ">
                                        <li class="menu-item menu-item-submenu menu-item-rel menu-item-active"><a href="javascript:;" class="menu-link"><span class="menu-text font-success">{{ getHariIni() }}</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <!--end::Header Menu-->
                            </div>
                            <!--end::Header Menu Wrapper-->
                            <!--begin::Topbar-->
                            <div class="topbar" style="z-index: 2">
                                <div class="dropdown" v-if="$auth.user().level == 'user'">
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" @click="() => (getUnReadNotif(), getHasReadNotif())">
										<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 position-relative">
											<i class="fa fa-bell"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge badge-danger"
                                                style="border-radius: 50%; font-size: 0.8rem; padding: 0.375em 0.625em; right: 0;">
                                                {{ countUnReadNotif }}
                                            </span>
										</div>
									</div>
									<div class="notif dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<form>
											<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top bg-primary" style="background-image: url(/images/background/bg-notif.jpg)">
												<h4 class="d-flex flex-center rounded-top mb-0">
													<span class="text-white">Notifikasi</span>
													<span class="btn btn-text bg-success text-white btn-sm font-weight-bold btn-font-md ml-2" style="cursor: default">
                                                        {{ unReadNotifs.length === undefined ? 1 : unReadNotifs.length }}
                                                    </span>
												</h4>
												<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-5" role="tablist">
													<li class="nav-item">
														<a class="nav-link mx-0 px-3 active show" data-toggle="tab" href="#unread-notifications">Baru</a>
													</li>
													<li class="nav-item">
														<a class="nav-link mx-0 px-3" data-toggle="tab" href="#hasread-notifications">Sudah dibaca</a>
													</li>
												</ul>
											</div>
											<div class="tab-content">
												<div class="tab-pane active show py-8 px-6" id="unread-notifications" role="tabpanel">
													<div class="scroll pr-8" data-scroll="true" data-height="300" data-mobile-height="200">
														<div v-for="notif in unReadNotifs" class="d-flex align-items-center mb-6">
															<div class="symbol symbol-25 symbol-light-primary mr-5">
																<div class="symbol-label">
                                                                    <i class="fas fa-dot-circle text-primary" style="font-size: 12px;"></i>
                                                                </div>
															</div>
															<div class="d-flex flex-column w-100 pr-8" style="cursor: pointer" @click="openNotif(notif)">
																<span class="text-dark font-weight-bold text-hover-primary mb-1 font-size-lg">
                                                                    {{ notif.judul }}
                                                                </span>
																<span class="text-muted" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                                    {{ isiText(notif.isi, true) }}
                                                                </span>
															</div>
														</div>
													</div>
												</div>
												<div class="tab-pane py-8 px-6" id="hasread-notifications" role="tabpanel">
													<div class="scroll pr-8" data-scroll="true" data-height="300" data-mobile-height="200">
														<div v-for="notif in hasReadNotifs" class="d-flex align-items-center mb-6" style="opacity: 0.8">
															<div class="symbol symbol-25 symbol-light-primary mr-5">
																<div class="symbol-label">
                                                                    <i class="fas fa-dot-circle" style="font-size: 12px;"></i>
                                                                </div>
															</div>
															<div class="d-flex flex-column w-100 pr-5" style="cursor: pointer" @click="openNotif(notif)">
																<span class="text-dark mb-1 font-size-lg font-weight-bold">
                                                                    {{ notif.judul }}
                                                                </span>
																<span class="text-muted" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                                    {{ isiText(notif.isi, true) }}
                                                                </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
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
                                            <li v-for="localeFlag in localeFlags" class="navi-item active">
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
                                <!--begin::User-->
                                <div class="topbar-item">
                                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ $auth.user().name }}</span>
                                        <span :class="'symbol symbol-35 symbol-light-'+getColorName">
                                            <span class="symbol-label font-size-h5 font-weight-bold">{{ $auth.user().name[0] }}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->
                        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" v-if="$route.meta.breadcrumb">
                            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap mr-1">
                                    <!--begin::Page Heading-->
                                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                                        <!--begin::Page Title-->
                                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{ $route.meta.title }}</h5>
                                        <!--end::Page Title-->
                                        <!--begin::Breadcrumb-->
                                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                            <template v-for="bc in $route.meta.breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="javascript:;" class="text-muted">{{ bc }}</a>
                                            </li>
                                            </template>
                                        </ul>
                                        <!--end::Breadcrumb-->
                                    </div>
                                    <!--end::Page Heading-->
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <!--end::Subheader-->
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <router-view v-if="$auth.ready() && $auth.check() || $route.name != 'notfound'"></router-view>
                            <!-- <div class="container">
                                <p>Page content goes here...</p>
                            </div> -->
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Footer-->
                    <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer" style="z-index: 90;">
                        <!--begin::Container-->
                        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">{{ new Date().getFullYear() }} &copy;</span><router-link :to="{name: 'home'}" class="text-dark-75 text-hover-primary">{{ setting.name }}</router-link>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Nav-->
                            <div class="nav nav-dark">
                                <!-- <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-5">About</a> -->
                                <!-- <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-5">Team</a> -->
                                <!-- <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-0">Contact</a> -->
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->
        <!-- begin::User Panel-->
        <div v-if="$auth.ready() && $auth.check() && $route.name != 'callback.oauth' && $route.name != 'notfound'" id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">User Profile</h3>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="offcanvas-content pr-5 mr-n5">
                <!--begin::Header-->
                <div class="d-flex align-items-center mt-5">
                    <div class="symbol symbol-100 mr-5">
                        <span class="symbol-label">
                            <!-- <img src="/metronic/theme/html/demo1/dist/assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt=""> -->
                            <span class="svg-icon svg-icon-7x">
                                <svg v-if="$auth.user().gender == '0'" enable-background="new 0 0 464.002 464.002" version="1.1" viewBox="0 0 464 464" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m120 185c0 43-23 157-56 183l135.48 33.548c20.016-172.04-79.484-216.54-79.484-216.54z" fill="#E8A055"/>
                                    <path d="m344 185c0 43 23 157 56 183l-135.48 33.548c-20.016-172.04 79.484-216.54 79.484-216.54z" fill="#F6B45E"/>
                                    <path d="m380.38 436.83-2.984-22.383-6.542-49.067c-1.779-13.344-10.151-24.898-22.277-30.744l-30.861-14.879c-3.003-1.448-6.501-0.135-7.99 2.804l-18.782-6.911c-6.533-2.178-10.94-8.292-10.94-15.179v-25.802l34.461-14.359c17.886-7.454 29.537-24.931 29.537-44.309v-72c0-22.091-17.909-72-40-72h-144c-22.092 0-40 49.909-40 72v72c0 19.378 11.651 36.855 29.538 44.308l34.462 14.359v25.801c0 6.887-4.407 13.001-10.94 15.179l-18.782 6.911c-1.489-2.938-4.987-4.251-7.99-2.804l-30.861 14.879c-12.126 5.847-20.498 17.4-22.277 30.744l-6.542 49.067-2.984 22.383c-1.919 14.389 9.274 27.173 23.789 27.173h249.18c14.515 0 25.708-12.784 23.79-27.171z" fill="#FFD7A3"/>
                                    <path d="m320 326.34-19.834-7.298c-9.615 28.45-36.469 48.959-68.166 48.959s-58.55-20.509-68.167-48.959l-19.833 7.298v9.661c0 48.601 39.399 88 88 88s88-39.399 88-88v-9.661z" fill="#72967D"/>
                                    <path d="m380.38 436.83-9.526-71.451c-1.779-13.344-10.151-24.897-22.277-30.744l-30.861-14.879c-3.107-1.498-6.75-0.046-8.143 3.109-20.236 45.826-54.904 67.136-77.571 77.139-22.667-10.002-57.335-31.313-77.569-77.14-1.393-3.155-5.036-4.606-8.143-3.109l-30.861 14.879c-12.126 5.847-20.498 17.4-22.277 30.744l-9.526 71.451c-1.918 14.387 9.274 27.172 23.79 27.172h249.18c14.514 1e-3 25.707-12.784 23.789-27.171z" fill="#8ABE69"/>
                                    <path d="m237.11 410.86c38.651-18.172 68.226-48.756 86.091-88.465l-5.484-2.644c-3.107-1.498-6.75-0.046-8.143 3.109-20.235 45.826-54.903 67.136-77.57 77.139-22.667-10.002-57.335-31.313-77.569-77.14-1.393-3.155-5.036-4.606-8.143-3.109l-5.483 2.644c17.865 39.709 47.439 70.293 86.09 88.465l5.105 2.402 5.106-2.401z" fill="#9BCE7A"/>
                                    <path d="m144 429.73c0-8.895-2.965-17.536-8.426-24.558l-39.339-50.579c-1.497 3.403-2.582 7.011-3.086 10.79l-9.526 71.451c-1.918 14.387 9.274 27.172 23.79 27.172h36.587v-34.276z" fill="#9BCE7A"/>
                                    <path d="m280 274.67-96 1e-3v25.801c0 5.693-3.017 10.852-7.752 13.701 66.923 11.562 103.75-39.499 103.75-39.503z" fill="#FDC88E"/>
                                    <path d="m320 429.73c0-8.895 2.965-17.536 8.426-24.558l39.339-50.579c1.497 3.403 2.582 7.011 3.086 10.79l9.526 71.451c1.918 14.387-9.274 27.172-23.79 27.172h-36.587v-34.276z" fill="#9BCE7A"/>
                                    <path d="m314.46 260.31-51.694 21.539c-9.75 4.062-20.207 6.154-30.769 6.154s-21.02-2.092-30.77-6.154l-51.691-21.538c-17.886-7.454-29.538-24.931-29.538-44.309v-72c0-22.091 17.909-72 40-72h144c22.091 0 40 49.909 40 72v72c1e-3 19.378-11.651 36.855-29.538 44.308z" fill="#FFE1B2"/>
                                    <circle cx="120" cy="184" r="24" fill="#FFD7A3"/>
                                    <circle cx="344" cy="184" r="24" fill="#FFE1B2"/>
                                    <path d="m176 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                                    <path d="m288 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                                    <path d="m232 248.22c-14.223 0-27.527-3.5-36.5-9.605-3.652-2.484-4.602-7.461-2.113-11.113 2.48-3.648 7.461-4.598 11.113-2.113 6.289 4.277 16.57 6.832 27.5 6.832s21.211-2.555 27.5-6.832c3.66-2.492 8.629-1.539 11.113 2.113 2.488 3.652 1.539 8.629-2.113 11.113-8.972 6.105-22.277 9.605-36.5 9.605z" fill="#E4B07B"/>
                                    <path d="m245.88 86.403-10.876-6.398-115 73.741v62.255c0 19.378 11.651 36.855 29.538 44.308l51.69 21.538c2.53 1.054 5.112 1.962 7.727 2.749-22.844-16.711-38.05-31.32-46.96-40.872-6.482-6.95-9.995-16.121-9.995-25.625v-48.271c21.94-25.448 81.862-62.68 93.876-83.425z" fill="#FFD7A3"/>
                                    <path d="m232.23 80.005c0 22.667 112 62.667 112 112 0 139.67 55.772 176 55.772 176-17-55.663-7.171-289.29-95.773-352-16.25-11.5-37.154-16.155-48-16-20.695 0.296-24 8-24 8v72.001h1e-3z" fill="#FFC85C"/>
                                    <path d="m324 72.352c0 10.77-21.73 19.5-32.5 19.5-10.769 0-19.5-8.73-19.5-19.5s8.73-19.5 19.5-19.5 32.5 8.73 32.5 19.5z" fill="#FFE095"/>
                                    <path d="m324 72.352c0-10.77 21.73-19.5 32.5-19.5s19.5 8.73 19.5 19.5-8.73 19.5-19.5 19.5-32.5-8.73-32.5-19.5z" fill="#FFE095"/>
                                    <path d="m324 72.352c9.327 5.385 6.022 28.569 0.637 37.896s-17.311 12.522-26.638 7.138-12.522-17.311-7.138-26.638c5.387-9.327 23.813-23.781 33.139-18.396z" fill="#FFEEB1"/>
                                    <path d="m324 72.352c-9.327-5.385-6.022-28.569-0.638-37.896 5.385-9.327 17.311-12.522 26.638-7.138s12.522 17.311 7.137 26.638c-5.384 9.327-23.81 23.781-33.137 18.396z" fill="#FFEEB1"/>
                                    <path d="m324 72.352c-9.327 5.385-6.022 28.569-0.638 37.896 5.385 9.327 17.311 12.522 26.638 7.138s12.522-17.311 7.137-26.638c-5.384-9.327-23.81-23.781-33.137-18.396z" fill="#FFF2CE"/>
                                    <path d="m324 72.352c9.327-5.385 6.022-28.569 0.637-37.896s-17.311-12.522-26.638-7.138-12.522 17.311-7.138 26.638c5.387 9.327 23.813 23.781 33.139 18.396z" fill="#FFF2CE"/>
                                    <circle cx="324" cy="72.352" r="13" fill="#fff"/>
                                    <path d="m232.23 80.005c0 22.667-112 62.667-112 112 0 139.67-55.773 176-55.773 176 17-55.663 7.171-289.29 95.773-352 16.25-11.5 37.154-16.155 48-16 20.695 0.296 24 8 24 8v72.001z" fill="#FFC85C"/>
                                    <path d="m208.23 5e-3c-10.846-0.155-31.75 4.5-48 16-88.602 62.702-78.773 296.33-95.773 352 0 0 55.772-36.329 55.772-176 0-15.446 10.98-29.977 26.064-43.348 22.714-123.32 85.937-140.65 85.937-140.65s-3.305-7.704-24-8z" fill="#F6B45E"/>
                                </svg>
                                <svg v-else enable-background="new 0 0 464.001 464.001" version="1.1" viewBox="0 0 464 464" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m388.63 437.02-10.126-81.012c-1.529-12.228-9.943-22.492-21.633-26.389l-39.047-13.016c-5.362-1.788-11.244-0.649-15.379 2.874l-11.502-3.834c-6.533-2.178-10.94-8.292-10.94-15.179v-25.802l34.461-14.359c17.887-7.451 29.538-24.928 29.538-44.306v-8c13.255 0 24-10.745 24-24 0-5.979-2.191-11.443-5.808-15.645 6.791-24.718 25.878-102.91 5.808-136.36l8-32s-84 2-128 16l16-16s-112.5 0-135.99 39.993l-7e-3 7e-3s-40-0.333-40 48c0 17.69 9.867 61.862 14.103 80.015-3.793 4.244-6.103 9.844-6.103 15.985 0 13.255 10.745 24 24 24v8c0 19.377 11.651 36.854 29.538 44.308l34.462 14.359v25.801c0 6.887-4.407 13.001-10.94 15.179l-11.502 3.834c-4.135-3.523-10.017-4.662-15.379-2.874l-39.047 13.016c-11.691 3.897-20.105 14.161-21.633 26.389l-10.126 81.012c-1.791 14.324 9.378 26.976 23.814 26.976h265.63c14.436 0 25.606-12.652 23.815-26.977z" fill="#FFD7A3"/>
                                        <path d="m280 274.67-96 1e-3v25.801c0 5.759-3.186 10.831-8.017 13.659 67.094 11.743 104.02-39.461 104.02-39.461z" fill="#FDC88E"/>
                                        <path d="M104,176c0,0-16-65.474-16-88c0-48.333,40-48,40-48l0.007-0.007C151.5,0,264,0,264,0l-16,16    C292,2,376,0,376,0l-8,32c24,40-8,144-8,144H104z" fill="#734A3E"/>
                                        <path d="m264 0s-112.5 0-135.99 39.993l-7e-3 7e-3s-40-0.333-40 48c0 22.526 16 88 16 88s166.33-74.333 272-176c0 0-84 2-128 16l16-16z" fill="#623F33"/>
                                    <path d="m344 160v-16c0-22.091-17.909-40-40-40h-144c-22.091 0-40 17.909-40 40v16c-13.255 0-24 10.745-24 24s10.745 24 24 24v8c0 19.377 11.651 36.854 29.538 44.308l51.691 21.538c9.75 4.063 20.208 6.154 30.77 6.154s21.019-2.092 30.769-6.154l51.694-21.539c17.887-7.452 29.538-24.929 29.538-44.307v-8c13.255 0 24-10.745 24-24s-10.745-24-24-24z" fill="#FFE1B2"/>
                                        <path d="m176 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                                        <path d="m288 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                                            <path d="m232 248.22c-14.223 0-27.527-3.5-36.5-9.605-3.652-2.484-4.602-7.461-2.113-11.113 2.48-3.648 7.461-4.598 11.113-2.113 6.289 4.277 16.57 6.832 27.5 6.832s21.211-2.555 27.5-6.832c3.66-2.492 8.629-1.539 11.113 2.113 2.488 3.652 1.539 8.629-2.113 11.113-8.972 6.105-22.277 9.605-36.5 9.605z" fill="#E4B07B"/>
                                        <path d="m388.63 437.02-10.126-81.012c-1.528-12.228-9.943-22.492-21.633-26.389l-39.047-13.016c-6.8-2.267-14.45 0.154-18.291 6.206-14.182 22.344-39.107 37.187-67.531 37.187s-53.349-14.844-67.53-37.187c-3.841-6.052-11.491-8.473-18.291-6.206l-39.047 13.016c-11.691 3.897-20.105 14.161-21.633 26.389l-10.126 81.012c-1.791 14.324 9.379 26.977 23.815 26.977h265.63c14.435 0 25.605-12.653 23.814-26.977z" fill="#00BEA4"/>
                                        <path d="M92.168,340.168c-3.552,4.497-5.93,9.93-6.669,15.843l-10.126,81.012    C73.582,451.348,84.752,464,99.188,464H144v-52.067c0-7.697-2.774-15.135-7.813-20.953L92.168,340.168z" fill="#00AB9A"/>
                                        <path d="m371.83 340.17c3.552 4.497 5.93 9.93 6.669 15.843l10.126 81.012c1.791 14.325-9.379 26.977-23.815 26.977h-44.812v-52.067c0-7.697 2.774-15.135 7.813-20.953l44.019-50.812z" fill="#00AB9A"/>
                                    <path d="m162 243.72c-6.482-6.95-9.995-16.121-9.995-25.625v-90.66c25.463-1.909 105.74-8.852 152-23.438h-144c-2.754 0-5.421 0.321-8 0.881v-0.075c-18.257 3.707-32 19.843-32 39.194v16c-13.255 0-24 10.745-24 24s10.745 24 24 24v8c0 19.378 11.651 36.855 29.538 44.308l51.69 21.538c2.53 1.054 5.112 1.962 7.727 2.749-22.844-16.712-38.05-31.321-46.959-40.872z" fill="#FFD7A3"/>
                                </svg>
                            </span>
                        </span>
                        <!-- <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div> -->
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="javascript:;" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ $auth.user().name }}</a>
                        <div class="navi mt-2">
                            <a href="javascript:;" class="navi-item">
                                <span class="navi-link p-0 pb-2">
                                    <span class="navi-icon mr-1">
                                        <span class="svg-icon svg-icon-lg svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
                                                    <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text text-muted text-hover-primary">{{ $auth.user().email }}</span>
                                </span>
                            </a>
                            <a href="javascript:;" @click="logout" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                        </div>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <!--end::Separator-->
                <!--begin::Nav-->
                <div class="navi navi-spacer-x-0 p-0">
                    <!--begin::Item-->
                    <!-- <a href="javascript:void(0);" class="navi-item"> -->
                    <router-link :to="{name: 'update.profile'}" class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">My Profile</div>
                                <div class="text-muted">Account settings and more</div>
                            </div>
                        </div>
                    </router-link>
                    <!-- </a> -->
                    <router-link :to="{name: 'change.password'}" class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                                <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">Change Password</div>
                                <div class="text-muted">Password & Security</div>
                            </div>
                        </div>
                    </router-link>
                    <!--end:Item-->
                </div>
                <!--end::Nav-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-7"></div>
                <!--end::Separator-->
            </div>
            <!--end::Content-->
        </div>
        <!-- end::User Panel-->
        <div class="modal fade" tabindex="-1" id="modal-notif">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ selectedNotif.judul }}</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-times" style="font-size: 1.5rem"
                                @click="hideModalNotif"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div v-if="selectedNotif.image" class="mb-4 notif-image" :style="`background-image: url(${selectedNotif.image_url})`"></div>
                        <div v-html="selectedNotif.isi"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import postscribe from 'postscribe';
    export default {
        data() {
            return {
                localStorage: window.localStorage,
                getColorName: 'default',
                setting: {backgrounddir: null, logodarkdir: null, logowhitedir: null},
                routes: {
                    admin: [
                        {name: 'Home', path: 'home', icon: 'fa fa-home'},
                        {name: 'Kursus Mandiri', icon: 'fas fa-chalkboard-teacher', path: 'admin.course.list', path_child: 'admin.course.list.content'},
                        {name: 'Kursus Lain', icon: 'fas fa-laptop', path: 'admin.course.other.list'},
                        {name: 'Laporan', icon: 'fas fa-chart-bar',
                            child: [
                                {name: 'Kursus', path: 'admin.report.course'},
                                {name: 'Peserta', path: 'admin.report.peserta'},
                                {name: 'Data UKM', path: 'admin.master.ukm.data_ukm'},
                                {name: 'Data Koperasi', path: 'admin.master.koperasi.data_koperasi'},
                            ]
                        },
                        {name: 'Berita', icon: 'fas fa-list-ul', 
                            child: [
                                {name: 'Berita', path: 'admin.blog'},
                                {name: 'Kategori Berita', path: 'admin.blog.category'},
                            ]
                        },
                        {name: 'Front', icon: 'fas fa-desktop', 
                            child: [
                                {name: 'Slider', path: 'admin.front.slider'},
                                {name: 'Pengumuman', path: 'admin.front.pengumuman'},
                            ]
                        },
                        {name: 'Master', icon: 'fa fa-database', 
                            child: [
                                {name: 'UKM', child: [
                                    {name: 'Bentuk Badan Usaha', path: 'admin.master.ukm.badan_usaha'},
                                    {name: 'Jabatan UKM', path: 'admin.master.ukm.jabatan'},
                                    {name: 'Kategori UKM', path: 'admin.master.ukm.kategori'},
                                    {name: 'Sumber Bahan Baku', path: 'admin.master.ukm.bahan_baku'},
                                    {name: 'Legalitas Usaha', path: 'admin.master.ukm.legalitas_usaha'},
                                    {name: 'Standarisasi Produk', path: 'admin.master.ukm.standarisasi_produk'},
                                    {name: 'Wilayah Pemasaran', path: 'admin.master.ukm.wilayah_pemasaran'},
                                    {name: 'Fasilitas Kegiatan', path: 'admin.master.ukm.fas_keg_pernah'},
                                    {name: 'Masalah UKM', path: 'admin.master.ukm.masalah_ukm'},
                                ]},
                                {name: 'Koperasi', child: [
                                    {name: 'Bentuk Koperasi', path: 'admin.master.koperasi.bentuk_koperasi'},
                                    {name: 'Jenis Koperasi', path: 'admin.master.koperasi.jenis_koperasi'},
                                    {name: 'Kelompok Koperasi', path: 'admin.master.koperasi.kelompok_koperasi'},
                                    {name: 'Masalah Koperasi', path: 'admin.master.koperasi.masalah_koperasi'},
                                    {name: 'Sektor Usaha', path: 'admin.master.koperasi.sektor_usaha'},
                                ]},
                                {name: 'Pengguna', path: 'admin.master.user'},
                                {name: 'Kategori Kursus', path: 'admin.course.category'},
                                {name: 'Widyaiswara', path: 'admin.master.widyaiswara'},
                                {name: 'Wilayah', path: 'admin.master.wilayah'},
                                {name: 'Notifikasi', path: 'admin.master.notifikasi'},
                            ]
                        },
                        {name: 'Setting', path: 'admin.setting', icon: 'fa fa-tools'},
                    ],
                    user: [
                        {name: this.$t('menu.home'), path: 'home', icon: 'fa fa-home'},
                        {name: this.$t('menu.self_course'), icon: 'fas fa-chalkboard-teacher', path: 'user.course', path_child: 'user.course.content'},
                        {name: this.$t('menu.webinar'), icon: 'fas fa-laptop', path: 'user.course.other.online', path_child: 'user.course.content'},
                        // {name: this.$t('menu.other_courses'), icon: 'fas fa-laptop', 
                        //     child: [
                        //         {name: 'Online', path: 'user.course.other.online', path_child: 'user.course.list.content'},
                        //         {name: 'Offline', path: 'user.course.other.offline', path_child: 'user.course.list.content'}
                        //     ]
                        // },
                    ]
                },
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
                },
                selectedNotif: {},
                hasReadNotifs: [],
                unReadNotifs: [],
                countUnReadNotif: 0
            }
        },
        methods: {
            isiText(raw, space) {
                const span= document.createElement('span');
                span.innerHTML= raw;
                if (space) {
                    const children= span.querySelectorAll('*');
                    for (let i = 0 ; i < children.length ; i++) {
                        if (children[i].textContent) children[i].textContent += ' ';
                        else children[i].innerText += ' ';
                    }
                }
                return [span.textContent || span.innerText].toString().replace(/ +/g,' ');
            },
            openNotif(notif) {
                const vm = this;
                switch (notif.onclick) {
                    case 'SHOW_DETAIL':
                        vm.showModalNotif(notif.uuid);
                        break;

                    case 'SHOW_COURSE':
                        vm.$router.push({name: 'user.course.content', params: {uuid: notif.target}});
                        break;

                    case 'SHOW_COURSE_OTHER':
                        vm.$router.push({name: 'user.course.other.content', params: {uuid: notif.target}});
                        break;
                
                    default:
                        break;
                }
                vm.readNotif(notif.uuid);
            },
            readNotif(uuid) {
                const vm = this;
                vm.$http({
                    url: '/notifikasi/' + uuid + '/read',
                    method: 'POST'
                }).then(res => {
                    vm.getCountUnReadNotif();
                }).catch(err => {

                });
                document.body.click();
            },
            showModalNotif(uuid) {
                const vm = this;
                $('#modal-notif').modal('show');
                KTApp.block('#modal-notif');
                vm.$http({
                    url: '/notifikasi/' + uuid + '/read',
                    method: 'POST'
                }).then(res => {
                    vm.selectedNotif = res.data.data;
                    KTApp.unblock('#modal-notif');
                    document.body.click();
                    vm.getCountUnReadNotif();
                }).catch(err => {

                })
            },
            hideModalNotif() {
                $('#modal-notif').modal('hide');
                this.selectedNotif = {};
            },
            logout() {
                var vm = this;
                Swal.fire({
                    title:"Apakah anda yakin?",
                    text:"Akan keluar dari akun.",
                    icon:"warning",
                    showCancelButton: true,
                    confirmButtonText:"Ya",
                    cancelButtonText:"Tidak",
                    reverseButtons: false
                }).then(function(e) {
                    if(e.value){
                        vm.$router.push({name: 'logout'})
                        Swal.fire(
                            "Berhasil!",
                            "keluar dari akun.",
                            "success"
                        ).then(function() {
                            document.location.reload();
                        })
                    }
                }).catch(swal.noop);
            },
            randomColorName() {
                var app = this;
                var items = ['info', 'success', 'warning', 'danger', 'default'];
                // setInterval(function() {
                app.getColorName = items[Math.floor(Math.random()*items.length)];
                // }, 200)
            },
            middleware(level, levels=[]) {
                var app = this;
                if(levels.length != 0){
                    if(levels.includes(app.$auth.user().level)){
                        return
                    }else{
                        app.$router.push({name: 'notfound'});
                    }
                }else{
                    if(app.$auth.user().level == level || level == 'all') {
                        return;
                    }else{
                        app.$router.push({name: 'notfound'});
                    }
                }
            },
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
            getHariIni() {
               var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
               var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
               var date = new Date();
               var day = date.getDate();
               var month = date.getMonth();
               var thisDay = date.getDay(),
                   thisDay = myDays[thisDay];
               var year = date.getFullYear();
               return thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
            },


            // active class
            isActive(menuItem, menuItem2=null) {
                var vm = this;
                if(menuItem2) {
                    return this.$route.name === menuItem || this.$route.name === menuItem2;
                }
                return this.$route.name === menuItem;
            },
            setActive: function (menuItem) {
              this.activeItem = menuItem
            },
            loadPreload() {
                var vm = this;
                var s = setInterval(function() {
                    if(vm.$auth.ready() && vm.$auth.check()) {
                        clearInterval(s);
                        $(function() {
                          for (var i = 0; i < KTAppSettings.pc.length; i++) {
                            if(atob(KTAppSettings.pc[i].substring(6)).includes(vm.$auth.user().level)) {
                                var l = document.createElement('link');
                                l.href = vm.base_url +'/'+ atob(KTAppSettings.pc[i].substring(6));
                                l.rel = 'preload';
                                l.as = 'script';

                                $("link[name=gfont]").after(l)
                            }
                          }
                        });
                    }else{
                    }
                }, 200)
            },
            checkKUKM(cb) {
                var vm = this;
                vm.$http({
                    url: `/check_data`,
                    method: 'GET',
                }).then((res) => {
                    if(!res.data.data.has_filled) {
                        toastr.error('Harap lengkapi data terlebih dahulu.');
                        vm.$router.push({name: `user.${res.data.data.type}`});
                    } else {
                        cb();
                    }
                }).catch((error) => {
                    
                });
            },
            checkProfile(cb) {
                const vm = this;
                vm.$http({
                    url: '/check_profile',
                    method: 'GET',
                }).then(res  => {
                    if (!res.data.data.has_filled) {
                        toastr.error('Harap lengkapi informasi Akun terlebih dahulu.');
                        vm.$router.push({name: 'update.profile'});
                    } else {
                        cb();
                    }
                }).catch(error => {

                });
            },
            getHasReadNotif() {
                const vm = this;
                setTimeout(() => {
                    KTApp.block('#hasread-notifications');                    
                    vm.$http({
                        url: '/notifikasi/has_read',
                        method: 'GET',
                    }).then(res => {
                        vm.hasReadNotifs = res.data.data;
                        KTApp.unblock('#hasread-notifications');
                    }).catch(error => {
                        
                    });
                }, 10);
            },
            getUnReadNotif() {
                const vm = this;
                setTimeout(() => {
                    KTApp.block('#unread-notifications');
                    vm.$http({
                        url: '/notifikasi/unread',
                        method: 'GET',
                    }).then(res => {
                        vm.unReadNotifs = res.data.data;
                        KTApp.unblock('#unread-notifications');
                        vm.getCountUnReadNotif();
                    }).catch(error => {
                        
                    });
                }, 10);
            },
            getCountUnReadNotif() {
                const vm = this;
                vm.$http({
                    url: '/notifikasi/count_unread',
                    method: 'GET',
                }).then(res => {
                    vm.countUnReadNotif = res.data.data;
                }).catch(error => {
                    
                });
            }
        },
        watch:{
            locale (val) {
                this.$i18n.locale = val;
                localStorage.setItem('locale', val);
                // this.$forceUpdate();
                this.$router.go(0);
            },
            '$route' (to, from){
                if(to.meta.breadcrumb) {
                    setTimeout(function() {
                        if (!KTUtil.hasClass($('body')[0],"subheader-enabled")) {
                            $('body').toggleClass('subheader-enabled', true);
                        }
                    }, 10)
                }else{
                    setTimeout(function() {
                        if (KTUtil.hasClass($('body')[0],"subheader-enabled")) {
                            $('body').toggleClass('subheader-enabled', false);
                        }
                    }, 10)
                }

                if(to.name == 'admin.course.content' || to.name == 'user.course.content') {
                    setTimeout(function() {
                        if (!KTUtil.hasClass($('body')[0],"aside-minimize")) {
                            $('body').toggleClass('aside-minimize', true);
                        }
                    }, 10)
                }else{
                    setTimeout(function() {
                        if (KTUtil.hasClass($('body')[0],"aside-minimize")) {
                            $('body').toggleClass('aside-minimize', false);
                        }
                    }, 10)
                }
            }
        },
        mounted() {
            var vm = this;
            this.getConfig();
            this.randomColorName();
            setTimeout(function() {
                postscribe('#core', `<script src="${process.env.MIX_APP_URL}/assets/js/scripts.bundle.js"><\/script>`);
                // vm.loadPreload();
                $('#modal-notif').on('hidden.bs.modal', function () {
                    vm.selectedNotif = {};
                });
            }, 500);
            
            const s = setInterval(function() {
                if(vm.$auth.ready() && vm.$auth.check() && vm.$auth.user().level == 'user') {
                    clearInterval(s);

                    vm.getCountUnReadNotif();
                    // vm.getHasReadNotif();
                    // vm.getUnReadNotif();
                    setInterval(() => {
                        vm.getCountUnReadNotif();
                    }, 20000);
                }
            }, 200)
        }
    }
</script>

<style scoped>
.notif-image {
    height: 120px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}
</style>