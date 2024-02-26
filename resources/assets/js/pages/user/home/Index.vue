<template>
    <div class="container" v-infinite-scroll="getCourse" infinite-scroll-disabled="dataEmpty" infinite-scroll-distance="10" infinite-scroll-throttle-delay="800">
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>{{ $t('home.courses_attended') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <template v-for="course in courses">
                <div v-if="course.is_course_other" @click="selectCourse(course.uuid, true)" class="col-xl-3 col-md-4 col-sm-6 col-xs-12" style="cursor: pointer;">
                    <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+course.image_url+'); background-position: center;'">
                        <div class="card-body d-flex flex-column ribbon ribbon-clip ribbon-left" style="z-index: 1;">
                            <div class="ribbon-target" style="top: 12px;">
                                <span class="ribbon-inner bg-success"></span>{{ course.title }}
                            </div>
                            <p class="d-none font-size-lg pt-7 desc">{{ course.description.strip_tags().substring(0, 80)+((course.description.strip_tags().length > 80) ? '...' : '') }}</p>
                        </div>
                    </div>
                </div>
                <div v-else @click="selectCourse(course.uuid)" class="col-xl-3 col-md-4 col-sm-6 col-xs-12" style="cursor: pointer;">
                    <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+course.image_url+'); background-position: center;'">
                        <div class="card-body d-flex flex-column ribbon ribbon-clip ribbon-left" style="z-index: 1;">
                            <div class="ribbon-target" style="top: 12px;">
                                <span class="ribbon-inner bg-success"></span>{{ course.nm_course }}
                            </div>
                            <div v-if="course.is_finish == 'Y'" class="ribbon-target" style="padding-top: 2px; padding-bottom: 2px; top: 280px;left: 0px;border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;">
                                <span class="ribbon-inner ribbon-innerx bg-success" style="border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;"></span>{{ $t('home.finished') }}
                            </div>
                            <div v-else class="ribbon-target" style="padding-top: 2px; padding-bottom: 2px; top: 280px;left: 0px;border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;">
                                <span class="ribbon-inner ribbon-innerx bg-warning" style="border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;"></span>{{ $t('home.unfinished') }} ({{ Math.floor((course.section_now/course.total_section)*100) }}%)
                            </div>
                            <p class="d-none font-size-lg pt-7 desc">{{ course.overview.strip_tags().substring(0, 80)+((course.overview.strip_tags().length > 80) ? '...' : '') }}</p>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="isLoading" v-for="vcl in 8">
                <div class="col-xl-3 col-md-4 col-sm-6 col-xs-12 mb-8">
                    <vue-content-loading :width="100" :height="67" primary="#dadada" secondary="#c1c1c1">
                        <rect x="0" y="0" rx="4" ry="4" width="100%" height="100%" />
                    </vue-content-loading>
                </div>
            </template>
        </div>
    </div>
</template>

<style>

.ribbon.ribbon-clip.ribbon-left .ribbon-target .ribbon-innerx:before {
    border-width: 0px;
    border-right-color: #181c32!important;
    left: 0;
}

.hoverEffect::before {
    background-color: #fff;
    opacity: 0.77;
}

.hoverEffect:hover .desc {
    display: block!important;
}

.hoverEffect:hover:after {    
    content: "";
    background-color: #fff;
    border-radius: .42rem;
    background-size: cover;
    position: absolute;
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    opacity: 0.77;
    -webkit-transition: background-color 1000ms linear;
    -ms-transition: background-color 1000ms linear;
    transition: background-color 1000ms linear;
}
</style>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND
    
    import { VueContentLoading } from 'vue-content-loading';
    import infiniteScroll from 'vue-infinite-scroll'

    export default {
        directives: {infiniteScroll},
        components: {
            VueContentLoading,
        },
        data() {
            return {
                courses: [],
                isLoading: false,
                pageNow: 1,
                dataEmpty: false,
            }
        },
        methods: {
            selectCourse(id, is_course_other=null) {
                var vm = this;
                if (is_course_other) {
                    this.$router.push({name: 'user.course.other.content', params: {uuid: id}});
                    return;
                }
                this.$router.push({name: 'user.course.content', params: {uuid: id}});
            },
            getCourse() {
                var vm = this;
                vm.isLoading = true;
                vm.dataEmpty = true;
                vm.$http({
                    url: '/course/joined?take=8&page='+vm.pageNow,
                    method: 'GET',
                }).then((res) => {
                    vm.courses = vm.courses.concat(res.data.data);
                    vm.isLoading = false;
                    vm.dataEmpty = false;
                    if(res.data.data.length == 0) {
                        vm.dataEmpty = true;
                    }
                    vm.pageNow++;
                }).catch((error) => {
                    vm.isLoading = false;
                    vm.dataEmpty = true;
                });
            },
            loadScroll() {
                var vm = this;
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

                    if (bottomOfWindow) {
                        vm.getCourse();
                    }
                };
            },
        },
        mounted() {
            this.$parent.middleware('user');
            // this.$parent.checkKUKM();
            this.getCourse();
        }
    }
</script>