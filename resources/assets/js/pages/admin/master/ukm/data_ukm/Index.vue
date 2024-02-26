<template>
    <div class="container">
        <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
            <div class="card card-custom" v-if="showContent">
                <div class="card-header">
                    <h3 class="card-title mb-0">Detail UKM</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary ali" @click="setShowTable">Kembali</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!--begin: Wizard-->
                    <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
                        <!--begin: Wizard Nav-->
                        <div class="wizard-nav">
                            <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
                                <!--begin::Wizard Step 1 Nav-->
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>1.</span>Data Pemilik</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 1 Nav-->
                                <!--begin::Wizard Step 2 Nav-->
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>2.</span>Data UKM</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 2 Nav-->
                                <!--begin::Wizard Step 3 Nav-->
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>3.</span>Data Lain Lain</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 3 Nav-->
                                <!--begin::Wizard Step 4 Nav-->
                                <!-- <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>4.</span>Delivery Address</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div> -->
                                <!--end::Wizard Step 4 Nav-->
                            </div>
                        </div>
                        <!--end: Wizard Nav-->
                        <!--begin: Wizard Body-->
                        <div class="justify-content-center mt-0 pt-0 px-8 px-lg-10 row mb-10">
                            <div class="col-md-12">
                                <!--begin: Wizard Form-->
                                <form class="form" id="kt_form">
                                    <!--begin: Wizard Step 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h4 class="mb-0 font-weight-bold text-dark">Data Pemilik</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NAMA PEMILIK</label>
                                                    <input readonly type="text" class="form-control" name="nm_pemilik" v-model="formRequest.nm_pemilik" placeholder="Nama Pemilik"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. NIK (Pemilik / Ketua Kelompok UKM)</label>
                                                    <input readonly type="text" class="form-control" name="nik" v-model="formRequest.nik" placeholder="3578XXXXXXXXXXXX" minlength="16" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO TELP/HP (Pemilik / Ketua Kelompok UKM)</label>
                                                    <input readonly type="text" class="form-control" name="phone" v-model="formRequest.phone" placeholder="08XXXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>JENIS KELAMIN (Pemilik / Ketua Kelompok UKM)</label>
                                                    <select disabled name="jenis_kelamin_pemilik" v-model="formRequest.jenis_kelamin_pemilik" class="form-control">
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="L">Laki - Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>TEMPAT LAHIR (Pemilik / Ketua Kelompok UKM)</label>
                                                    <input readonly type="text" class="form-control" name="tempat_lahir_pemilik" v-model="formRequest.tempat_lahir_pemilik" placeholder="Tempat Lahir" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>TANGGAL LAHIR (Pemilik / Ketua Kelompok UKM)</label>
                                                    <input readonly type="text" readonly disabled class="tanggal_lahir_pemilik form-control" name="tanggal_lahir_pemilik" v-model="formRequest.tanggal_lahir_pemilik" placeholder="Tanggal Lahir" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>PENDIDIKAN TERAKHIR (Pemilik / Ketua Kelompok UKM)</label>
                                                    <input readonly type="text" class="form-control" name="pendidikan_terakhir_pemilik" v-model="formRequest.pendidikan_terakhir_pemilik" placeholder="Pendidikan Terakhir"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>ALAMAT (Pemilik / Ketua Kelompok UKM)</label>
                                                    <textarea readonly type="text" class="form-control" name="alamat_pemilik" v-model="formRequest.alamat_pemilik" placeholder="Alamat Pemilik" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 1-->
                                    <!--begin: Wizard Step 2-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-0 font-weight-bold text-dark">Data UKM</h4><hr>
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NAMA UKM</label>
                                                    <input readonly type="text" class="form-control" name="nm_ukm" v-model="formRequest.nm_ukm" placeholder="Nama UKM"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>KEGIATAN USAHA YANG DILAKUKAN</label>
                                                    <input readonly type="text" class="form-control" name="kegiatan_usaha" v-model="formRequest.kegiatan_usaha" placeholder="Kegiatan Usaha Yang Dilakukan"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>PRODUK YANG DIHASILKAN</label>
                                                    <input readonly type="text" class="form-control" name="produk_dihasilkan" v-model="formRequest.produk_dihasilkan" placeholder="Produk Yang Dihasilkan"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>KATEGORI JENIS PRODUK</label>
                                                    <select disabled name="kategori_ukm_id" v-model="formRequest.kategori_ukm_id" class="kategori_ukm form-control">
                                                        <option v-for="kategori_ukm in kategori_ukms" :value="kategori_ukm.id">{{ kategori_ukm.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>TAHUN MEMULAI USAHA</label>
                                                    <input readonly type="text" class="form-control" name="tahun_mulai" v-model="formRequest.tahun_mulai" placeholder="Tahun Memulai Usaha" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>KAPASITAS PRODUKSI PERBULAN</label>
                                                    <div class="input-icon">
                                                        <input readonly type="text" class="form-control" name="kapasitas_produksi" v-model="formRequest.kapasitas_produksi" placeholder="Kapasitas Produksi" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                        <span>Pcs.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>VOLUME USAHA PERBULAN (OMZET)</label>
                                                    <div class="input-icon">
                                                    <input readonly type="text" class="form-control" name="volume_usaha" v-model="formRequest.volume_usaha" placeholder="Volume Usaha" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                    <span>Rp.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>JUMLAH TENAGA KERJA LAKI-LAKI</label>
                                                    <input readonly type="text" class="form-control" name="tenaga_pria" v-model="formRequest.tenaga_pria" placeholder="Tenaga Pria" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>JUMLAH TENAGA KERJA PEREMPUAN</label>
                                                    <input readonly type="text" class="form-control" name="tenaga_wanita" v-model="formRequest.tenaga_wanita" placeholder="Tenaga Wanita" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>BENTUK BADAN USAHA</label>
                                                    <select disabled name="badan_usaha_id" v-model="formRequest.badan_usaha_id" class="badan_usaha form-control">
                                                        <option v-for="badan_usaha in badan_usahas" :value="badan_usaha.id">{{ badan_usaha.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>NPWP</label>
                                                    <select disabled name="npwp" v-model="formRequest.npwp" class="form-control">
                                                        <option value="">Pilih</option>
                                                        <option value="1">ADA</option>
                                                        <option value="0">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>LOKASI PEMASARAN</label>
                                                    <input readonly type="text" class="form-control" name="lokasi_pemasaran" v-model="formRequest.lokasi_pemasaran" placeholder="Lokasi Pemasaran"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>NILAI REALISASI (KREDIT/PINJAMAN)</label>
                                                    <div class="input-icon">
                                                    <input readonly type="text" class="form-control" name="nilai_realisasi" v-model="formRequest.nilai_realisasi" placeholder="Nilai Realisasi" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                    <span>Rp.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>TAHUN REALISASI PINJAMAN</label>
                                                    <input readonly type="text" class="form-control" name="tahun_realisasi" v-model="formRequest.tahun_realisasi" placeholder="Tahun Realisasi" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>ALAMAT Usaha</label>
                                                    <textarea disabled type="text" class="form-control" name="alamat_ukm" v-model="formRequest.alamat_ukm" placeholder="Alamat UKM" rows="6"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select disabled name="province_id" v-model="formRequest.province_id" class="province form-control">
                                                                <option v-for="province in provinces" :value="province.id">{{ province.nm_province }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div v-if="cities.length != 0" class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Kabupaten/Kota</label>
                                                            <select disabled name="city_id" v-model="formRequest.city_id" class="city form-control">
                                                                <option v-for="city in cities" :value="city.id">{{ city.nm_city }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 2-->
                                    <!--begin: Wizard Step 3-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-0 font-weight-bold text-dark">Data Lain - Lain</h4><hr>
                                        
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>SUMBER BAHAN BAKU</label>
                                                    <select disabled name="bahan_baku" multiple="multiple" v-model="formRequest.bahan_baku" class="bahan_baku form-control">
                                                        <option v-for="bahan_baku in bahan_bakus" :value="bahan_baku.id">{{ bahan_baku.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>LEGALITAS USAHA YANG DIMILIKI</label>
                                                    <select disabled name="legalitas_usaha" multiple="multiple" v-model="formRequest.legalitas_usaha" class="legalitas_usaha form-control">
                                                        <option v-for="legalitas_usaha in legalitas_usahas" :value="legalitas_usaha.id">{{ legalitas_usaha.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>WILAYAH PEMASARAN</label>
                                                    <select disabled name="wilayah_pemasaran" multiple="multiple" v-model="formRequest.wilayah_pemasaran" class="wilayah_pemasaran form-control">
                                                        <option v-for="wilayah_pemasaran in wilayah_pemasarans" :value="wilayah_pemasaran.id">{{ wilayah_pemasaran.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>STANDARISASI PRODUK</label>
                                                    <select disabled name="standarisasi_produk" multiple="multiple" v-model="formRequest.standarisasi_produk" class="standarisasi_produk form-control">
                                                        <option v-for="standarisasi_produk in legalitas_usahas" :value="standarisasi_produk.id">{{ standarisasi_produk.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>FASILITAS/KEGIATAN YANG PERNAH DIIKUTI</label>
                                                    <select disabled name="fas_keg_pernah" multiple="multiple" v-model="formRequest.fas_keg_pernah" class="fas_keg_pernah form-control">
                                                        <option v-for="fas_keg_pernah in wilayah_pemasarans" :value="fas_keg_pernah.id">{{ fas_keg_pernah.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>PERMASALAHAN DALAM PENGEMBANGAN USAHA</label>
                                                    <select disabled name="masalah_ukm" multiple="multiple" v-model="formRequest.masalah_ukm" class="masalah_ukm form-control">
                                                        <option v-for="masalah_ukm in legalitas_usahas" :value="masalah_ukm.id">{{ masalah_ukm.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                                        </div>
                                    </div>
                                    <!--end: Wizard Actions-->
                                </form>
                                <!--end: Wizard Form-->
                            </div>
                        </div>
                        <!--end: Wizard Body-->
                    </div>
                    <!--end: Wizard-->
                </div>
            </div>
        </transition>
        <div class="card card-custom" v-if="!showContent">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="fas fa-file-excel"></i> Cetak Laporan</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <mti-paginate url="/ukm/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="ukmColumns" classHead="pt-2" :callback="loadTable"></mti-paginate>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal-->
        <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Laporan Data Ukm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="year=''">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" readonly required class="tahun_ukm form-control" name="tahun_ukm" v-model="year" placeholder="Pilih Tahun" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" @click="year=''">Batal</button>
                        <button type="button" class="btn btn-primary font-weight-bold" @click="reportUkm" >Download</button>
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
                ukmColumns : [
                    {name: '#', data: 'angka', style: 'width: 50px;'},
                    {name: 'Nik', data: 'nik'},
                    {name: 'Pemilik', data: 'nm_pemilik'},
                    {name: 'Ukm', data: 'nm_ukm'},
                    {name: 'Telepon', data: 'phone'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],
                showContent: false,

                formRequest: {kategori_ukm_id: null, badan_usaha_id: null, npwp: "", jenis_kelamin_pemilik: "", bahan_baku: [], legalitas_usaha: [], wilayah_pemasaran: [], standarisasi_produk: [], fas_keg_pernah: [], masalah_ukm: []},
                kategori_ukms: [],
                badan_usahas: [],
                provinces: [],
                cities: [],
                ////////////
                bahan_bakus: [],
                legalitas_usahas: [],
                wilayah_pemasarans: [],
                standarisasi_produks: [],
                fas_keg_pernahs: [],
                masalah_ukms: [],
                year: '',
            }
        },
        methods: {
            loadTable() {
                var vm = this;
                $('#tableIndex').on('click', '.detail', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    vm.getUkm(id, el);
                });

            },
            getUkm(id, el) {
                var vm = this;
                KTApp.block(el);
                vm.$http({
                    url: `/ukm/${id}/edit`,
                    method: 'GET',
                }).then((res) => {
                    KTUtil.scrollTop();
                    KTApp.unblock(el);
                    vm.formRequest = res.data.data.data;
                    vm.setShowDetail()
                    vm.loadWizard()
                    setTimeout(function() {
                        jQuery(document).ready(function () {
                            window.KTWizard3.init();
                            $('.tanggal_lahir_pemilik').datepicker({
                                format: "yyyy-mm-dd",
                                language: "id"
                            })
                            .val(vm.formRequest.tanggal_lahir_pemilik)
                            .on('change', function(v) {
                                vm.formRequest.tanggal_lahir_pemilik = $(this).val();
                            });
                        });
                    }, 100)
                }).catch((error) => {
                    KTApp.unblock(el);
                    toastr.error(error.response.data.message);
                });
            },
            setShowDetail() {
                this.showContent = true;
            },
            setShowTable() {
                this.showContent = false;
            },
            loadWizard() {
                var vm = this;
                "use strict";
                var KTWizard3 = (function () {
                    var e,
                        t,
                        i,
                        a = [];
                    return {
                        init: function () {
                            (e = KTUtil.getById("kt_wizard_v3")),
                                (t = KTUtil.getById("kt_form")),
                                (i = new KTWizard(e, { startStep: 1, clickableSteps: !0 })).on("beforeNext", function (e) {
                                    i.stop(),
                                    a[e.getStep() - 1].validate().then(function (e) {
                                        // SKIP VALIDATION
                                        (i.goNext(), KTUtil.scrollTop())
                                        if(i.getStep() == 2) {
                                            vm.getKategoriUkm()
                                            vm.getBadanUsaha()
                                            vm.getProvince()
                                        }else if(i.getStep() == 3) {
                                            vm.getBahanBaku()
                                            vm.getLegalitasUsaha()
                                            vm.getWilayahPemasaran()
                                            vm.getStandarisasiProduk()
                                            vm.getFasKegPernah()
                                            vm.getMasalahUkm()
                                        }
                                        return;
                                        // END SKIP
                                    });
                                }),
                                i.on("change", function (e) {
                                    KTUtil.scrollTop();
                                }),
                                a.push(
                                    FormValidation.formValidation(t, {
                                    })
                                ),
                                a.push(
                                    FormValidation.formValidation(t, {
                                    })
                                ),
                                a.push(
                                    FormValidation.formValidation(t, {
                                    })
                                ),
                                a.push(
                                    FormValidation.formValidation(t, {
                                    })
                                ),
                                window.KTW3 = i;
                        },
                    };
                })();
                window.KTWizard3 = KTWizard3;
            },
            getKategoriUkm() {
                var vm = this;
                vm.$http({
                    url: '/kategori_ukm/show',
                    method: 'GET',
                }).then((res) => {
                    vm.kategori_ukms = res.data.data;
                    $('.kategori_ukm').select2({placeholder: 'Pilih Kategori UKM'})
                    .val(vm.formRequest.kategori_ukm_id)
                    .change(function(e) {
                        vm.formRequest.kategori_ukm_id = $('.kategori_ukm').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getBadanUsaha() {
                var vm = this;
                vm.$http({
                    url: '/badan_usaha/show',
                    method: 'GET',
                }).then((res) => {
                    vm.badan_usahas = res.data.data;
                    $('.badan_usaha').select2({placeholder: 'Pilih Bentuk Badan Usaha'})
                    .val(vm.formRequest.badan_usaha_id)
                    .change(function(e) {
                        vm.formRequest.badan_usaha_id = $('.badan_usaha').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getProvince() {
                var vm = this;
                vm.$http({
                    url: '/province/show',
                    method: 'GET',
                }).then((res) => {
                    vm.provinces = res.data.data;
                    $('.province').select2({placeholder: 'Pilih Provinsi'})
                    .val(vm.formRequest.province_id)
                    .change(function(e) {
                        vm.formRequest.province_id = $('.province').val()
                        vm.formRequest.city_id = null;
                        vm.getCity(vm.formRequest.province_id);
                    });
                    if(vm.formRequest.uuid) {
                        vm.getCity(vm.formRequest.province_id);
                    }
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getCity(pid) {
                var vm = this;
                vm.$http({
                    url: `/city/show?province_id=${pid}`,
                    method: 'GET',
                }).then((res) => {
                    vm.cities = res.data.data;
                    setTimeout(function() {
                        $('.city').select2({placeholder: 'Pilih Kabupaten/Kota'})
                        .val(vm.formRequest.city_id)
                        .change(function(e) {
                            vm.formRequest.city_id = $('.city').val()
                        });
                    })
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            //////
            getBahanBaku() {
                var vm = this
                vm.$http({
                    url: '/bahan_baku/show',
                    method: 'GET',
                }).then((res) => {
                    vm.bahan_bakus = res.data.data;
                    $('.bahan_baku').select2({placeholder: 'Pilih Sumber Bahan Baku'})
                    .val(vm.formRequest.bahan_baku)
                    .change(function(e) {
                        vm.formRequest.bahan_baku = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            getLegalitasUsaha() {
                var vm = this
                vm.$http({
                    url: '/legalitas_usaha/show',
                    method: 'GET',
                }).then((res) => {
                    vm.legalitas_usahas = res.data.data;
                    $('.legalitas_usaha').select2({placeholder: 'Pilih Legalitas Usaha'})
                    .val(vm.formRequest.legalitas_usaha)
                    .change(function(e) {
                        vm.formRequest.legalitas_usaha = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            getWilayahPemasaran() {
                var vm = this
                vm.$http({
                    url: '/wilayah_pemasaran/show',
                    method: 'GET',
                }).then((res) => {
                    vm.wilayah_pemasarans = res.data.data;
                    $('.wilayah_pemasaran').select2({placeholder: 'Pilih Wilayah Pemasaran'})
                    .val(vm.formRequest.wilayah_pemasaran)
                    .change(function(e) {
                        vm.formRequest.wilayah_pemasaran = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            getStandarisasiProduk() {
                var vm = this
                vm.$http({
                    url: '/standarisasi_produk/show',
                    method: 'GET',
                }).then((res) => {
                    vm.standarisasi_produks = res.data.data;
                    $('.standarisasi_produk').select2({placeholder: 'Pilih Standarisasi Produk'})
                    .val(vm.formRequest.standarisasi_produk)
                    .change(function(e) {
                        vm.formRequest.standarisasi_produk = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            getFasKegPernah() {
                var vm = this
                vm.$http({
                    url: '/fas_keg_pernah/show',
                    method: 'GET',
                }).then((res) => {
                    vm.fas_keg_pernahs = res.data.data;
                    $('.fas_keg_pernah').select2({placeholder: 'Pilih Fasilitas/Kegiatan'})
                    .val(vm.formRequest.fas_keg_pernah)
                    .change(function(e) {
                        vm.formRequest.fas_keg_pernah = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            getMasalahUkm() {
                var vm = this
                vm.$http({
                    url: '/masalah_ukm/show',
                    method: 'GET',
                }).then((res) => {
                    vm.masalah_ukms = res.data.data;
                    $('.masalah_ukm').select2({placeholder: 'Pilih Masalah UKM'})
                    .val(vm.formRequest.masalah_ukm)
                    .change(function(e) {
                        vm.formRequest.masalah_ukm = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            tahunUkm(){
                var vm = this;
                $('.tahun_ukm').datepicker({
                    format: "yyyy",
                    language: "id",
                    viewMode: "years", 
                    minViewMode: "years",
                })
                .val(vm.year)
                .on('change', function(v) {
                    vm.year = $(this).val();
                });
            },
            reportUkm(){
                var vm = this;

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda Akan Mendownlaod Report Berformat Excel, Mungkin Membutuhkan Waktu Beberapa Detik!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Download Sekarang!',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return vm.$http({
                            url: '/export/ukm',
                            method: 'POST',
                            responseType: 'arraybuffer',
                            data: {
                                'year': vm.year,
                            }
                        }).then((res) => {
                            var headers = res.headers;
                            var blob = new Blob([res.data], {
                                type: 'application/pdf',
                            });

                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = headers['content-disposition'].split('filename="')[1].split('"')[0];
                            link.click();
                            vm.year = '';
                            $('#exampleModalLong').modal('toggle');
                        }).catch((error) => {
                            const res = JSON.parse(Buffer.from(error.response.data).toString('utf8'));
                            Swal.fire('Gagal!', res.message, 'error')
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Berhasil!', 'File Berhasil Di Download.', 'success')
                    }
                })

            }
        },
        mounted() {
            var vm = this;
            vm.tahunUkm();
        }
    }
</script>

<style>
.wizard.wizard-3 .wizard-nav .wizard-steps {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: end;
  -ms-flex-align: end;
  align-items: flex-end; }
  .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    margin-right: 1rem; }
    .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step:last-child {
      margin-right: 0; }
    .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label {
      -webkit-box-flex: 1;
      -ms-flex: 1;
      flex: 1;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      color: #B5B5C3;
      padding: 2rem 0.5rem; }
      .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap; }
        .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title span {
          font-size: 2rem;
          margin-right: 0.5rem; }
      .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-bar {
        height: 4px;
        width: 100%;
        background-color: #EBEDF3;
        position: relative; }
        .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-bar:after {
          content: " ";
          position: absolute;
          top: 0;
          left: 0;
          height: 4px;
          width: 0;
          background-color: transparent;
          -webkit-transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
          transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, -webkit-box-shadow 0.15s ease;
          transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
          transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease, -webkit-box-shadow 0.15s ease; }
    .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label {
      color: #3699FF; }
      .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label .wizard-bar:after {
        width: 100%;
        background-color: #3699FF; }

@media (max-width: 991.98px) {
  .wizard.wizard-3 .wizard-nav .wizard-steps {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start; }
    .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 100%;
      flex: 0 0 100%;
      position: relative;
      width: 100%; }
      .wizard.wizard-3 .wizard-nav .wizard-steps .wizard-step .wizard-label {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        padding: 1rem 0; } }
</style>