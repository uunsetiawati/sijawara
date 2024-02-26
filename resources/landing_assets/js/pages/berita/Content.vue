<template>
    <div class="container">
        <!-- <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">Berita</h1>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card card-custom card-blog">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="text-sijawara font-size-h1 font-weight-bolder text-center">{{ blog.title }}</div>
                            </div>
                            <div class="col-md-12">
                                <img v-if="blog.image_url" :src="blog.image_url" :alt="blog.title" class="img-fluid rounded">
                            </div>
                            <div class="col-md-12">
                                {{ $t('news.date') }} : {{ blog.created_at.tgl_indo() }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $t('news.category') }} : <template v-for="(category, i) in blog.category">{{ category.category.nm_category }}{{ ((i != blog.category.length-1) ? ', ' : '') }}</template>
                            </div>
                            <div v-html="blog.content" class="font-size-lg mt-10"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-sticky-container>
                <div class="card card-custom sticky card-news" data-sticky="true" data-margin-top="140px" data-sticky-for="1023" data-sticky-class="sticky">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="socicon-buffer font-size-h4 text-center mb-4 pb-4 border-bottom"> {{ $t('news.latest_news') }}</div>
                            </div>
                            <template v-for="(blognew, i) in blogNews">
                                <div class="col-md-12 pb-4" :class="{'border-bottom': (blogNews.length-1) != i}">
                                    <router-link :to="{name: 'blog.detail', params: {slug: blognew.slug}}" :key="$route.fullPath" class="text-hover-info d-block text-sijawara">{{ blognew.title }}</router-link>
                                    {{ $t('news.date') }} : {{ blognew.created_at.tgl_indo() }}
                                </div>
                            </template>
                            <div class="col-md-12">
                                <router-link :to="{name: 'blog'}" class="btn btn-success btn-sm btn-block">{{ $t('news.view_all') }}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        data() {
            return {
                blog: {category: [], created_at: '2020-01-01 00:00:00'},
                blogNews: []
            }
        },
        methods: {
            getBlog() {
                var vm = this;
                vm.blog = {category: [], created_at: '2020-01-01 00:00:00'};
                setTimeout(() => {
                    KTApp.block(".card-blog", {message: 'Loading ...'})
                    vm.$http({
                        url: `../front/blog/${vm.$route.params.slug}`,
                        method: 'GET',
                    }).then((res) => {
                        vm.blog = res.data.data;
                        KTApp.unblock(".card-blog")
                        var title = document.querySelector("meta[name='title']").getAttribute("content");
                        document.title = vm.blog.title + ' | ' + vm.$route.meta.title + ' | ' + title;
                    }).catch((error) => {
                        KTApp.unblock(".card-blog")
                        toastr.error(error.response.data.message);
                        vm.$router.push({name: 'blog'});
                    });
                }, 100)
            },
            getBlogNews() {
                var vm = this;
                KTApp.block(".card-news", {message: 'Loading ...'})
                vm.$http({
                    url: `../front/blog/show?take=4&page=1&type=all`,
                    method: 'GET',
                }).then((res) => {
                    KTApp.unblock(".card-news")
                    vm.blogNews = res.data.data;
                    setTimeout(() => {
                        new Sticky('.card-news')
                    }, 100)
                }).catch((error) => {
                    KTApp.unblock(".card-news")
                    toastr.error(error.response.data.message);
                });
            },
        },
        watch:{
            '$route' (to) {
                if(to != this.blog.slug){
                    this.getBlog();
                }
            }
        },
        mounted() {
            this.getBlog();
            this.getBlogNews();
        }
    }
</script>