<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown">
            <div v-if="showIndex" class="card card-custom">
                <div class="card-body">
                    <div class="mb-3 mt-3 row headerz">
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex">
                                <div class="symbol symbol-60 symbol-2by3 symbol-100 flex-shrink-0 mr-4">
                                    <div class="symbol-label" :style="`background-image: url(${course.image_url})`"></div>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="font-weight-bolder font-size-lg text-primary mb-1">{{ course.title }}</span>
                                    <span class="text-dark-50 font-weight-normal font-size-sm">{{ course.description.strip_tags().substring(0, 120) }}{{ ((course.description.strip_tags().length >= 60) ? '...' : '') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="font-weight-bolder font-size-lg text-primary mb-1">{{ ((course.is_online == '1') ? 'Online' : 'Offline') }}</span>
                                    <table>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder" style="width: 90px;">Tanggal</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ ((course.date_start==course.date_end) ? course.date_start.indo() : course.date_start.indo()+' - '+course.date_end.indo()) }}</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="font-weight-bolder">Waktu</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ course.time_start }} WIB - {{ course.time_end }} WIB</td>
                                        </tr>
                                        <tr v-if="course.is_online == '1'">
                                            <td valign="top" class="font-weight-bolder">Meeting ID</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ course.username }}</td>
                                        </tr>
                                        <tr v-if="course.is_online == '1'">
                                            <td valign="top" class="font-weight-bolder">Password</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ course.password }}</td>
                                        </tr>
                                        <tr v-if="course.is_online == '1'">
                                            <td valign="top" class="font-weight-bolder">Meeting URL</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest"><a :href="course.meeting_url" target="_blank">{{ course.meeting_url.substring(0, 45) }}....</a></td>
                                        </tr>
                                        <tr v-if="course.is_online == '0'">
                                            <td valign="top" class="font-weight-bolder">Tempat</td>
                                            <td valign="top"> : </td>
                                            <td valign="top" class="font-weight-boldest">{{ course.place }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <router-link :to="{name: 'admin.course.other.list'}" class="btn btn-sm btn-danger"><i class="fas fa-chevron-left"></i> KEMBALI</router-link>
                            <button class="btn btn-sm btn-success" id="exportButton" @click="getExcel"><i class="fas fa-file-excel"></i> LAPORAN</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/course/other/peserta" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="contentColumns" :post="{course: $route.params.uuid}" classHead="pt-2" :callback="loadTable"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style>
    .note-insert {
        display: none
    }
</style>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                contentColumns: [
                    {name: 'No.', data: 'angka', style: 'width: 55px;'},
                    {name: 'NIK', data: 'user.nik', style: 'width: 150px;'},
                    {name: 'Nama', data: 'user.name'},
                    {name: 'Jenis', data: 'user.jenis'},
                    {name: 'Jabatan', data: 'user.jabatan'},
                    // {name: 'Status', data: 'status', style: 'width: 120px;'},
                    // {name: 'Aksi', data: 'action', style: 'width: 250px;'}
                ],

                formRequest: {},
                course: {description: "", date_start: "2020-01-01", date_end: "2020-01-01", meeting_url: ""},

                moduleChecked: false,
                videoChecked: false,

                type: 'create',
                showIndex: true,
                showContent: false,
            }
        },
        methods: {
            loadTable() {
                var vm = this;

                $('#tableIndex').on('click', '.konfirm', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    KTApp.block(el)
                    Swal.fire({
                        title: 'Apakah Anda yakin akan verifikasi?',
                        showCancelButton: true,
                        icon: 'warning',
                        iconHtml: '?',
                        confirmButtonText: 'Ya',
                        showLoaderOnConfirm: true,
                        preConfirm: (login) => {
                            return vm.$http({
                                url: `/course/other/verif`,
                                method: 'POST',
                                data: {uuid: id}
                            }).then((res) => {                
                                return res.data.data
                            }).catch((error) => {
                                Swal.showValidationMessage(error.response.data.message)
                            });
                        },
                        allowOutsideClick: () => false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: result.value,
                            }).then((v) => {
                                KTApp.unblock(el)
                                vm.$refs.tableIndex.reload()
                            });
                        }
                    })
                });

                $('#tableIndex').on('click', '.reject', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    KTApp.block(el)
                    Swal.fire({
                        title: 'Apakah Anda yakin akan mengubah status [Kuota Habis]?',
                        showCancelButton: true,
                        icon: 'warning',
                        iconHtml: '?',
                        confirmButtonText: 'Ya',
                        showLoaderOnConfirm: true,
                        preConfirm: (login) => {
                            return vm.$http({
                                url: `/course/other/reject`,
                                method: 'POST',
                                data: {uuid: id}
                            }).then((res) => {                
                                return res.data.data
                            }).catch((error) => {
                                Swal.showValidationMessage(error.response.data.message)
                            });
                        },
                        allowOutsideClick: () => false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: result.value,
                            }).then((v) => {
                                KTApp.unblock(el)
                                vm.$refs.tableIndex.reload()
                            });
                        }
                    })
                });
            },
            getCourse() {
                var vm = this;
                KTApp.block($('.headerz'));
                vm.$http({
                    url: '/course/other/detail',
                    method: 'POST',
                    data: {course: vm.$route.params.uuid}
                }).then((res) => {
                    vm.course = res.data.data;
                    KTApp.unblock($('.headerz'));
                }).catch((error) => {
                    toastr.error(error.response.data.message)
                    KTApp.unblock($('.headerz'));
                    vm.$router.push({name: 'admin.course.other.list'});
                });
            },
            getExcel() {
                var vm = this;
                var url = '/export/offline_course_participants'
                if (vm.course.is_online == 1) {
                    url = '/export/online_course_participants'
                }

                KTApp.block($('#exportButton')[0]);
                vm.$http({
                    url: url,
                    method: 'POST',
                    data: {course: vm.$route.params.uuid},
                    responseType: 'arraybuffer'
                }).then((res) => {
                    var headers = res.headers;
                    var blob = new Blob([res.data], {type: headers['content-type']});
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = headers['content-disposition'].split('filename="')[1].split('"')[0];
                    link.click();
                    KTApp.unblock($('#exportButton')[0]);
                    toastr.success('Berhasil export excel!', 'Berhasil!');
                }).catch((error) => {
                    // var res = JSON.stringify(error.response.data);
                    KTApp.unblock($('#exportButton')[0]);
                    const res = JSON.parse(Buffer.from(error.response.data).toString('utf8'));
                    toastr.error(res.message, 'Gagal!');
                });
            }
        },
        mounted() {
            this.getCourse();
        }
    }
</script>