import VueRouter from 'vue-router'
import Admin from './routes/Admin';
import User from './routes/User';

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
const routes = [
    {
        name: 'login',
        path: '/login',
        component: () => import(/* webpackChunkName: "auth" */ './pages/auth/Login'),
        meta: {
            title: `Login`,
            auth: false
        }
    },
    {
        name: 'register',
        path: '/register',
        component: () => import(/* webpackChunkName: "auth.register" */ './pages/auth/Register'),
        meta: {
            title: `Register`,
            auth: false
        }
    },
    {
        name: 'forgot',
        path: '/recover',
        component: () => import(/* webpackChunkName: "auth.recovery" */ './pages/auth/Forgot'),
        meta: {
            title: `Recovery`,
            auth: false
        }
    },
    {
        name: 'logout',
        path: '/logout',
        component: () => import(/* webpackChunkName: "auth" */ './pages/auth/Logout'),
        meta: {
            title: `Logout`,
            auth: true
        }
    },
    {
        name: 'home',
        path: '/',
        component: () => import(/* webpackChunkName: "main" */ './pages/auth/Redirect'),
        meta: {
            title: `Loading...`,
            auth: true
        }
    },
    {
        name: 'apiservice',
        path: '/apiservice',
        component: () => import(/* webpackChunkName: "apiservice.public" */ './pages/public/apiservice/Index'),
        meta: {
            title: `Api Service`,
            auth: undefined
        }
    },
    {
        name: 'change.password',
        path: '/user/changePassword',
        component: () => import(/* webpackChunkName: "auth.change.password" */ './pages/auth/ChangePassword'),
        meta: {
            title: `Change Password`,
            auth: true
        }
    },
    {
        name: 'update.profile',
        path: '/user/profile',
        component: () => import(/* webpackChunkName: "auth.update.profile" */ './pages/auth/UpdateProfile'),
        meta: {
            title: `Update Profile`,
            auth: true
        }
    },
    {
        name: 'callback.oauth',
        path: '/callback/oauth',
        component: () => import(/* webpackChunkName: "auth.google" */ './pages/auth/Oauth'),
        meta: {
            title: `Redirecting...`,
            auth: undefined
        }
    },
];
var $routes = routes.concat(Admin);
$routes = $routes.concat(User);

const notfound = [
    {
        name: 'notfound',
        path: '/*',
        component: () => import(/* webpackChunkName: "main" */ './pages/error/NotFound'),
        meta: {
            title: `Halaman tidak ditemukan`,
            auth: undefined
        }
    },
    {
        name: 'notfound404',
        path: '/404',
        component: () => import(/* webpackChunkName: "main" */ './pages/error/NotFound'),
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
    $(".aside-overlay").remove();
    $('#kt_aside').removeClass('aside-on');
    next()
});

router.afterEach(() => {
    topbar.hide()
    $(".aside-overlay").remove();
    $('#kt_aside').removeClass('aside-on');
})

export default router