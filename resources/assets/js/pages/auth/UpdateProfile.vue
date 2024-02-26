<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <h3 class="card-label">
                                Update Profile
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="send">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>NIK</label>
                                            <input type="text" name="nik" placeholder="NIK" minlength="16" maxlength="16" v-model="$auth.user().nik" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" placeholder="Nama" v-model="$auth.user().name" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" placeholder="Phone" v-model="$auth.user().phone" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" placeholder="Email" v-model="$auth.user().email" class="form-control bg-gray-300" readonly>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Jenis Kelamin</label>
                                            <select class="form-control" name="gender" v-model="$auth.user().gender">
                                                <option value="1">Laki - Laki</option>
                                                <option value="0">Perempuan</option>
                                            </select>
                                            <!-- <input type="text" name="nama" placeholder="Jenis" v-model="$auth.user().name" class="form-control" readonly> -->
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="birth_place" placeholder="Tempat Lahir" v-model="$auth.user().birth_place" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="text" name="birth_date" placeholder="Tanggal Lahir" v-model="$auth.user().birth_date" class="form-control tgl_lahir" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Jenis</label>
                                            <select name="jenis" v-model="$auth.user().jenis" class="form-control" disabled>
                                                <option value="UKM">UKM</option>
                                                <option value="KOPERASI">KOPERASI</option>
                                                <option value="INSTANSI">INSTANSI</option>
                                                <option value="UMUM">UMUM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Nama Instansi/UKM/Koperasi</label>
                                            <input type="text" name="instansi" placeholder="Nama Instansi/UKM/Koperasi" v-model="$auth.user().instansi" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Jabatan</label>
                                            <input type="text" name="jabatan" placeholder="Jabatan" v-model="$auth.user().jabatan" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group mb-md-10">
                                            <label>Alamat</label>
                                            <textarea type="text" name="address" placeholder="Alamat" rows="5" v-model="$auth.user().address" class="form-control">{{ $auth.user().address }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Provinsi</label>
                                            <select name="province_id" v-model="$auth.user().province_id" class="form-control province">
                                                <template v-for="province in provinces">
                                                    <option :value="province.id">{{ province.nm_province }}</option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group" v-if="citys.length != 0">
                                            <label>Kab/Kota</label>
                                            <select name="city_id" v-model="$auth.user().city_id" class="form-control city">
                                                <template v-for="city in citys">
                                                    <option :value="city.id">{{ city.nm_city }}</option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group d-flex justify-content-end">
                                            <label></label>
                                            <button type="submit" class="btn btn-sm btn-primary mr-2">SIMPAN</button>
                                            <router-link :to="{name: 'home'}" class="btn btn-sm btn-danger">BATAL</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                formRequest: { ...this.$auth.user() },
                provinces: [],
                citys: [],
            }
        },
        methods: {
            loadTanggal() {
                var vm = this;
                setTimeout(function() {
                    $('.tgl_lahir').datepicker({
                        format: "yyyy-mm-dd",
                        language: "id"
                    })
                    .val(vm.$auth.user().birth_date)
                    .on('change', function(v) {
                        vm.$auth.user().birth_date = $('.tgl_lahir').val();
                    })
                });
            },
            getProvince() {
                var vm = this;
                vm.$http({
                    url: '/province/show',
                    method: 'GET'
                }).then((res) => {
                    vm.provinces = res.data.data;
                    $('.province').select2({
                        placeholder: 'Pilih Provinsi'
                    })
                    .val(vm.$auth.user().province_id)
                    .on('change', function(v) {
                        vm.$auth.user().province_id = $('.province').val()
                        vm.citys = [];
                        vm.$auth.user().city_id = null;
                        vm.getCity(vm.$auth.user().province_id)
                    });
                    KTApp.unblock($('.select2-container'));
                    if(vm.$auth.user().province_id) {
                        vm.getCity(vm.$auth.user().province_id);
                    }
                }).catch((error) => {
                    KTApp.unblock($('.select2-container'));
                    toastr.error(error.response.data.message);
                });
            },
            getCity(id) {
                var vm = this;
                KTApp.block($('.select2-container'));
                vm.$http({
                    url: '/city/show?province_id='+id,
                    method: 'GET'
                }).then((res) => {
                    KTApp.unblock($('.select2-container'));
                    vm.citys = res.data.data;
                    setTimeout(function() {
                        $('.city').select2({
                            placeholder: 'Pilih Kabupaten/Kota'
                        })
                        .val(vm.$auth.user().city_id)
                        .on('change', function(v) {
                            vm.$auth.user().city_id = $('.city').val()
                        });
                    },100);
                }).catch((error) => {
                    KTApp.unblock($('.select2-container'));
                    toastr.error(error.response.data.message);
                });
            },
            send() {
                var vm = this;
                KTApp.block($('.card-body'));

                var formData = {};
                formData.address = vm.$auth.user().address;
                formData.birth_date = vm.$auth.user().birth_date;
                formData.birth_place = vm.$auth.user().birth_place;
                formData.city_id = vm.$auth.user().city_id;
                formData.gender = vm.$auth.user().gender;
                formData.instansi = vm.$auth.user().instansi;
                formData.jabatan = vm.$auth.user().jabatan;
                formData.nik = vm.$auth.user().nik;
                formData.name = vm.$auth.user().name;
                formData.province_id = vm.$auth.user().province_id;
                formData.uuid = vm.$auth.user().uuid;
                formData.phone = vm.$auth.user().phone;

                vm.$http({
                    url: '/user/updateProfile',
                    method: 'POST',
                    data: formData
                }).then((res) => {
                    KTApp.unblock($('.card-body'));
                    vm.formRequest = {}
                    toastr.success(res.data.data);
                }).catch((error) => {
                    KTApp.unblock($('.card-body'));
                    toastr.error(error.response.data.message);
                });
            }
        },
        mounted() {
            this.loadTanggal();
            this.getProvince();
        }
    }
</script>