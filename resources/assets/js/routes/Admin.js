const Admin = [
    // START ADMIN //
    {
        name: 'admin',
        path: '/admin',
        component: () => import(/* webpackChunkName: "admin" */ '../pages/admin/home/Index'),
        meta: {
            title: `Dashboard`,
            auth: true,
            breadcrumb: ['Admin',  'Dashboard']
        }
    },
    {
        name: 'admin.setting',
        path: '/admin/setting',
        component: () => import(/* webpackChunkName: "admin.setting" */ '../pages/admin/setting/Index'),
        meta: {
            title: `Setting`,
            auth: true,
            breadcrumb: ['Admin', 'Setting']
        }
    },
        // BLOG //
    {
        name: 'admin.blog',
        path: '/admin/blog',
        component: () => import(/* webpackChunkName: "admin.blog" */ '../pages/admin/blog/Index'),
        meta: {
            title: `Berita`,
            auth: true,
            breadcrumb: ['Admin', 'Berita']
        }
    },
    {
        name: 'admin.blog.category',
        path: '/admin/blog/category',
        component: () => import(/* webpackChunkName: "admin.blog.category" */ '../pages/admin/blog/category/Index'),
        meta: {
            title: `Kategori Berita`,
            auth: true,
            breadcrumb: ['Admin', 'Kategori Berita']
        }
    },
        // END BLOG //
        // COURSE //
    {
        name: 'admin.course',
        path: '/admin/course',
        component: () => import(/* webpackChunkName: "admin.course.home" */ '../pages/admin/course/home/Index'),
        meta: {
            title: `Course`,
            auth: true,
            breadcrumb: ['Admin', 'Course']
        }
    },
    {
        name: 'admin.course.content',
        path: '/admin/course/:uuid/content',
        component: () => import(/* webpackChunkName: "admin.course.content" */ '../pages/admin/course/content/Index'),
        meta: {
            title: `View Course`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'View']
        }
    },
    {
        name: 'admin.course.list',
        path: '/admin/course/list',
        component: () => import(/* webpackChunkName: "admin.course.list" */ '../pages/admin/course/list/Index'),
        meta: {
            title: `Course List`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'List']
        }
    },
    {
        name: 'admin.course.list.content',
        path: '/admin/course/list/:uuid/content',
        component: () => import(/* webpackChunkName: "admin.course.list.content" */ '../pages/admin/course/list/Content'),
        meta: {
            title: `Content List`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'Content', 'List']
        }
    },
    {
        name: 'admin.course.list.peserta',
        path: '/admin/course/list/:uuid/peserta',
        component: () => import(/* webpackChunkName: "admin.course.list.peserta" */ '../pages/admin/course/list/Peserta'),
        meta: {
            title: `Peserta`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'Peserta']
        }
    },
    {
        name: 'admin.course.other.list',
        path: '/admin/course/other/list',
        component: () => import(/* webpackChunkName: "admin.course.other.list" */ '../pages/admin/course_other/Index'),
        meta: {
            title: `Course Other List`,
            auth: true,
            breadcrumb: ['Admin', 'Course Other', 'List']
        }
    },
    {
        name: 'admin.course.other.peserta',
        path: '/admin/course/other/:uuid/peserta',
        component: () => import(/* webpackChunkName: "admin.course.other.peserta" */ '../pages/admin/course_other/Peserta'),
        meta: {
            title: `Peserta`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'Peserta']
        }
    },
    {
        name: 'admin.course.category',
        path: '/admin/course/category',
        component: () => import(/* webpackChunkName: "admin.course.category" */ '../pages/admin/course/category/Index'),
        meta: {
            title: `Course Category`,
            auth: true,
            breadcrumb: ['Admin', 'Course', 'Category']
        }
    },
        // END COURSE //

        // REPORT //
    {
        name: 'admin.report.course',
        path: '/admin/report/course',
        component: () => import(/* webpackChunkName: "admin.report.course" */ '../pages/admin/report/course/Index'),
        meta: {
            title: `Laporan Kursus`,
            auth: true,
            breadcrumb: ['Admin', 'Report', 'Course']
        }
    },
    {
        name: 'admin.report.peserta',
        path: '/admin/report/peserta',
        component: () => import(/* webpackChunkName: "admin.report.peserta" */ '../pages/admin/report/peserta/Index'),
        meta: {
            title: `Laporan Peserta`,
            auth: true,
            breadcrumb: ['Admin', 'Report', 'Peserta']
        }
    },
        // END REPORT //

        // MASTER
            // KOPERASI
    {
        name: 'admin.master.koperasi.bentuk_koperasi',
        path: '/master/koperasi/bentuk_koperasi',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.bentuk_koperasi" */ '../pages/admin/master/koperasi/bentuk_koperasi/Index'),
        meta: {
            title: `Bentuk Koperasi`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Koperasi', 'Bentuk Koperasi']
        }
    },
    {
        name: 'admin.master.koperasi.jenis_koperasi',
        path: '/master/koperasi/jenis_koperasi',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.jenis_koperasi" */ '../pages/admin/master/koperasi/jenis_koperasi/Index'),
        meta: {
            title: `Jenis Koperasi`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Koperasi', 'Jenis Koperasi']
        }
    },
    {
        name: 'admin.master.koperasi.kelompok_koperasi',
        path: '/master/koperasi/kelompok_koperasi',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.kelompok_koperasi" */ '../pages/admin/master/koperasi/kelompok_koperasi/Index'),
        meta: {
            title: `Kelompok Koperasi`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Koperasi', 'Kelompok Koperasi']
        }
    },
    {
        name: 'admin.master.koperasi.masalah_koperasi',
        path: '/master/koperasi/masalah_koperasi',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.masalah_koperasi" */ '../pages/admin/master/koperasi/masalah_koperasi/Index'),
        meta: {
            title: `Masalah Koperasi`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Koperasi', 'Masalah Koperasi']
        }
    },
    {
        name: 'admin.master.koperasi.sektor_usaha',
        path: '/master/koperasi/sektor_usaha',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.sektor_usaha" */ '../pages/admin/master/koperasi/sektor_usaha/Index'),
        meta: {
            title: `Sektor Usaha`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Koperasi', 'Sektor Usaha']
        }
    },
    {
        name: 'admin.master.koperasi.data_koperasi',
        path: '/master/koperasi/data_koperasi',
        component: () => import(/* webpackChunkName: "admin.master.koperasi.data_koperasi" */ '../pages/admin/master/koperasi/data_koperasi/Index'),
        meta: {
            title: `Laporan Data Koperasi`,
            auth: true,
            breadcrumb: ['Admin', 'Laporan', 'Data Koperasi']
        }
    },
        // END KOPERASI
        // UKM
    {
        name: 'admin.master.ukm.badan_usaha',
        path: '/master/ukm/badan_usaha',
        component: () => import(/* webpackChunkName: "admin.master.ukm.badan_usaha" */ '../pages/admin/master/ukm/badan_usaha/Index'),
        meta: {
            title: `Badan Usaha`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Badan Usaha']
        }
    },
    {
        name: 'admin.master.ukm.jabatan',
        path: '/master/ukm/jabatan',
        component: () => import(/* webpackChunkName: "admin.master.ukm.jabatan" */ '../pages/admin/master/ukm/jabatan/Index'),
        meta: {
            title: `Jabatan UKM`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Jabatan UKM']
        }
    },
    {
        name: 'admin.master.ukm.kategori',
        path: '/master/ukm/kategori',
        component: () => import(/* webpackChunkName: "admin.master.ukm.kategori" */ '../pages/admin/master/ukm/kategori/Index'),
        meta: {
            title: `Kategori UKM`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Kategori UKM']
        }
    },
    {
        name: 'admin.master.ukm.bahan_baku',
        path: '/master/ukm/bahan_baku',
        component: () => import(/* webpackChunkName: "admin.master.ukm.bahan_baku" */ '../pages/admin/master/ukm/bahan_baku/Index'),
        meta: {
            title: `Sumber Bahan Baku`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Sumber Bahan Baku']
        }
    },
    {
        name: 'admin.master.ukm.legalitas_usaha',
        path: '/master/ukm/legalitas_usaha',
        component: () => import(/* webpackChunkName: "admin.master.ukm.legalitas_usaha" */ '../pages/admin/master/ukm/legalitas_usaha/Index'),
        meta: {
            title: `Legalitas Usaha`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Legalitas Usaha']
        }
    },
    {
        name: 'admin.master.ukm.standarisasi_produk',
        path: '/master/ukm/standarisasi_produk',
        component: () => import(/* webpackChunkName: "admin.master.ukm.standarisasi_produk" */ '../pages/admin/master/ukm/standarisasi_produk/Index'),
        meta: {
            title: `Standarisasi Produk`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Standarisasi Produk']
        }
    },
    {
        name: 'admin.master.ukm.wilayah_pemasaran',
        path: '/master/ukm/wilayah_pemasaran',
        component: () => import(/* webpackChunkName: "admin.master.ukm.wilayah_pemasaran" */ '../pages/admin/master/ukm/wilayah_pemasaran/Index'),
        meta: {
            title: `Wilayah Pemasaran`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Wilayah Pemasaran']
        }
    },
    {
        name: 'admin.master.ukm.fas_keg_pernah',
        path: '/master/ukm/fas_keg_pernah',
        component: () => import(/* webpackChunkName: "admin.master.ukm.fas_keg_pernah" */ '../pages/admin/master/ukm/fas_keg_pernah/Index'),
        meta: {
            title: `Fasilitas Kegiatan Yang Penah Diikuti`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Fasilitas Kegiatan Yang Penah Diikuti']
        }
    },
    {
        name: 'admin.master.ukm.masalah_ukm',
        path: '/master/ukm/masalah_ukm',
        component: () => import(/* webpackChunkName: "admin.master.ukm.masalah_ukm" */ '../pages/admin/master/ukm/masalah_ukm/Index'),
        meta: {
            title: `Permasalahan UKM`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'UKM', 'Permasalahan UKM']
        }
    },
    {
        name: 'admin.master.ukm.data_ukm',
        path: '/master/ukm/data_ukm',
        component: () => import(/* webpackChunkName: "admin.master.ukm.data_ukm" */ '../pages/admin/master/ukm/data_ukm/Index'),
        meta: {
            title: `Laporan Data UKM`,
            auth: true,
            breadcrumb: ['Admin', 'Laporan', 'Data UKM']
        }
    },
        // END UKM
    {
        name: 'admin.master.user',
        path: '/master/user',
        component: () => import(/* webpackChunkName: "admin.master.user" */ '../pages/admin/master/user/Index'),
        meta: {
            title: `Pengguna`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Pengguna']
        }
    },
    {
        name: 'admin.front.slider',
        path: '/front/slider',
        component: () => import(/* webpackChunkName: "admin.front.slider" */ '../pages/admin/front/slider/Index'),
        meta: {
            title: `Slider`,
            auth: true,
            breadcrumb: ['Admin', 'Front', 'Slider']
        }
    },
    {
        name: 'admin.front.pengumuman',
        path: '/front/pengumuman',
        component: () => import(/* webpackChunkName: "admin.front.pengumuman" */ '../pages/admin/front/pengumuman/Index'),
        meta: {
            title: `Pengumuman`,
            auth: true,
            breadcrumb: ['Admin', 'Front', 'Pengumuman']
        }
    },
    {
        name: 'admin.master.wilayah',
        path: '/master/wilayah',
        component: () => import(/* webpackChunkName: "wilayah" */ '../pages/admin/master/wilayah/Index'),
        meta: {
            title: `Master Wilayah`,
            auth: true,
            breadcrumb: ['Master',  'Wilayah']
        },
        children: [
            {
                name: 'admin.master.wilayah.province',
                path: '/master/wilayah/province',
                component: () => import(/* webpackChunkName: "wilayah" */ '../pages/admin/master/wilayah/province/Index'),
                meta: {
                    title: `Provinsi`,
                    auth: true,
                    breadcrumb: ['Master',  'Wilayah', 'Provinsi']
                }
            },
            {
                name: 'admin.master.wilayah.city',
                path: '/master/wilayah/city',
                component: () => import(/* webpackChunkName: "wilayah" */ '../pages/admin/master/wilayah/city/Index'),
                meta: {
                    title: `Kabupaten/Kota`,
                    auth: true,
                    breadcrumb: ['Master',  'Wilayah', 'Kabupaten/Kota']
                }
            }
        ]
    },
    {
        name: 'admin.master.widyaiswara',
        path: '/master/widyaiswara',
        component: () => import(/* webpackChunkName: "admin.master.widyaiswara" */ '../pages/admin/master/widyaiswara/Index'),
        meta: {
            title: `Widyaiswara`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Widyaiswara']
        }
    },
    {
        name: 'admin.master.notifikasi',
        path: '/master/notifikasi',
        component: () => import(/* webpackChunkName: "admin.master.notifikasi" */ '../pages/admin/master/notifikasi/Index'),
        meta: {
            title: `Notifikasi`,
            auth: true,
            breadcrumb: ['Admin', 'Master', 'Notifikasi']
        }
    },
        // END MASTER
    // END ADMIN //
];

export default Admin