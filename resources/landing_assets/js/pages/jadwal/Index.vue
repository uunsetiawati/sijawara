<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('schedule.schedule') }}</h1>
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
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle btn-block" type="button" data-toggle="dropdown">{{ $t('schedule.category') }}
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu p-0">
                                        <li>
                                            <a class="text-sijawara p-5 bg-hover-dark-o-1" @click="setSelectedCategory(['all'])" href="javascript:;">{{ $t('schedule.all') }}</a>
                                        </li>
                                        <li v-for="item in menuItems" v-bind:class="{'dropdown-submenu': item.children}">
                                            <a class="text-sijawara opendrop1 p-5 bg-hover-dark-o-1 justify-content-between" href="javascript:;" @click="setSelectedCategory(item.filter)">{{ item.name }}<i class="flaticon2-right-arrow fa-1x" v-if="item.children"></i></a>
                                            <ul class="dropdown-menu p-0" v-if="item.children">
                                                <li v-for="child in item.children" v-bind:class="{'dropdown-submenu': item.children}">
                                                    <a class="text-sijawara opendrop2 p-5 bg-hover-dark-o-1 justify-content-between" href="javascript:;" @click="setSelectedCategory(child.filter)">{{ child.name }}<i class="flaticon2-right-arrow fa-1x" v-if="child.children"></i></a>
                                                    <ul class="dropdown-menu p-0" v-if="child.children">
                                                        <li v-for="childd in child.children" v-bind:class="{'dropdown-submenu': child.children}">
                                                            <a class="text-sijawara opendrop3 p-5 bg-hover-dark-o-1 justify-content-between" href="javascript:;" @click="setSelectedCategory(childd.filter)">{{ childd.name }}<i class="flaticon2-right-arrow fa-1x" v-if="childd.children"></i></a>
                                                            <ul class="dropdown-menu p-0" v-if="childd.children">
                                                                <li v-for="childdd in childd.children" v-bind:class="{'dropdown-submenu': childd.children}">
                                                                    <a class="text-sijawara p-5 bg-hover-dark-o-1" @click="setSelectedCategory(childdd.filter)" href="javascript:;">{{ childdd.name }}</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>  
                                    </ul>
                                </div>
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
                                        <img :src="course.image_url" class="rounded w-100">
                                    </div>
                                    <div class="col-md-9">
                                        <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" class=" font-size-h2 text-hover-info mb-4 mt-5 mt-md-0">{{ course.title }}</router-link>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><i class="fa fa-calendar-alt text-success"></i> {{ $t('schedule.date') }}: {{ course.date_start.indo() + ((course.date_start != course.date_end) ? ' - '+course.date_end.indo() : '') }}</h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4><i class="fa fa-clock text-success"></i> {{ $t('schedule.time') }}: {{ course.time_start }} - {{ course.time_end }} WIB</h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4><i class="fas fa-cogs text-success"></i> {{ $t('schedule.type') }}: {{ ((course.is_online == '1') ? 'Online' : 'Offline') }}</h4>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" v-if="course.sudah_terlaksana == 'N'" class="btn btn-sm btn-primary">{{ $t('schedule.not_implemented') }} <i class="fas fa-angle-right ml-1"></i></router-link>
                                                <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" v-if="course.sudah_terlaksana == 'Y'" class="btn btn-sm btn-danger">{{ $t('schedule.already_done') }} <i class="fas fa-angle-right ml-1"></i></router-link>
                                                <router-link :to="{name: 'course_other.detail', params: {uuid: course.uuid}}" v-if="course.sudah_terlaksana == 'X'" class="btn btn-sm btn-success">{{ $t('schedule.ongoing') }} <i class="fas fa-angle-right ml-1"></i></router-link>
                                            </div>
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

<style type="text/css">
    .l1 {
        padding-left: 1rem!important;
    }

    .l2 {
        padding-left: 2rem!important;
    }

    .l3 {
        padding-left: 3rem!important;
    }

    .l4 {
        padding-left: 4rem!important;
    }

    .dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
</style>

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
                q: '',
                menuItems: [
                    {
                        name: 'Online',
                        filter: ['online'],
                        children: [
                            {
                                name: 'Pelatihan', filter: ['online', 'pelatihan'], children: [
                                    {
                                        name: 'UKM', filter: ['online', 'pelatihan', 'ukm'], children: [
                                            {
                                                name: '2021', filter: ['online', 'pelatihan', 'ukm', '2021']
                                            },
                                            {
                                                name: '2020', filter: ['online', 'pelatihan', 'ukm', '2020']
                                            }
                                        ]
                                    },
                                    {
                                        name: 'Koperasi', filter: ['online', 'pelatihan', 'koperasi'], children: [
                                            {
                                                name: '2021', filter: ['online', 'pelatihan', 'koperasi', '2021']
                                            },
                                            {
                                                name: '2020', filter: ['online', 'pelatihan', 'koperasi', '2020']
                                            }
                                        ]
                                    },
                                ]
                            },
                            {
                                name: 'Konsultasi', filter: ['online', 'konsultasi']
                            },
                            {
                                name: 'Bimbingan', filter: ['online', 'bimbingan']
                            },
                            {
                                name: 'Kursil', filter: ['online', 'kursil']
                            },
                            {
                                name: 'Seminar/Webinar/Workshop', filter: ['online', 'seminar']
                            },
                        ]
                    },
                    {
                        name: 'Offline',
                        filter: ['offline'],
                        children: [
                            {
                                name: 'Pelatihan', filter: ['offline', 'pelatihan'], children: [
                                    {
                                        name: 'UKM', filter: ['offline', 'pelatihan', 'ukm'], children: [
                                            {
                                                name: '2021', filter: ['offline', 'pelatihan', 'ukm', '2021']
                                            },
                                            {
                                                name: '2020', filter: ['offline', 'pelatihan', 'ukm', '2020']
                                            }
                                        ]
                                    },
                                {
                                        name: 'Koperasi', filter: ['offline', 'pelatihan', 'koperasi'], children: [
                                            {
                                                name: '2021', filter: ['offline', 'pelatihan', 'koperasi', '2021']
                                            },
                                            {
                                                name: '2020', filter: ['offline', 'pelatihan', 'koperasi', '2020']
                                            }
                                        ]
                                    },
                                ]
                            },
                            {
                                name: 'Konsultasi', filter: ['offline', 'konsultasi']
                            },
                            {
                                name: 'Bimbingan', filter: ['offline', 'bimbingan']
                            },
                            {
                                name: 'Pendampingan', filter: ['offline', 'pendampingan']
                            },
                            {
                                name: 'Kursil', filter: ['offline', 'kursil']
                            },
                            {
                                name: 'Seminar/Webinar/Workshop', filter: ['offline', 'seminar']
                            },
                        ]
                    }
                ],
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
                    url: '../front/course/events/show?take=8&page='+vm.pageNow+'&type='+vm.category+'&q='+vm.q,
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
            setSelectedCategory(item) {
                var vm = this;
                vm.courses = [];
                vm.category = item;
                vm.pageNow = 1;
                vm.dataEmpty = false;
                vm.getCourse();
            },
            loadJS() {
                var vm = this;
                vm.$http({
                    url: '../front/course/events/category',
                    method: 'GET',
                }).then((res) => {
                    vm.categories = res.data.data;
                    $('.dropdown-toggle').on("click", function(e){

                        $('.dropdown-submenu a.opendrop1').each(function(i) {
                            $(this).next('ul').hide();
                        });
                    });

                    $('.dropdown-submenu a.opendrop1').on("mouseenter", function(e){

                        $('.dropdown-submenu a.opendrop1').each(function(i) {
                            $(this).next('ul').hide();
                        });

                        $('.dropdown-submenu a.opendrop2').each(function(i) {
                            $(this).next('ul').hide();
                        });
                        $(this).next('ul').show();
                        e.stopPropagation();
                        e.preventDefault();
                    });

                    $('.dropdown-submenu a.opendrop2').on("mouseenter", function(e){

                        $('.dropdown-submenu a.opendrop2').each(function(i) {
                            $(this).next('ul').hide();
                        });

                        $('.dropdown-submenu a.opendrop3').each(function(i) {
                            $(this).next('ul').hide();
                        });

                        $(this).next('ul').show();
                        e.stopPropagation();
                        e.preventDefault();
                    });

                    $('.dropdown-submenu a.opendrop3').on("mouseenter", function(e){

                        $('.dropdown-submenu a.opendrop3').each(function(i) {
                            $(this).next('ul').hide();
                        });
                        $(this).next('ul').show();
                        e.stopPropagation();
                        e.preventDefault();
                    });
                    // $('.dropdown-submenu a.opendrop').on("mouseleave", function(e){
                    //     $(this).next('ul').hide();
                    //     e.stopPropagation();
                    //     e.preventDefault();
                    // });
                    // $('.category').select2({
                    //     placeholder: 'Pilih Kategori',
                    // }).val(vm.category)
                    // .on('change', function(v) {
                    //     vm.courses = [];
                    //     vm.category = $('.category').val();
                    //     vm.pageNow = 1;
                    //     vm.dataEmpty = false;
                    //     vm.getCourse();
                    // });
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