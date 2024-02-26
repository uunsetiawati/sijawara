<template>
    <div class="container" v-infinite-scroll="getCourse" infinite-scroll-disabled="dataEmpty" infinite-scroll-distance="10" infinite-scroll-throttle-delay="800">
        <div class="row mb-4">
            <div class="col-sm-12 offset-md-3 col-md-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-solid" style="background-color: unset; border: 1px solid #f3f6f9;">
                                    <input type="text" class="form-control" :placeholder="$t('course.search_course')" v-model="searchText" @input="() => {this.search(); this.isSearchLoading = true;}">
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
        </div>
        <div class="row">
            <div v-if="!isLoading && courses.length == 0">{{ $t('no_course') }}</div>
            <template v-for="course in courses">
                <div @click="selectCourse(course.uuid)" class="col-xl-3 col-md-4 col-sm-6 col-xs-12" style="cursor: pointer;">
                    <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b hoverEffect" :style="'height: 303.75px; background-image: url('+course.image_url+'); background-position: center;'">
                        <div class="card-body d-flex flex-column ribbon ribbon-clip ribbon-left" style="z-index: 1;">
                            <div class="ribbon-target" style="top: 12px;">
                                <span class="ribbon-inner bg-success"></span>{{ course.title }}
                            </div>
                            <p class="d-none font-size-lg pt-7 desc">{{ course.description.strip_tags().substring(0, 80)+((course.description.strip_tags().length > 80) ? '...' : '') }}</p>
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
                searchText: "",
                isSearchLoading: false,
            }
        },
        methods: {
            search: _.debounce(function() {
                this.pageNow = 1;
                this.getCourse(true);
            }, 500),
            selectCourse(id) {
                var vm = this;
                this.$router.push({name: 'user.course.other.content', params: {uuid: id}});
            },
            getCourse(search=false) {
                var vm = this;
                vm.isLoading = true;
                vm.dataEmpty = true;
                vm.$http({
                    url: '/course/other/show?type=online&take=8&page='+vm.pageNow+`&q=${vm.searchText}`,
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
                    vm.pageNow++;
                }).catch((error) => {
                    vm.isSearchLoading = false;
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