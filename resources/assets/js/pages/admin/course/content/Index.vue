<template>
    <div class="container">
        <main v-if="showIndex">
            <div v-if="!isLoading" class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <router-link :to="{name: 'admin.course'}" class="btn btn-sm btn-danger font-weight-bold" @click="setShowContent"><i class="fas fa-chevron-left"></i> KEMBALI</router-link>
                    </div>
                    <div class="card-toolbar" v-if="!course.section">
                        <button type="button" v-if="course.module_url" data-toggle="modal" data-target="#modalCourseModule" class="btn btn-primary btn-sm mr-3"><i class="fa fa-search"></i> MODULE</button>
                        <button v-if="!course.is_joined" class="btn btn-sm btn-success font-weight-bold" @click="joinCourse"><i class="fas fa-chevron-right"></i> GABUNG</button>
                        <button v-if="course.is_joined" class="btn btn-sm btn-primary font-weight-bold" @click="startViewContent"><i class="fas fa-chevron-right"></i> {{ ((course.section != null) ? ((course.section.section == 0) ? 'MULAI' : 'LANJUT') : 'MULAI') }}</button>
                    </div>

                    <div class="card-toolbar" v-if="course.section">
                        <button type="button" v-if="course.module_url" data-toggle="modal" data-target="#modalCourseModule" class="btn btn-primary btn-sm mr-3"><i class="fa fa-search"></i> MODULE</button>
                        <button v-if="!course.is_joined" class="btn btn-sm btn-success font-weight-bold" @click="joinCourse"><i class="fas fa-chevron-right"></i> GABUNG</button>
                        <button v-if="course.is_joined && course.section.is_finish == 'N'" class="btn btn-sm btn-primary font-weight-bold" @click="startViewContent"><i class="fas fa-chevron-right"></i> {{ ((course.section != null) ? ((course.section.section == 0) ? 'MULAI' : 'LANJUT') : 'MULAI') }}</button>
                        <span v-if="course.section.is_finish == 'Y'" class="label label-xl label-inline label-success">Telah Selesai Pada {{ course.section.finished_at.tgl_indo() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title font-size-h3 font-weight-bolder text-center text-dark-75">{{ course.nm_course }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex justify-content-between flex-column h-100">
                                <!--begin::Container-->
                                <div class="h-100">
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column flex-center">
                                        <!--begin::Image-->
                                        <div class="bgi-no-repeat bgi-size-cover rounded min-h-350px w-100 bgi-position-center" :style="'background-image: url('+course.image_url+')'"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">Silabus</span>
                            <div class="timeline timeline-5 mt-3">
                                <template v-for="(syllabus, i) in course.syllabus">
                                    <div class="timeline-item align-items-start">
                                        <!--begin::Label-->
                                        <!-- <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">08:42</div> -->
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless icon-xl" :class="'text-'+checkSyllabus(i)"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="font-size-lg font-weight-bold font-weight-mormal pl-3 text-dark-75 timeline-content">{{ syllabus }}</div>
                                        <!--end::Text-->
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">Overview</span>
                            <p class="pre-format mt-3" v-html="course.overview.replace(/(\\r)*\\n/g, '<br>')"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isLoading" class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                            <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                        </vue-content-loading>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="d-flex justify-content-between flex-column h-100">
                                <!--begin::Container-->
                                <div class="h-100">
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column flex-center">
                                        <!--begin::Image-->
                                        <vue-content-loading :width="500" :height="350" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 350px">
                                            <rect x="0" y="0" rx="4" ry="4" width="500" height="350" />
                                        </vue-content-loading>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">
                                            <vue-content-loading :width="500" :height="30" primary="#dadada" secondary="#c1c1c1" style="width: 500px; height: 30px">
                                                <rect x="0" y="0" rx="4" ry="4" width="500" height="30" />
                                            </vue-content-loading>
                                        </a>
                                        <!--end::Title-->
                                        <!--begin::Text-->
                                        <!--end::Text-->
                                    </div>
                                </div>
                                <!--end::Footer-->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">Overview</a>
                            <vue-content-loading :width="350" :height="300" primary="#dadada" secondary="#c1c1c1" style="width: 350px; height: 300px">
                                    <rect x="0" y="0" rx="4" ry="4" width="350" height="20" />
                                    <rect x="0" y="30" rx="4" ry="4" width="350" height="20" />
                                    <rect x="0" y="60" rx="4" ry="4" width="350" height="20" />
                                    <rect x="0" y="90" rx="4" ry="4" width="300" height="20" />
                            </vue-content-loading>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">Silabus</a>
                            <div class="timeline timeline-5 mt-3">
                                <template v-for="syllabus in 3">
                                    <div class="timeline-item align-items-start">
                                        <!--begin::Label-->
                                        <!-- <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">08:42</div> -->
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless icon-xl" :class="'text-'+randomColorName()"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="font-size-lg font-weight-bold font-weight-mormal pl-3 text-dark-75 timeline-content">
                                            <vue-content-loading :width="200" :height="20" primary="#dadada" secondary="#c1c1c1" style="width: 200px; height: 20px;">
                                                    <rect x="0" y="0" rx="4" ry="4" width="200" height="20" />
                                            </vue-content-loading>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <main v-if="showContent">
            <div class="card card-custom card-sticky" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">{{ courseContent.title }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" v-if="courseContent.module_url" data-toggle="modal" data-target="#modalModule" class="btn btn-primary btn-sm mr-3"><i class="fa fa-search"></i> MODULE</button>
                        <div style="width: 310px;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black" role="progressbar" :style="'width: '+progressbarPercent+'%'" :aria-valuenow="progressbarPercent" aria-valuemin="0" aria-valuemax="100">{{ progressbarPercent }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title font-size-h3 font-weight-bolder text-center text-dark-75">{{ courseContent.title }}</h4>
                        </div>
                        <div v-if="courseContent.video_url" class="col-md-12 mb-10">
                            <div v-if="!courseContent.video_url.includes('LOCAL') && !courseContent.video_url.includes('drive.google.com')" id="player" data-plyr-provider="youtube" :data-plyr-embed-id="courseContent.video"></div>
                            <video v-if="courseContent.video_url.includes('LOCAL')" id="player" playsinline controls>
                                <source :src="courseContent.video_url" type="video/mp4" />
                            </video>
                            <div v-if="courseContent.video_url.includes('drive.google.com')" class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" :src="courseContent.video_url" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <p class="pre-format" v-html="courseContent.content.replace(/(\\r)*\\n/g, '<br>')"></p>
                    <div v-if="courseContent.course_question" class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title font-size-h3 mb-4 text-primary">Soal Pilihan Ganda</h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="card-title font-size-h5 mb-4 ml-2 text-dark-75">{{ courseContent.course_question.question }}</h4>
                                </div>
                                <div class="col-md-12 ml-6">
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <label class="radio">
                                                <input @change="saveAnswer" type="radio" :checked="((question.answer == 'a') ? 'checked' : false)" v-model="question.answer" name="question" value="a"/>
                                                <span></span>
                                                a. {{ courseContent.course_question.a_answer }}
                                            </label>
                                            <label class="radio">
                                                <input @change="saveAnswer" type="radio" :checked="((question.answer == 'b') ? 'checked' : false)" v-model="question.answer" name="question" value="b"/>
                                                <span></span>
                                                b. {{ courseContent.course_question.b_answer }}
                                            </label>
                                            <label class="radio">
                                                <input @change="saveAnswer" type="radio" :checked="((question.answer == 'c') ? 'checked' : false)" v-model="question.answer" name="question" value="c"/>
                                                <span></span>
                                                c. {{ courseContent.course_question.c_answer }}
                                            </label>
                                            <label class="radio">
                                                <input @change="saveAnswer" type="radio" :checked="((question.answer == 'd') ? 'checked' : false)" v-model="question.answer" name="question" value="d"/>
                                                <span></span>
                                                d. {{ courseContent.course_question.d_answer }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <ul v-if="showContent" class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
            <li class="nav-item mb-2" id="syllabus_panel_toggle" data-toggle="tooltip" title="Daftar Silabus" data-placement="right">
                <a class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="javascript;;">
                    <i class="fas fa-list-ul"></i>
                </a>
            </li>
        </ul>
        <div v-if="showContent" id="syllabus_panel" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
                <h4 class="font-weight-bold m-0">Silabus</h4>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="syllabus_panel_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="offcanvas-content">
                <!--begin::Wrapper-->
                <div class="offcanvas-wrapper mb-5 scroll-pull">
                    <div class="timeline timeline-5 ml-2 mt-3">
                        <template v-if="course.syllabus" v-for="(syllabus, i) in course.syllabus">
                            <div class="timeline-item align-items-start">
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless icon-xl" :class="'text-'+checkSyllabus(i)"></i>
                                </div>
                                <div :class="'text-'+((sectionPage == i) ? 'primary' : 'dark-75')" class="font-size-lg font-weight-bold font-weight-mormal pl-3 timeline-content">{{ syllabus }}</div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!--end::Content-->
            <div class="offcanvas-footer" kt-hidden-height="38" style="">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-xl-6 col-6">
                        <button v-if="sectionPage != 0" @click="goToSection('back')" class="btn btn-block btn-danger btn-shadow font-weight-bolder text-uppercase">Back</button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-xl-6 col-6">
                        <button v-if="sectionPage != section.total_section" @click="goToSection('next')" class="btn btn-block btn-primary btn-shadow font-weight-bolder text-uppercase">Next</button>
                        <button v-if="sectionPage == section.total_section" @click="completeCourse()" class="btn btn-block btn-primary btn-shadow font-weight-bolder text-uppercase">Finish</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="courseContent.module_url" class="modal fade" id="modalModule" tabindex="-1" role="dialog" aria-labelledby="modalModule" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Module {{ courseContent.title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe v-if="courseContent.module_url.includes('google.com')" :src="courseContent.module_url" width="750px" height="750px" allowfullscreen frameborder="0"></iframe>
                        <object v-else :data="courseContent.module_url" allowfullscreen type="application/pdf" width="750px" height="750px">
                            <embed :src="courseContent.module_url" allowfullscreen type="application/pdf">
                                <p>This browser does not support PDF.</a>.</p>
                            </embed>
                        </object>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="course.module_url" class="modal fade" id="modalCourseModule" tabindex="-1" role="dialog" aria-labelledby="modalCourseModule" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Module {{ course.nm_course }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe v-if="course.module_url.includes('google.com')" :src="course.module_url" width="750px" height="750px" allowfullscreen frameborder="0"></iframe>
                        <object v-else :data="course.module_url" allowfullscreen type="application/pdf" width="750px" height="750px">
                            <embed :src="course.module_url" allowfullscreen type="application/pdf">
                                <p>This browser does not support PDF.</a>.</p>
                            </embed>
                        </object>
                    </div>
                </div>
            </div>
        </div>
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
    import Plyr from '../../../../../../../public/js/plyr.js';
    import '../../../../../../../public/css/plyr.css';

    export default {
        components: {
            VueContentLoading
        },
        data() {
            return {
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
            }
        },
        methods: {
            async goToSection(v) {
                var vm = this;
                if(v == 'next') {
                    if(vm.question.uuid) {
                        if(vm.question.answer == null){
                            Swal.fire({
                                icon: 'error',
                                title: 'Harap isi soal pilihan ganda.',
                            }).then((v) => {
                                vm.KTC.hide();
                            });
                            return;
                        }
                    }
                    var z = vm.sectionPage+1;
                    await vm.getCourseContent(z);
                    await vm.getSection(function() {
                        vm.sectionPage = z;
                    });
                }else if(v == 'back') {
                    vm.sectionPage = vm.sectionPage-1;
                    await vm.getCourseContent(vm.sectionPage);
                }
                this.KTC.hide();
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
            loadJScontent() {
                if(KTLayoutHeader.getHeight() == 0) {
                    KTLayoutHeader.init("kt_header","kt_header_mobile");
                }
                if(KTLayoutSubheader.getHeight() == 0) {
                    KTLayoutSubheader.init("kt_subheader");
                    window.onscroll = function() {KTLayoutStickyCard.update()};
                }
                setTimeout(function() {  
                    KTLayoutStickyCard.init("kt_page_sticky_card");
                }, 500);
            },
            getProgress() {
                var vm = this;
                var a = vm.course.syllabus;
                vm.course.syllabus = null;
                setTimeout(function() {
                    vm.course.syllabus = a;
                })

                if(vm.section.total_section != 0) {
                    vm.progressbarPercent = Math.floor((vm.section.section_now/vm.section.total_section)*100);
                }else{
                    vm.progressbarPercent = 0;
                }
            },
            randomColorName() {
                var app = this;
                var items = ['info', 'success', 'warning', 'danger', 'primary', 'secondary'];
                return items[Math.floor(Math.random()*items.length)];
            },
            checkSyllabus(i) {
                if(this.course.section != null) {
                    if(this.section.section_now) {
                        if(i > this.section.section_now) {
                            return 'secondary';
                        }else{
                            return 'success';
                        }
                    }else{
                        if(i > this.course.section.section) {
                            return 'secondary';
                        }else{
                            return 'success';
                        }
                    }
                }else{
                    return 'secondary';
                }
            },
            getCourseDetail() {
                var vm = this;
                vm.isLoading = true;
                vm.$http({
                    url: 'course/detail',
                    method: 'POST',
                    data: {course: vm.$route.params.uuid},
                }).then((res) => {
                    vm.course = res.data.data;
                    vm.isLoading = false;
                }).catch((error) => {
                    vm.isLoading = false;
                    toastr.error(error.response.data.message);
                    vm.$router.push({name: 'admin.course'});
                });
            },
            joinCourse() {
                var vm = this;

                Swal.fire({
                    title: 'Apakah Anda yakin akan bergabung pada kursus '+vm.course.nm_course+'?',
                    showCancelButton: true,
                    icon: 'question',
                    iconHtml: '?',
                    confirmButtonText: 'Ya',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return vm.$http({
                            url: '/course/join',
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
            getCourseContent(section) {
                var vm = this;
                vm.courseContent.video_url = null;
                vm.question = {answer: null};
                KTApp.block($('.card'));
                vm.$http({
                    url: '/course/section',
                    method: 'POST',
                    data: {course: vm.course.uuid, section: section}
                }).then((res) => {
                    KTApp.unblock($('.card'));
                    vm.courseContent = res.data.data;
                    if(vm.courseContent.course_question) {
                        vm.question.uuid = vm.courseContent.course_question.uuid;
                        vm.checkQuestion();
                    }
                    if(vm.courseContent.video_url && !vm.courseContent.video_url.includes('drive.google.com')) {
                        setTimeout(function() {
                            new Plyr('#player', {
                                title: vm.courseContent.title,
                            });
                        });
                    }
                }).catch((error) => {
                    KTApp.unblock($('.card'));                    
                });
            },
            getSection(callback=null) {
                var vm = this;
                vm.$http({
                    url: '/course/get_section',
                    method: 'POST',
                    data: {course: vm.course.uuid}
                }).then((res) => {
                    vm.section = res.data.data;
                    vm.getProgress()
                    vm.sectionPage = vm.section.section_now;
                    if(callback!=null) {
                        callback();
                    }
                }).catch((error) => {
                    toastr.error(error.response.data.message);
                });
            },
            checkQuestion() {
                var vm = this;

                vm.$http({
                    url: '/course/checkQuestion',
                    method: 'POST',
                    data: {uuid: vm.question.uuid}
                }).then((res) => {
                    vm.question.answer = res.data.data.answer;
                }).catch((error) => {
                    
                });
            },
            saveAnswer() {
                var vm = this;

                vm.$http({
                    url: '/course/saveAnswer',
                    method: 'POST',
                    data: vm.question
                }).then((res) => {
                    
                }).catch((error) => {
                    
                });
            },
            completeCourse() {
                var vm = this;

                Swal.fire({
                    title: 'Apakah Anda yakin telah menyelesaikan kursus?',
                    showCancelButton: true,
                    icon: 'question',
                    iconHtml: '?',
                    confirmButtonText: 'Ya',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return vm.$http({
                            url: '/course/complete',
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
                            vm.$router.push({name: 'admin.course'})
                        });
                    }
                })
            },
            async startViewContent() {
                var vm = this;

                await vm.getSection(function() {
                    vm.getCourseContent(vm.section.section_now);
                    vm.setShowContent()
                });
            },
            setShowContent() {
                var vm = this;
                vm.showIndex = false;
                vm.showContent = true;
                setTimeout(function() {
                    vm.loadJS();
                    vm.loadJScontent();
                }, 300);
            },
            setShowIndex() {
                var vm = this;
                vm.showIndex = true;
                vm.showContent = false;
            },
        },
        mounted() {
            var vm = this;
            this.$parent.middleware('admin');
            this.getCourseDetail();            
        }
    }
</script>