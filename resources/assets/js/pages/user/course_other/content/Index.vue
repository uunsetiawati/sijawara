<template>
    <div class="container">
        <main>
            <div v-if="!isLoading" class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <a class="btn btn-sm btn-danger font-weight-bold" @click="course.is_online == 0 ? $router.push({name: 'user.course.other.offline'}) : $router.push({name: 'user.course.other.online'})"><i class="fas fa-chevron-left"></i> {{ $t('back') }}</a>
                    </div>
                    <div class="card-toolbar" v-if="!course.is_joined">
                        <!-- <button type="button" v-if="course.module_url" data-toggle="modal" data-target="#modalCourseModule" class="btn btn-primary btn-sm mr-3"><i class="fa fa-search"></i> MODULE</button> -->
                        <button v-if="!course.is_joined" class="btn btn-sm btn-success font-weight-bold" @click="joinCourse"><i class="fas fa-chevron-right"></i> {{ $t('join') }}</button>
                        <!-- <button v-if="course.is_joined" class="btn btn-sm btn-primary font-weight-bold" @click="startViewContent"><i class="fas fa-chevron-right"></i> {{ ((course.section != null) ? ((course.section.section == 0) ? 'MULAI' : 'LANJUT') : 'MULAI') }}</button> -->
                    </div>

                    <div class="card-toolbar" v-if="course.is_joined">
                        <!-- <button type="button" v-if="showCertDownload" class="btn btn-success btn-sm mr-3 cert" @click="getCertificate" :disabled="isDisabled"><i class="fas fa-cloud-download-alt"></i> UNDUH SERTIFIKAT</button> -->
                        <!-- <button type="button" v-if="course.module_url" data-toggle="modal" data-target="#modalCourseModule" class="btn btn-primary btn-sm mr-3"><i class="fa fa-search"></i> MODULE</button>
                        <button v-if="!course.is_joined" class="btn btn-sm btn-success font-weight-bold" @click="joinCourse"><i class="fas fa-chevron-right"></i> GABUNG</button>
                        <button v-if="course.is_joined && course.section.is_finish == 'N'" class="btn btn-sm btn-primary font-weight-bold" @click="startViewContent"><i class="fas fa-chevron-right"></i> {{ ((course.section != null) ? ((course.section.section == 0) ? 'MULAI' : 'LANJUT') : 'MULAI') }}</button>
                        <span v-if="course.section.is_finish == 'Y'" class="label label-xl label-inline label-success">Telah Selesai Pada {{ course.section.finished_at.tgl_indo() }}</span> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title font-size-h3 font-weight-bolder text-center text-dark-75">{{ course.title }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 offset-md-3">
                            <div class="d-flex justify-content-between flex-column h-100">
                                <!--begin::Container-->
                                <div class="h-100">
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column flex-center">
                                        <!--begin::Image-->
                                        <img v-if="course.image_url" :src="course.image_url" class="img-fluid" :alt="course.title">
                                        <!-- <div class="bgi-no-repeat bgi-size-cover rounded min-h-350px w-100 bgi-position-center" :style="'background-image: url('+course.image_url+')'"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">Silabus</span>
                            <div class="timeline timeline-5 mt-3">
                                <template v-for="(syllabus, i) in course.syllabus">
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless icon-xl" :class="'text-'+checkSyllabus(i)"></i>
                                        </div>
                                        <div class="font-size-lg font-weight-bold font-weight-mormal pl-3 text-dark-75 timeline-content">{{ syllabus }}</div>
                                    </div>
                                </template>
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">{{ $t('course.description') }}</span>
                            <p class="pre-format mt-3" v-html="course.description.replace(/(\\r)*\\n/g, '<br>')"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">{{ ((course.is_online == 1) ? 'Online' : 'Offline') }}</span>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('course.start_date') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.date_start.indo() }}</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('course.end_date') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.date_end.indo() }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('course.start_time') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.time_start }} WIB</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('course.end_time') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.time_end }} WIB</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('course.quota') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.quota }} {{ $t('course.participant') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="course.is_online == 1" class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Meeting ID <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('course.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('course.wait_admin') }}</span></label>
                                            <div v-if="!course.is_joined || !course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">*** *** ***</div>
                                            <div v-if="course.is_joined && course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">{{ course.username }}</div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Password <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('course.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('course.wait_admin') }}</span></label>
                                            <div v-if="!course.is_joined || !course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">*********</div>
                                            <div v-if="course.is_joined && course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">{{ course.password }}</div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meeting URL <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('course.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('course.wait_admin') }}</span></label>
                                            <button v-if="!course.is_joined || !course.is_confirmed" disabled type="button" class="btn btn-sm btn-primary btn-toolbar">{{ $t('course.open_app') }}</button>
                                            <button v-if="course.is_joined && course.is_confirmed" @click="openUrl(course.meeting_url)" type="button" class="btn btn-sm btn-primary btn-toolbar">{{ $t('course.open_app') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="course.is_online == 0" class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>{{ $t('course.place') }} <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('course.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('course.wait_admin') }}</span></label>
                                            <div v-if="!course.is_joined || !course.is_confirmed" class="font-size-h6 font-weight-bolder">************************</div>
                                            <div v-if="course.is_joined && course.is_confirmed" class="font-size-h6 font-weight-bolder">{{ course.place }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isLoading" class="card card-custom">
                <div class="card-header">
                    <!-- <div class="card-title">
                        <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                            <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                        </vue-content-loading>
                    </div> -->
                    <div class="card-title">
                        <a class="btn btn-sm btn-danger font-weight-bold" @click="$router.go(-1)"><i class="fas fa-chevron-left"></i> {{ $t('back') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between flex-column h-100">
                                <!--begin::Container-->
                                <div class="h-100">
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column flex-center">
                                        <!--begin::Image-->
                                        <a href="javascript:void(0)" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-1 pb-7">
                                            <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                                <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                            </vue-content-loading>
                                        </a>
                                        <vue-content-loading :width="500" :height="350" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 350px">
                                            <rect x="0" y="0" rx="4" ry="4" width="500" height="350" />
                                        </vue-content-loading>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <!--end::Title-->
                                        <!--begin::Text-->
                                        <!--end::Text-->
                                    </div>
                                </div>
                                <!--end::Footer-->
                            </div>
                        </div>
                        <div class="col-md-4 pt-4">
                            <a href="#" class="card-title font-weight-bolder text-primary font-size-h4 m-0 pt-7 pb-3">{{ $t('course.description') }}</a>
                            <vue-content-loading :width="700" :height="150" primary="#dadada" secondary="#c1c1c1" style="width: 700px; height: 150px; margin-top: 15px;">
                                    <rect x="0" y="0" rx="4" ry="4" width="700" height="20" />
                                    <rect x="0" y="30" rx="4" ry="4" width="700" height="20" />
                                    <rect x="0" y="60" rx="4" ry="4" width="700" height="20" />
                                    <rect x="0" y="90" rx="4" ry="4" width="300" height="20" />
                            </vue-content-loading>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <vue-content-loading :width="300" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 300px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="300" height="30" />
                                    </vue-content-loading>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                                <div class="col-md-6">
                                    <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                        <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                    </vue-content-loading>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style>
    .timeline.timeline-5:before {
        left: 1px;
    }

    .pre-format {
        white-space: pre-wrap;
    }
</style>

<script>

    import { VueContentLoading } from 'vue-content-loading';

    export default {
        components: {
            VueContentLoading
        },
        data() {
            return {
                localStorage: window.localStorage,
                course: {overview: "", is_joined: false},
                isLoading: true,
                showIndex: true,
                showContent: false,
                section: {},
                progressbarPercent: 0,
                courseContent: {content: "", video_url: null, course_question: null},
                KTC: null,
                sectionPage: 0,
                question: {answer: null},
                showCertDownload: false,
                isDisabled: false,
            }
        },
        methods: {
            openUrl(url) {
                window.open(url,'_blank');
            },
            loadJS() {
                var a = 'syllabus_panel';
                var t = KTUtil.getById(a);
                var e = new KTOffcanvas(t, {
                    overlay: !0,
                    baseClass: "offcanvas",
                    placement: "right",
                    closeBy: "syllabus_panel_close",
                    toggleBy: "syllabus_panel_toggle"
                });
                this.KTC = e;
                var a = KTUtil.find(t, ".offcanvas-header"),
                    n = KTUtil.find(t, ".offcanvas-content"),
                    i = KTUtil.find(t, ".offcanvas-wrapper"),
                    o = KTUtil.find(t, ".offcanvas-footer");
                KTUtil.scrollInit(i, {
                    disableForMobile: !0,
                    resetHeightOnDestroy: !0,
                    handleWindowResize: !0,
                    height: function() {
                        var e = parseInt(KTUtil.getViewPort().height);
                        return a && (e -= parseInt(KTUtil.actualHeight(a)), e -= parseInt(KTUtil.css(a, "marginTop")), e -= parseInt(KTUtil.css(a, "marginBottom"))), n && (e -= parseInt(KTUtil.css(n, "marginTop")), e -= parseInt(KTUtil.css(n, "marginBottom"))), i && (e -= parseInt(KTUtil.css(i, "marginTop")), e -= parseInt(KTUtil.css(i, "marginBottom"))), o && (e -= parseInt(KTUtil.actualHeight(o)), e -= parseInt(KTUtil.css(o, "marginTop")), e -= parseInt(KTUtil.css(o, "marginBottom"))), e -= parseInt(KTUtil.css(t, "paddingTop")), e -= parseInt(KTUtil.css(t, "paddingBottom")), e -= 2
                    }
                });

                var tp = function(t) {
                    var e = t.data("theme") ? "tooltip-" + t.data("theme") : "",
                        a = "auto" == t.data("width") ? "tooltop-auto-width" : "",
                        n = t.data("trigger") ? t.data("trigger") : "hover";
                    $(t).tooltip({
                        trigger: n,
                        template: '<div class="tooltip ' + e + " " + a + '" role="tooltip">                <div class="arrow"></div>                <div class="tooltip-inner"></div>            </div>'
                    })
                }

                $('[data-toggle="tooltip"]').each(function() {
                    tp($(this))
                })
            },
            randomColorName() {
                var app = this;
                var items = ['info', 'success', 'warning', 'danger', 'primary', 'secondary'];
                return items[Math.floor(Math.random()*items.length)];
            },
            getCourseDetail() {
                var vm = this;
                vm.isLoading = true;
                vm.$http({
                    url: 'course/other/detail',
                    method: 'POST',
                    data: {course: vm.$route.params.uuid},
                }).then((res) => {
                    vm.course = res.data.data;
                    vm.checkDate(vm.course.date_end);
                    vm.isLoading = false;
                }).catch((error) => {
                    vm.isLoading = false;
                    toastr.error(error.response.data.message);
                    vm.$router.push({name: 'user.course'});
                });
            },
            joinCourse() {
                var vm = this;

                Swal.fire({
                    title: 'Apakah Anda yakin akan bergabung pada acara '+vm.course.title+'?',
                    showCancelButton: true,
                    icon: 'question',
                    iconHtml: '?',
                    confirmButtonText: 'Ya',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return vm.$http({
                            url: '/course/other/join',
                            method: 'POST',
                            data: {course: vm.course.uuid}
                        }).then((res) => {                
                            return res.data
                        }).catch((error) => {
                            Swal.showValidationMessage(error.response.data.message)
                        });
                    },
                    allowOutsideClick: () => false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: result.value.message,
                        }).then((v) => {
                            vm.getCourseDetail()
                        });
                    }
                })
            },
            async getCertificate() {
                var vm = this;
                KTApp.block('.cert');
                var url = '/certificate/online/getCertificate';
                if (vm.course.is_online == '0') {
                    url = '/certificate/offline/getCertificate';
                }

                const resKUKM = await vm.$http({url: '/check_data', method: 'GET'});
                const resProfile = await vm.$http({url: '/check_profile', method: 'GET'});

                if (!resProfile.data.data.has_filled) {
                    toastr.error('Harap lengkapi informasi Akun terlebih dahulu.');
                    vm.$router.push({name: `update.profile`});
                    return;
                }

                if (!resKUKM.data.data.has_filled) {
                    toastr.error('Harap lengkapi data terlebih dahulu.');
                    vm.$router.push({name: `user.${resKUKM.data.data.type}`});
                    return;
                }

                vm.$http({
                    url: url,
                    method: 'POST',
                    data: {course: vm.course.uuid}
                }).then((res) => {
                    KTApp.unblock('.cert');
                    toastr.success('Mengunduh Sertifikat ...');
                    document.location.href = res.data.data.url;
                }).catch((error) => {
                    toastr.error('Sesuatur terjadi!');
                    KTApp.unblock('.cert');
                });   
            },
            checkDate(date_end) {
                var $now = new Date().getTime();
                var $end = new Date(date_end).getTime();
                if($now > $end) {
                    this.showCertDownload = true;
                }else{
                    this.showCertDownload = false;
                }
            }
        },
        watch: {
            '$route.params.uuid': function () {
                this.getCourseDetail();
            }
        },
        mounted() {
            var vm = this;
            this.$parent.middleware('user');
            if(localStorage.getItem('redirect_login')) {
                localStorage.removeItem('redirect_login');
            }
            // this.$parent.checkKUKM();
            this.getCourseDetail();            
        }
    }
</script>