<template> 
    <div class="container">
        <!-- <div class="row mb-8">
            <div class="col-md-12">
                <slider/>
            </div>
        </div> -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header justify-content-center bg-diagonal bg-diagonal-title bg-diagonal-success bg-diagonal-r-light">
                        <div class="card-title">
                            <h1 class="card-label font-size-h1 text-white" style="z-index: 2;">{{ $t('home.welcome', {name: $parent.setting.name}) }}</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <lottie-animation
                                    :path="`lottie/desktop.json`"
                                    :loop="true"
                                    :autoPlay="true"
                                    :speed="1"
                                    :height="100"
                                />
                            </div>
                            <div class="col-md-9">
                                <h3 v-html="$parent.setting.description" class="font-weight-normal"></h3>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">      
                <div class="card card-custom card-stretch gutter-b">   
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('home.independent_training') }}</h2>
                    </div>      
                    <router-link :to="{name: 'offline'}" class="menu-link">
                        <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px;background-image: url('+`${base_url}/uploads/images/COURSE_IMAGE_RENCANA_KERJA_RENCANA_ANGGARAN_PENDAPATAN_BELANJA_1604564812.png`+');background-position: center; cursor: pointer;'">  
                        </div>
                    </router-link>
                </div>                    
            </div>
            <div class="col-md-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('home.webinar') }}</h2>
                    </div>                        
                    <router-link :to="{name: 'online'}" class="menu-link">
                        <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+`${base_url}/uploads/images/COURSE_IMAGE_RAPAT_ANGGOTA_TAHUNAN_1604564752.png`+'); background-position: center; cursor: pointer;'">  
                        </div>
                    </router-link>     
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('home.news') }}</h1>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row mb-8">
            <div class="card card-custom">
                <div class="card-body pb-4">
                    <div class="row">
                        <template v-for="(blog, i) in blogs">
                            <div v-if="i == 0" class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <router-link :to="{name: 'blog.detail', params: {slug: blog.slug}}">
                                            <img v-if="blog.image_url" :src="blog.image_url" :alt="blog.title" class="rounded w-100 h-350px" style="object-fit: cover;">
                                        </router-link>
                                    </div>
                                    <div class="col-md-12">
                                        <router-link :to="{name: 'blog.detail', params: {slug: blog.slug}}" class="font-size-h4 text-sijawara">{{ blog.title }}</router-link>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="col-md-6">
                            <div class="row">
                                <template v-for="(blog, i) in blogs">
                                <div v-if="i != 0" class="col-md-12 mb-3 pb-4" :class="{'border-bottom': i != (blogs.length-1)}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <router-link :to="{name: 'blog.detail', params: {slug: blog.slug}}">
                                                <img v-if="blog.image_url" :src="blog.image_url" :alt="blog.title" class="rounded w-100 h-70px" style="object-fit: cover;">
                                            </router-link>
                                        </div>
                                        <div class="col-md-9">
                                            <router-link :to="{name: 'blog.detail', params: {slug: blog.slug}}" class="font-size-h4 text-sijawara">{{ blog.title }}</router-link>
                                            <p>{{ blog.created_at.tgl_indo() }}</p>
                                            <p>{{ blog.content.replace(/&amp;nbsp;/g, ' ' ).replace( /<.*?>/g, '' ).substr(0, 100) }} ...</p> 
                                        </div>
                                    </div>
                                </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row mb-4">
            <div class="col-sm-12 offset-md-3 col-md-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-solid" style="background-color: unset; border: 1px solid #f3f6f9;">
                                    <input type="text" class="form-control" :placeholder="$t('Cari Kursus')" v-model="searchText" @input="() => {this.search(); this.isSearchLoading = true;}">
                                    <div v-if="isSearchLoading" class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mr-4 spinner"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('home.our_course') }}</h1>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div v-infinite-scroll="getCourse" infinite-scroll-disabled="dataEmpty" infinite-scroll-distance="10" infinite-scroll-throttle-delay="800">
            <div class="row">
                <div v-if="!isLoading && courses.length == 0">{{ $t('home.no_course') }}</div>
                <template v-for="course in courses">

                    <div v-if="course.nm_course" @click="selectCourse(course.uuid)" class="col-xl-3 col-md-4 col-sm-6 col-xs-12" style="cursor: pointer;">
                        <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+course.image_url+'); background-position: center;'">
                            <div class="card-body d-flex flex-column ribbon ribbon-clip ribbon-left" style="z-index: 1;">
                                <div class="ribbon-target" style="top: 12px;">
                                    <span class="ribbon-inner bg-success"></span>{{ course.nm_course }}
                                </div>
                                <div class="ribbon-target" style="padding-top: 2px; padding-bottom: 2px; top: 280px;left: 0px;border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;">
                                    <span class="ribbon-inner ribbon-innerx bg-primary" style="border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;"></span>MANDIRI
                                </div>
                                <p class="d-none font-size-lg pt-7 desc">{{ course.overview.strip_tags().substring(0, 80)+((course.overview.strip_tags().length > 80) ? '...' : '') }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="course.title" @click="selectCourse(course.uuid, true)" class="col-xl-3 col-md-4 col-sm-6 col-xs-12" style="cursor: pointer;">
                        <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+course.image_url+'); background-position: center;'">
                            <div class="card-body d-flex flex-column ribbon ribbon-clip ribbon-left" style="z-index: 1;">
                                <div class="ribbon-target" style="top: 12px;">
                                    <span class="ribbon-inner bg-success"></span>{{ course.title }}
                                </div>
                                <div v-if="course.is_online == '1'" class="ribbon-target" style="padding-top: 2px; padding-bottom: 2px; top: 280px;left: 0px;border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;">
                                    <span class="ribbon-inner ribbon-innerx bg-success" style="border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;"></span>ONLINE
                                </div>
                                <div class="ribbon-target" style="padding-top: 2px; padding-bottom: 2px; top: 280px;left: 0px;border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;">
                                    <span class="ribbon-inner ribbon-innerx bg-info" style="border-bottom-left-radius: .42rem;border-bottom-right-radius: 0px;"></span>OFFLINE
                                </div>
                                <p class="d-none font-size-lg pt-7 desc">{{ course.description.strip_tags().substring(0, 80)+((course.description.strip_tags().length > 80) ? '...' : '') }}</p>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="isLoading" v-for="vcl in 8">
                    <div class="col-xl-3 col-md-4 col-sm-6 col-xs-12 mb-8"">
                        <vue-content-loading :width="100" :height="53.9" primary="#dadada" secondary="#c1c1c1">
                            <rect x="0" y="0" rx="4" ry="4" width="100%" height="100%" />
                        </vue-content-loading>
                    </div>
                </template>
            </div>
        </div> -->
    </div>
</template>

<style>

.bg-diagonal-title:after {
    left: 70%!important;
}

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
    import Slider from '../../components/Slider'
    import infiniteScroll from 'vue-infinite-scroll'
    import { VueContentLoading } from 'vue-content-loading';
    import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue"; 

    export default {
        directives: {infiniteScroll},
        components: {
            Slider,
            VueContentLoading,
            LottieAnimation
        },
        data() {
            return {
                courses: [],
                isLoading: false,
                dataEmpty: false,
                pageNow: 1,
                pageNowO: 1,
                blogs: [],
                searchText: "",
                isSearchLoading: false,
            }
        },
        methods: {
            search: _.debounce(function() {
                this.pageNow = 1;
                this.getCourse(true);
            }, 500),
            getBlog() {
                var vm = this;
                vm.$http({
                    url: '../front/blog/show?take=5&page=1&type=all',
                    method: 'GET',
                }).then((res) => {
                    vm.blogs = res.data.data;
                }).catch((error) => {
                    
                });
            },
            selectCourse(id, is_other=null) {
                var vm = this;
                if (is_other) {
                    this.$router.push({name: 'course_other.detail', params: {uuid: id}});
                    return;
                }
                this.$router.push({name: 'course.detail', params: {uuid: id}});
            },
            getCourse(search=false) {
                var vm = this;
                vm.isLoading = true;
                vm.dataEmpty = true;
                vm.$http({
                    url: '../front/course/show?take=100&page='+vm.pageNow+`&q=${vm.searchText}`,
                    method: 'GET',
                }).then((res) => {
                    vm.courses = vm.courses.concat(res.data.data);
                    // vm.isLoading = false;
                    // vm.dataEmpty = false;
                    // if(res.data.data.length == 0) {
                    //     vm.dataEmpty = true;
                    // }
                    vm.$http({
                        url: '../front/course/other/show?take=8&page='+vm.pageNowO+`&q=${vm.searchText}`,
                        method: 'GET',
                    }).then((res) => {
                        vm.courses = vm.courses.concat(res.data.data);
                        vm.isLoading = false;
                        vm.dataEmpty = false;
                        vm.isSearchLoading = false;
                        if(res.data.data.length == 0) {
                            vm.dataEmpty = true;
                        }
                        if (search && vm.pageNow == '1') {
                        vm.courses = vm.courses = res.data.data;
                        }
                        vm.pageNowO++;
                    }).catch((error) => {
                        vm.isLoading = false;
                        vm.dataEmpty = true;
                        vm.isSearchLoading = false;
                    });
                    vm.pageNow++;                    
                }).catch((error) => {
                    vm.isLoading = false;
                    vm.dataEmpty = true;
                    vm.isSearchLoading = false;
                });
            },
        },
        mounted() {
            KTUtil.scrollTop();
            this.getCourse();
            this.getBlog();
        }
    }
</script>