<template>
    <div class="container">
        <main>
            <div v-if="!isLoading" class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <a class="btn btn-sm bg-danger-o-50 text-dark-50 font-weight-bold" @click="$router.go(-1)"><i class="fas fa-chevron-left"></i> {{ $t('back') }}</a>
                    </div>
                    <div class="card-toolbar">
                        <button v-if="course.sudah_terlaksana == 'N'" @click="((localStorage.getItem('authToken')) ? gotoUrl(`${base_url}/user/course/other/${$route.params.uuid}/content`) : gotoLoginWith($route.params.uuid) )" class="btn btn-sm font-weight-bold btn-outline-primary" :class="`btn-${$parent.getColorName}`">{{ $t('schedule.join') }} <i class="fas fa-chevron-right ml-2"></i></button>
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
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <span class="card-title font-weight-bolder text-primary font-size-h4">{{ $t('schedule.description') }}</span>
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
                                            <label>{{ $t('schedule.start_date') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.date_start.indo() }}</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('schedule.end_date') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.date_end.indo() }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('schedule.start_time') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.time_start }} WIB</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('schedule.end_time') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.time_end }} WIB</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>{{ $t('schedule.quota') }}</label>
                                            <div class="font-size-h6 font-weight-bolder">{{ course.quota }} Orang</div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="course.is_online == 1" class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Meeting ID <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('schedule.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('schedule.wait_admin') }}</span></label>
                                            <div v-if="!course.is_joined || !course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">*** *** ***</div>
                                            <div v-if="course.is_joined && course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">{{ course.username }}</div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Password <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('schedule.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('schedule.wait_admin') }}</span></label>
                                            <div v-if="!course.is_joined || !course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">*********</div>
                                            <div v-if="course.is_joined && course.is_confirmed" class="form-control font-size-h6 font-weight-bolder">{{ course.password }}</div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meeting URL <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('schedule.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('schedule.wait_admin') }}</span></label>
                                            <button v-if="!course.is_joined || !course.is_confirmed" disabled type="button" class="btn btn-sm btn-primary btn-toolbar">BUKA APLIKASI</button>
                                            <button v-if="course.is_joined && course.is_confirmed" @click="openUrl(course.meeting_url)" type="button" class="btn btn-sm btn-primary btn-toolbar">BUKA APLIKASI</button>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="course.is_online == 0" class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>{{ $t('schedule.place') }} <span v-if="!course.is_joined" class="font-size-sm text-danger">* {{ $t('schedule.join_view') }}</span><span v-if="course.is_joined && !course.is_confirmed" class="font-size-sm text-danger">* {{ $t('schedule.wait_admin') }}</span></label>
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
                        <a class="btn btn-sm btn-danger font-weight-bold" @click="$router.go(-1)"><i class="fas fa-chevron-left"></i> KEMBALI</a>
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
                            <a href="#" class="card-title font-weight-bolder text-primary font-size-h4 m-0 pt-7 pb-3">Deskripsi</a>
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
            }
        },
        methods: {
            gotoLoginWith(uuid) {
                localStorage.setItem('redirect_login', btoa(JSON.stringify({name: 'user.course.other.content', params: {uuid: uuid}})));
                localStorage.setItem('after_redirect', true);
                window.location.href = "/login";
            },
            gotoUrl(url) {
                window.location.href = url;
            },
            openUrl(url) {
                window.open(url,'_blank');
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
                    url: '../front/course/other/detail',
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
            // this.checkAuth();
        }
    }
</script>