<template>
    <div class="container">
        <main v-if="showIndex">
            <div v-if="!isLoading" class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <a class="btn btn-sm bg-danger-o-50 text-dark-50 font-weight-bold" @click="$router.go(-1)"><i class="fas fa-chevron-left"></i> {{ $t('back') }}</a>
                    </div>
                    <div class="card-toolbar">
                        <button @click="((localStorage.getItem('authToken')) ? gotoUrl(`${base_url}/user/course/${$route.params.uuid}/content`) : gotoLoginWith($route.params.uuid) )" class="btn btn-sm font-weight-bold btn-outline-primary" :class="`btn-${$parent.getColorName}`">{{ $t('schedule.join') }} <i class="fas fa-chevron-right ml-2"></i></button>
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
                                        <img v-if="course.image_url" :src="course.image_url" class="bgi-no-repeat bgi-size-cover rounded w-100 bgi-position-center"/>
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
                    <div v-if="courseContent.course_question[0]" class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title font-size-h3 mb-4 text-primary">Soal Pilihan Ganda</h4>
                                </div>
                                <template v-for="(course_question, index) in courseContent.course_question">
                                    <div class="col-md-12">
                                        <h4 class="card-title font-size-h5 mb-4 ml-2 text-dark-75">{{ index+1 }}. {{ course_question.question }}</h4>
                                    </div>
                                    <div class="col-md-12 ml-6">
                                        <div class="form-group">
                                            <div class="radio-list">
                                                <label class="radio">
                                                    <input @change="saveAnswer(course_question.uuid, 'a')" type="radio" :checked="((course_question.your_answer == 'a') ? 'checked' : false)" v-model="course_question.your_answer" :name="`question_${course_question.uuid}`" value="a"/>
                                                    <span></span>
                                                    a. {{ course_question.a_answer }}
                                                </label>
                                                <label class="radio">
                                                    <input @change="saveAnswer(course_question.uuid, 'b')" type="radio" :checked="((course_question.your_answer == 'b') ? 'checked' : false)" v-model="course_question.your_answer" :name="`question_${course_question.uuid}`" value="b"/>
                                                    <span></span>
                                                    b. {{ course_question.b_answer }}
                                                </label>
                                                <label class="radio">
                                                    <input @change="saveAnswer(course_question.uuid, 'c')" type="radio" :checked="((course_question.your_answer == 'c') ? 'checked' : false)" v-model="course_question.your_answer" :name="`question_${course_question.uuid}`" value="c"/>
                                                    <span></span>
                                                    c. {{ course_question.c_answer }}
                                                </label>
                                                <label class="radio">
                                                    <input @change="saveAnswer(course_question.uuid, 'd')" type="radio" :checked="((course_question.your_answer == 'd') ? 'checked' : false)" v-model="course_question.your_answer" :name="`question_${course_question.uuid}`" value="d"/>
                                                    <span></span>
                                                    d. {{ course_question.d_answer }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
                courseContent: {content: "", video_url: null, course_question: []},
                KTC: null,
                sectionPage: 0,
                question: {},
            }
        },
        methods: {
            gotoLoginWith(uuid) {
                localStorage.setItem('redirect_login', btoa(JSON.stringify({name: 'user.course.content', params: {uuid: uuid}})));
                localStorage.setItem('after_redirect', true);
                window.location.href = "/login";
            },
            gotoUrl(url) {
                window.location.href = url;
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
                    url: '../front/course/detail',
                    method: 'POST',
                    data: {course: vm.$route.params.uuid},
                }).then((res) => {
                    vm.course = res.data.data;
                    vm.isLoading = false;
                }).catch((error) => {
                    vm.isLoading = false;
                    toastr.error(error.response.data.message);
                    vm.$router.push({name: 'home'});
                });
            },
            setShowIndex() {
                var vm = this;
                vm.showIndex = true;
                vm.showContent = false;
            },
            checkAuth() {
                const vm = this;
                vm.$http({
                    url: '/auth/user',
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${vm.localStorage.getItem('authToken')}`
                    }
                }).then(res => {
                    this.getCourseDetail();
                }).catch(err => {
                    vm.gotoLoginWith(vm.$route.params.uuid);
                    // window.location.href = `/login?from=${window.location.pathname}`;
                })
            }
        },
        mounted() {
            KTUtil.scrollTop();
            var vm = this;
            this.getCourseDetail();
            // vm.checkAuth();
        }
    }
</script>