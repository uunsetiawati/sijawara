<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('news.news') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2 col-sm-12">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-icon input-icon-right">
                                    <input type="text" placeholder="Search..." class="form-control" style="padding-left: 1rem;" @input="search" v-model="q">
                                    <span role="button"><i id="icon-search" class="flaticon2-search-1 icon-md"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-control category" v-model="category">
                                    <option value="all">{{ $t('news.all') }}</option>
                                    <option v-for="kategori in categories" :value="kategori.id">{{ kategori.nm_category }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-infinite-scroll="getCourse" infinite-scroll-disabled="dataEmpty" infinite-scroll-distance="10" infinite-scroll-throttle-delay="800">
            <div class="row">
                <template v-for="course in courses">
                    <div class="col-md-12 mb-4">
                        <div class="card card-custom">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <img :src="course.image_url" class="rounded w-100 h-175px" style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-9">
                                        <router-link :to="{name: 'blog.detail', params: {slug: course.slug}}" class=" font-size-h2 text-hover-info mb-4 mt-5 mt-md-0">{{ course.title }}</router-link>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>{{ $t('news.date') }} : {{ course.created_at.tgl_indo() }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p>{{ course.content.replace(/&amp;nbsp;/g, ' ' ).replace( /<.*?>/g, '' ).substr(0, 350) }} ...</p>
                                            </div>
                                            <!-- <div class="col-md-12">
                                                <h4><i class="fas fa-cogs text-success"></i> Tipe: {{ ((course.is_online == '1') ? 'Online' : 'Offline') }}</h4>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" v-if="course.sudah_terlaksana == 'N'" class="btn btn-sm btn-primary">Belum Terlaksana <i class="fas fa-angle-right ml-1"></i></router-link>
                                                <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" v-if="course.sudah_terlaksana == 'Y'" class="btn btn-sm btn-danger">Sudah Terlaksana <i class="fas fa-angle-right ml-1"></i></router-link>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div v-if="isLoading" class="col-md-12 mb-4" v-for="vcl in 1">
                    <div class="card card-custom loading">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                </div>
                                <div class="col-md-9">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { VueContentLoading } from 'vue-content-loading';
    import infiniteScroll from 'vue-infinite-scroll';

    export default {
        directives: {infiniteScroll},
        components: {
            VueContentLoading,
        },
        data() {
            return {
                courses: [],
                categories: [],
                isLoading: true,
                dataEmpty: false,
                pageNow: 1,
                category: 'all',
                q: ''
            }
        },
        methods: {
            getCourse() {
                var vm = this;
                vm.isLoading = true;
                vm.dataEmpty = true;
                setTimeout(function() {
                    KTApp.block('.loading');
                });
                vm.$http({
                    url: '../front/blog/show?take=8&page='+vm.pageNow+'&type='+vm.category+'&q='+vm.q,
                    method: 'GET',
                }).then((res) => {
                    vm.courses = vm.courses.concat(res.data.data);
                    vm.isLoading = false;
                    vm.dataEmpty = false;
                    if(res.data.data.length == 0) {
                        vm.dataEmpty = true;
                    }
                    vm.pageNow++;
                    setTimeout(function() {
                        KTApp.unblock('.loading');
                        $('#icon-search').removeClass('spinner spinner-sm spinner-success spinner-center');
                        $('#icon-search').addClass('flaticon2-search-1');
                    });
                }).catch((error) => {
                    vm.isLoading = false;
                    vm.dataEmpty = true;
                    setTimeout(function() {
                        KTApp.unblock('.loading');
                        $('#icon-search').removeClass('spinner spinner-sm spinner-success spinner-center');
                        $('#icon-search').addClass('flaticon2-search-1');
                    });
                });
            },
            loadJS() {
                var vm = this;
                vm.$http({
                    url: '../front/blog/category',
                    method: 'GET',
                }).then((res) => {
                    vm.categories = res.data.data;
                    $('.category').select2({
                        placeholder: 'Pilih Kategori'
                    }).val(vm.category)
                    .on('change', function(v) {
                        vm.courses = [];
                        vm.category = $('.category').val();
                        vm.pageNow = 1;
                        vm.dataEmpty = false;
                        vm.getCourse();
                    });
                }).catch((error) => {
                    
                });
            },
            search: _.debounce(function() {
                this.courses = [];
                this.pageNow = 1;
                this.dataEmpty = false;
                this.getCourse();
            }, 500),
        },
        watch: {
            q: function() {
                $('#icon-search').removeClass('flaticon2-search-1');
                $('#icon-search').addClass('spinner spinner-sm spinner-success spinner-center');
            }
        },
        mounted() {
            this.loadJS();
            this.getCourse();
        }
    }
</script>