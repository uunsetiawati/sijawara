import VueRouter from 'vue-router'

import topbar from 'topbar';
topbar.config({
  autoRun      : true,
  barThickness : 3,
  barColors    : {
      '0'      : 'rgba(54,  153, 255, .9)',
      '.25'    : 'rgba(54,  153, 255, .9)',
      '.50'    : 'rgba(54,  153, 255, .9)',
      '.75'    : 'rgba(54,  153, 255, .9)',
      '1.0'    : 'rgba(54,  153, 255, .9)'
    },
    shadowBlur   : 10,
    shadowColor  : 'rgba(0,   0,   0,   .6)'
})
window.topbar = topbar;

// Routes
var $routes = [
    {
        name: 'home',
        path: '/landing',
        component: () => import(/* webpackChunkName: "home.landing" */ './pages/home/Index'),
        meta: {
            title: `Home`,
            auth: false
        }
    },
    {
        name: 'offline',
        path: '/landing/offline',
        component: () => import(/* webpackChunkName: "home.landing" */ './pages/kursusoffline/Index'),
        meta: {
            title: `Ofline`,
            auth: false
        }
    },
    {
        name: 'online',
        path: '/landing/online',
        component: () => import(/* webpackChunkName: "home.landing" */ './pages/kursusonline/Index'),
        meta: {
            title: `Online`,
            auth: false
        }
    },
    {
        name: 'blog',
        path: '/landing/berita',
        component: () => import(/* webpackChunkName: "berita" */ './pages/berita/Index'),
        meta: {
            title: `Berita`,
            auth: false
        }
    },
    {
        name: 'blog.detail',
        path: '/landing/berita/:slug',
        component: () => import(/* webpackChunkName: "berita" */ './pages/berita/Content'),
        meta: {
            title: `Berita`,
            auth: false
        }
    },
    {
        name: 'about',
        path: '/landing/about',
        component: () => import(/* webpackChunkName: "about.landing" */ './pages/about/Index'),
        meta: {
            title: `Tentang Kami`,
            auth: false
        }
    },
    {
        name: 'contact',
        path: '/landing/contact',
        component: () => import(/* webpackChunkName: "contact.landing" */ './pages/contact/Index'),
        meta: {
            title: `Hubungi Kami`,
            auth: false
        }
    },
    {
        name: 'jadwal',
        path: '/landing/events',
        component: () => import(/* webpackChunkName: "jadwal.landing" */ './pages/jadwal/Index'),
        meta: {
            title: `Webinar`,
            auth: false
        }
    },
    {
        name: 'team',
        path: '/landing/team',
        component: () => import(/* webpackChunkName: "team.landing" */ './pages/team/Index'),
        meta: {
            title: `Tim Kami`,
            auth: false
        }
    },
    {
        name: 'course.detail',
        path: '/landing/course/:uuid/detail',
        component: () => import(/* webpackChunkName: "course.detail.landing" */ './pages/detail/Course'),
        meta: {
            title: `Detail Kursus`,
        }
    },
    {
        name: 'course_other.detail',
        path: '/landing/course/other/:uuid/detail',
        component: () => import(/* webpackChunkName: "course_other.detail.landing" */ './pages/detail/CourseOther'),
        meta: {
            title: `Detail Kursus`,
        }
    },
];
// $routes = $routes.concat(User);

const notfound = [
    {
        name: 'notfound',
        path: '/*',
        component: () => import(/* webpackChunkName: "main.landing" */ './pages/error/NotFound'),
        meta: {
            title: `Halaman tidak ditemukan`,
            auth: undefined
        }
    },
    {
        name: 'notfound404',
        path: '/404',
        component: () => import(/* webpackChunkName: "main.landing" */ './pages/error/NotFound'),
        meta: {
            title: `Halaman tidak ditemukan`,
            auth: undefined
        }
    }
];

$routes = $routes.concat(notfound);

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: $routes,
});

router.beforeEach((to, from, next) => {
    var title = document.querySelector("meta[name='title']").getAttribute("content");
    document.title = to.meta.title + ' | ' + title;
    $("#script").empty();
    topbar.show();
    $(".header-menu-wrapper-overlay").remove();
    next()
});

router.afterEach(() => {
    topbar.hide()
    $(".header-menu-wrapper-overlay").remove();
})

export default router