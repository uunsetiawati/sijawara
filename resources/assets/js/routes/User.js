const User = [
    // START USER //
    {
        name: 'user',
        path: '/user',
        component: () => import(/* webpackChunkName: "user" */ '../pages/user/home/Index'),
        meta: {
            title: `Dashboard`,
            auth: true,
            breadcrumb: ['User',  'Dashboard']
        }
    },
    {
        name: 'user.ukm',
        path: '/user/ukm',
        component: () => import(/* webpackChunkName: "user.ukm" */ '../pages/user/ukm/Index'),
        meta: {
            title: `UKM`,
            auth: true,
            breadcrumb: ['User',  'UKM']
        }
    },
    {
        name: 'user.koperasi',
        path: '/user/koperasi',
        component: () => import(/* webpackChunkName: "user.koperasi" */ '../pages/user/koperasi/Index'),
        meta: {
            title: `Koperasi`,
            auth: true,
            breadcrumb: ['User',  'Koperasi']
        }
    },
        // COURSE //
    {
        name: 'user.course',
        path: '/user/course',
        component: () => import(/* webpackChunkName: "user.course.home" */ '../pages/user/course/home/Index'),
        meta: {
            title: `Course`,
            auth: true,
            breadcrumb: ['User', 'Course']
        }
    },
    {
        name: 'user.course.content',
        path: '/user/course/:uuid/content',
        component: () => import(/* webpackChunkName: "user.course.content" */ '../pages/user/course/content/Index'),
        meta: {
            title: `View Course`,
            auth: true,
            breadcrumb: ['User', 'Course', 'View']
        }
    },
    {
        name: 'user.course.other.offline',
        path: '/user/course/other/offline',
        component: () => import(/* webpackChunkName: "user.course.other.offline" */ '../pages/user/course_other/home/Offline'),
        meta: {
            title: `Course Offline`,
            auth: true,
            breadcrumb: ['User', 'Course', 'Offline']
        }
    },
    {
        name: 'user.course.other.online',
        path: '/user/course/other/online',
        component: () => import(/* webpackChunkName: "user.course.other.online" */ '../pages/user/course_other/home/Online'),
        meta: {
            title: `Course Online`,
            auth: true,
            breadcrumb: ['User', 'Course', 'Online']
        }
    },
    {
        name: 'user.course.other.content',
        path: '/user/course/other/:uuid/content',
        component: () => import(/* webpackChunkName: "user.course.other.content" */ '../pages/user/course_other/content/Index'),
        meta: {
            title: `View Course`,
            auth: true,
            breadcrumb: ['User', 'Course', 'View']
        }
    },
    // END USER //
];

export default User