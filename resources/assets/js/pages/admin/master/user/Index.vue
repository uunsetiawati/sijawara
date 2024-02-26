<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown">
            <div v-if="showIndex" class="card card-custom">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <button @click="setShowContent" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/user/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="columns" classHead="pt-2" :callback="callback"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition enter-active-class="animated slideInUp">
            <div v-if="showContent" class="card card-custom">
                <!-- <form @submit.prevent="sendData" id="formRequest"> -->
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h3 class="card-label">
                            Detail User
                        </h3>
                        <div class="card-icon">
                            <span v-if="formRequest.active == '1'" class="label label-lg label-light-success label-inline">AKTIF</span>
                            <span v-else class="label label-lg label-light-danger label-inline">TIDAK AKTIF</span>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <button @click="setShowIndex" class="btn btn-sm btn-danger"><i class="fas fa-chevron-left"></i> KEMBALI</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>NIK</label>
                            <div class="form-control">{{ ((formRequest.nik) ? formRequest.nik : '-') }}</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Nama</label>
                            <div class="form-control">{{ formRequest.name }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Jenis Kelamin</label>
                            <div v-if="formRequest.active == '1'" class="form-control">{{ ((formRequest.gender == '1') ? 'Laki - Laki' : 'Perempuan' ) }}</div>
                            <div v-else class="form-control">-</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Tempat Lahir</label>
                            <div class="form-control">{{ ((formRequest.birth_place) ? formRequest.birth_place : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Tanggal Lahir</label>
                            <div class="form-control">{{ ((formRequest.birth_date) ? formRequest.birth_date : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Email</label>
                            <div class="form-control">{{ ((formRequest.email) ? formRequest.email : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>No. Whatsapp</label>
                            <div class="form-control">{{ ((formRequest.phone) ? formRequest.phone : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Level</label>
                            <div class="form-control">{{ formRequest.level.ucfirst() }}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Jabatan</label>
                            <div class="form-control">{{ ((formRequest.jabatan) ? formRequest.jabatan : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Nama Instansi/UKM/Koperasi</label>
                            <div class="form-control">{{ ((formRequest.instansi) ? formRequest.instansi : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Jenis</label>
                            <div class="form-control">{{ ((formRequest.jenis) ? formRequest.jenis : '-') }}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" readonly>{{ ((formRequest.address) ? formRequest.address : '-') }}</textarea>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Kab/Kota</label>
                            <div class="form-control">{{ ((formRequest.city) ? formRequest.city.nm_city : '-') }}</div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Provinsi</label>
                            <div class="form-control">{{ ((formRequest.province) ? formRequest.province.nm_province : '-') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                columns: [
                    {name: 'No', data: 'angka', style: 'width: 60px;'},
                    {name: 'NIK', data: 'nik', style: 'width: 150px;'},
                    {name: 'Nama', data: 'name'},
                    {name: 'Email', data: 'email'},
                    {name: 'Status', data: 'active'},
                    {name: 'Aksi', data: 'action'}
                ],

                formRequest: {level: ""},

                showIndex: true,
                showContent: false,
            }
        },
        methods: {
            loadJs(){
            },
            callback(){
                var vm = this;
                $('#tableIndex').on('click', '.detail', function(e){
                    var id = $(this).data('id');
                    vm.getUserDetail(id);
                });
            },
            getUserDetail(id) {
                var vm = this;
                vm.$http({
                    url: `/user/${id}/detail`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    vm.setShowContent();
                }).catch((error) => {
                    
                });
            },
            setShowIndex() {
                this.formRequest = {level: ""};
                this.showIndex = true;
                this.showContent = false;
            },
            setShowContent() {
                var vm = this;
                vm.showIndex = false;
                vm.showContent = true;
            },
        },
        mounted() {
            this.$parent.middleware('admin');
            this.loadJs()
        }
    }
</script>