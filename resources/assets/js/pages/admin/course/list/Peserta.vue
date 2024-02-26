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
                                    <span class="font-weight-bolder font-size-lg text-primary mb-1">{{ course.nm_course }}</span>
                                    <span class="text-dark-50 font-weight-normal font-size-sm">{{ course.overview.substring(0, 120) }}{{ ((course.overview.length >= 60) ? '...' : '') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <router-link :to="{name: 'admin.course.list'}" class="btn btn-sm btn-danger"><i class="fas fa-chevron-left"></i> KEMBALI</router-link>
                            <button class="btn btn-sm btn-success" id="exportButton" data-toggle="modal" data-target="#exampleModalLong"><i class="fas fa-file-excel"></i> LAPORAN</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/course/peserta" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="contentColumns" :post="{course: $route.params.uuid}" classHead="pt-2" :callback="loadTable"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Modal-->
        <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Laporan Data Peserta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="resetDate">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div class="">
                                <div class="input-daterange input-group" id="kt_datepicker_5" style="width: 100% !important;">
                                    <input id="startdate" type="text" class="form-control" name="start">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <!-- <i class="la la-ellipsis-h"></i> -->
                                            Sampai
                                        </span>
                                    </div>
                                    <input id="enddate" type="text" class="form-control" name="end">
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" @click="resetDate">Batal</button>
                        <button type="button" class="btn btn-primary font-weight-bold" @click="getExcel" >Download</button>
                    </div>
                </div>
            </div>
        </div>
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
                course: {overview: "", date_start: "2020-01-01", date_end: "2020-01-01", meeting_url: ""},
                reportdate: {
                    start: '',
                    end: '',
                },

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
            },
            getCourse() {
                var vm = this;
                KTApp.block($('.headerz'));
                vm.$http({
                    url: '/course/detail',
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
                var url = 

                KTApp.block($('#exportButton')[0]);
                vm.$http({
                    url: '/export/course_participants',
                    method: 'POST',
                    data: {
                        course: vm.$route.params.uuid,
                        start_date: vm.reportdate.start,
                        end_date: vm.reportdate.end,
                    },
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
                    $('#kt_datepicker_5').datepicker('clearDates');
                    $('#exampleModalLong').modal('toggle')
                }).catch((error) => {
                    // var res = JSON.stringify(error.response.data);
                    KTApp.unblock($('#exportButton')[0]);
                    const res = JSON.parse(Buffer.from(error.response.data).toString('utf8'));
                    toastr.error(res.message, 'Gagal!');
                });
            },
            rangeDate(){
                var vm = this;
                $('#kt_datepicker_5').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    templates: {
                       leftArrow: '<i class="la la-angle-right"></i>',
                       rightArrow: '<i class="la la-angle-left"></i>'
                    }
                })
                .on('change', function(v) {
                    vm.reportdate = {
                        start : $('#startdate').val(),
                        end : $('#enddate').val()
                    };
                });
            },
            resetDate(){
                $('#kt_datepicker_5').datepicker('clearDates');
                this.reportdate = {
                    start: '',
                    end: '',
                };
            }
        },
        mounted() {
            this.getCourse();
            this.rangeDate();
        }
    }
</script>