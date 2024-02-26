<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
            <div class="card card-custom" v-if="showContent">
                <div class="card-header">
                    <h3 class="card-title mb-0">Detail Koperasi</h3>
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
                                        <span>1.</span>Data Koperasi</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 1 Nav-->
                                <!--begin::Wizard Step 2 Nav-->
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>2.</span>Data Badan Hukum</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>3.</span>Data Pengurus & Anggota</h3>
                                        <div class="wizard-bar"></div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 2 Nav-->
                                <!--begin::Wizard Step 3 Nav-->
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">
                                        <span>4.</span>Data Lain Lain</h3>
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
                                        <h4 class="mb-0 font-weight-bold text-dark">Data Koperasi</h4><hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>NAMA KOPERASI</label>
                                                            <input readonly type="text" class="form-control" name="nm_koperasi" v-model="formRequest.nm_koperasi" placeholder="Nama Koperasi"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>NO. NIK (KOPERASI) <small>(jika belum bersertifikat bisa dituliskan angka 0)</small></label>
                                                            <input readonly type="text" class="form-control" name="nik" v-model="formRequest.nik" placeholder="3578XXXXXXXXXXXX" minlength="1" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>NO TELP/HP</label>
                                                            <input readonly type="text" class="form-control" name="phone" v-model="formRequest.phone" placeholder="08XXXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                        </div>
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>ALAMAT KOPERASI</label>
                                                            <textarea readonly type="text" class="form-control" name="alamat_koperasi" v-model="formRequest.alamat_koperasi" placeholder="Alamat Koperasi" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select disabled name="province_id" v-model="formRequest.province_id" class="province form-control">
                                                                <option v-for="province in provinces" :value="province.id">{{ province.nm_province }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div v-if="cities.length != 0" class="col-xl-12">
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>BENTUK KOPERASI</label>
                                                            <select disabled name="bentuk_koperasi_id" v-model="formRequest.bentuk_koperasi_id" class="bentuk_koperasi form-control">
                                                                <option v-for="bentuk_koperasi in bentuk_koperasis" :value="bentuk_koperasi.id">{{ bentuk_koperasi.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>JENIS KOPERASI</label>
                                                            <select disabled name="jenis_koperasi_id" v-model="formRequest.jenis_koperasi_id" class="jenis_koperasi form-control">
                                                                <option v-for="jenis_koperasi in jenis_koperasis" :value="jenis_koperasi.id">{{ jenis_koperasi.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>KELOMPOK KOPERASI</label>
                                                            <select disabled name="kelompok_koperasi_id" v-model="formRequest.kelompok_koperasi_id" class="kelompok_koperasi form-control">
                                                                <option v-for="kelompok_koperasi in kelompok_koperasis" :value="kelompok_koperasi.id">{{ kelompok_koperasi.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>SEKTOR USAHA</label>
                                                            <select disabled name="sektor_usaha_id" v-model="formRequest.sektor_usaha_id" class="sektor_usaha form-control">
                                                                <option v-for="sektor_usaha in sektor_usahas" :value="sektor_usaha.id">{{ sektor_usaha.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>VOLUME USAHA PERBULAN (OMZET)</label>
                                                            <div class="input-icon">
                                                            <input readonly type="text" class="form-control" name="volume_usaha" v-model="formRequest.volume_usaha" placeholder="Volume Usaha" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                            <span>Rp.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>ASSET</label>
                                                            <div class="input-icon">
                                                            <input readonly type="text" class="form-control" name="asset" v-model="formRequest.asset" placeholder="Asset" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                            <span>Rp.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="form-group">
                                                            <label>UNIT USAHA PENYUMBANG (OMZET) TERBESAR</label>
                                                            <select disabled name="unit_usaha_id" v-model="formRequest.unit_usaha_id" class="unit_usaha form-control">
                                                                <option v-for="unit_usaha in unit_usahas" :value="unit_usaha.id">{{ unit_usaha.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>MODAL SENDIRI</label>
                                                    <div class="input-icon">
                                                    <input readonly type="text" class="form-control" name="modal_sendiri" v-model="formRequest.modal_sendiri" placeholder="Modal Sendiri" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                    <span>Rp.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>MODAL LUAR</label>
                                                    <div class="input-icon">
                                                    <input readonly type="text" class="form-control" name="modal_luar" v-model="formRequest.modal_luar" placeholder="Modal Luar" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                    <span>Rp.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>SISA HASIL USAHA</label>
                                                    <div class="input-icon">
                                                    <input readonly type="text" class="form-control" name="sisa_hasil_usaha" v-model="formRequest.sisa_hasil_usaha" placeholder="Sisa Hasil Usaha" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"/>
                                                    <span>Rp.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 1-->
                                    <!--begin: Wizard Step 2-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-0 font-weight-bold text-dark">Data Badan Hukum</h4><hr>
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. BADAN HUKUM</label>
                                                    <input readonly type="text" class="form-control" name="no_badan_hukum" v-model="formRequest.no_badan_hukum" placeholder="XX/BH/X.XX/XXX/XXXX"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>TANGGAL BADAN HUKUM</label>
                                                    <input readonly disabled type="text"  class="tgl_badan_hukum form-control" name="tgl_badan_hukum" v-model="formRequest.tgl_badan_hukum" placeholder="Tanggal Badan Hukum" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. PAD (PERUBAHAN ANGGARAN DASAR)</label>
                                                    <input readonly type="text" class="form-control" name="no_pad" v-model="formRequest.no_pad" placeholder="No. PAD"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>TANGGAL PAD (PERUBAHAN ANGGARAN DASAR)</label>
                                                    <input readonly disabled type="text"  class="tgl_pad form-control" name="tgl_pad" v-model="formRequest.tgl_pad" placeholder="Tanggal PAD" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>STATUS KOPERASI</label>
                                                    <select readonly name="status" v-model="formRequest.status" class="form-control" title="Pilih Status">
                                                        <option value="1">AKTIF</option>
                                                        <option value="0">TIDAK AKTIF</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>JUMLAH KANTOR CABANG KOPERASI</label>
                                                    <input readonly type="text" class="form-control" name="cabang" v-model="formRequest.cabang" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="1" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>TANGGAL RAT</label>
                                                    <input readonly disabled type="text"  class="tgl_rat form-control" name="tgl_rat" v-model="formRequest.tgl_rat" placeholder="Tanggal RAT" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 2-->
                                    <!--begin: Wizard Step 3-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-0 font-weight-bold text-dark">Ketua</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NAMA KETUA</label>
                                                    <input readonly type="text" class="form-control" name="nm_ketua" v-model="formRequest.nm_ketua" placeholder="Nama Ketua"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. TELP</label>
                                                    <input readonly type="text" class="form-control" name="phone_ketua" v-model="formRequest.phone_ketua" placeholder="08XXXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-0 font-weight-bold text-dark">Sekretaris</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NAMA SEKRETARIS</label>
                                                    <input readonly type="text" class="form-control" name="nm_sekretaris" v-model="formRequest.nm_sekretaris" placeholder="Nama Sekretaris"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. TELP</label>
                                                    <input readonly type="text" class="form-control" name="phone_sekretaris" v-model="formRequest.phone_sekretaris" placeholder="08XXXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-0 font-weight-bold text-dark">Bendahara</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NAMA BENDAHARA</label>
                                                    <input readonly type="text" class="form-control" name="nm_bendahara" v-model="formRequest.nm_bendahara" placeholder="Nama Bendahara"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>NO. TELP</label>
                                                    <input readonly type="text" class="form-control" name="phone_bendahara" v-model="formRequest.phone_bendahara" placeholder="08XXXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-0 font-weight-bold text-dark">Lain - Lain</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="card card-custom">
                                                    <div class="card-body pt-5 pb-0">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h6 class="text-center font-weight-bolder mb-5">JUMLAH ANGGOTA KOPERASI</h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>PRIA</label>
                                                                    <input readonly type="text" class="form-control" name="anggota_pria" v-model="formRequest.anggota_pria" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>WANITA</label>
                                                                    <input readonly type="text" class="form-control" name="anggota_wanita" v-model="formRequest.anggota_wanita" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="card card-custom">
                                                    <div class="card-body pt-5 pb-0">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h6 class="text-center font-weight-bolder mb-5">JUMLAH MANAJER</h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>PRIA</label>
                                                                    <input readonly type="text" class="form-control" name="manager_pria" v-model="formRequest.manager_pria" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>WANITA</label>
                                                                    <input readonly type="text" class="form-control" name="manager_wanita" v-model="formRequest.manager_wanita" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="card card-custom">
                                                    <div class="card-body pt-5 pb-0">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h6 class="text-center font-weight-bolder mb-5">JUMLAH KARYAWAN</h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>PRIA</label>
                                                                    <input readonly type="text" class="form-control" name="karyawan_pria" v-model="formRequest.karyawan_pria" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>WANITA</label>
                                                                    <input readonly type="text" class="form-control" name="karyawan_wanita" v-model="formRequest.karyawan_wanita" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" minlength="9" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end: Wizard Step 3-->
                                    <!--begin: Wizard Step 4-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-0 font-weight-bold text-dark">Data Lain - Lain</h4><hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>PERMASALAHAN DALAM PENGEMBANGAN KOPERASI</label>
                                                    <select disabled name="masalah_koperasi" multiple="multiple" v-model="formRequest.masalah_koperasi" class="masalah_koperasi form-control">
                                                        <option v-for="masalah_koperasi in masalah_koperasis" :value="masalah_koperasi.id">{{ masalah_koperasi.name }}</option>
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
                                            <!-- <button type="button" @click="send" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button> -->
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
        <transition enter-active-class="animated slideOutRight">
            <div class="card card-custom" v-if="!showContent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="fas fa-file-excel"></i> Cetak Laporan</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/koperasi/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="koperasiColumns" classHead="pt-2" :callback="loadTable"></mti-paginate>
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
                        <h5 class="modal-title" id="exampleModalLabel">Laporan Data Koperasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="year=''">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" readonly required class="tahun_koperasi form-control" name="tahun_koperasi" v-model="year" placeholder="Pilih Tahun" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" @click="year=''">Batal</button>
                        <button type="button" class="btn btn-primary font-weight-bold" @click="reportKoperasi" >Download</button>
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
                koperasiColumns: [
                    {name: '#', data: 'angka', style: 'width: 50px;'},
                    {name: 'Nik', data: 'nik'},
                    {name: 'Ketua', data: 'nm_ketua'},
                    {name: 'Koperasi', data: 'nm_koperasi'},
                    {name: 'Telepon', data: 'phone'},
                    {name: 'Status', data: 'status'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],
                showContent: false,

                formRequest: {bentuk_koperasi_id: null, jenis_koperasi_id: null, kelompok_koperasi_id: null, sektor_usaha_id: null, unit_usaha_id: null, province_id: null, city_id: null, status: "",  masalah_koperasi: []},
                provinces: [],
                cities: [],
                //
                bentuk_koperasis: [],
                jenis_koperasis: [],
                kelompok_koperasis: [],
                sektor_usahas: [],
                unit_usahas: [],
                masalah_koperasis: [],
                year: '',
            }
        },
        methods: {
            loadTable() {
                var vm = this;
                $('#tableIndex').on('click', '.detail', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    vm.getKoperasi(id, el);
                });

            },
            getKoperasi(id, el) {
                var vm = this;
                KTApp.block(el);
                vm.$http({
                    url: `/koperasi/${id}/edit`,
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
                            vm.getProvince()
                            vm.getBentukKoperasi()
                            vm.getJenisKoperasi()
                            vm.getKelompokKoperasi()
                            vm.getSektorUsaha()
                            vm.getUnitUsaha()
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
                                            vm.loadStep2()
                                        }else if(i.getStep() == 4) {
                                            vm.getMasalahKoperasi()
                                        }
                                        return;
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
            getBentukKoperasi() {
                var vm = this;
                vm.$http({
                    url: '/bentuk_koperasi/show',
                    method: 'GET',
                }).then((res) => {
                    vm.bentuk_koperasis = res.data.data;
                    $('.bentuk_koperasi').select2({placeholder: 'Pilih Bentuk Koperasi'})
                    .val(vm.formRequest.bentuk_koperasi_id)
                    .change(function(e) {
                        vm.formRequest.bentuk_koperasi_id = $('.bentuk_koperasi').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getJenisKoperasi() {
                var vm = this;
                vm.$http({
                    url: '/jenis_koperasi/show',
                    method: 'GET',
                }).then((res) => {
                    vm.jenis_koperasis = res.data.data;
                    $('.jenis_koperasi').select2({placeholder: 'Pilih Jenis Koperasi'})
                    .val(vm.formRequest.jenis_koperasi_id)
                    .change(function(e) {
                        vm.formRequest.jenis_koperasi_id = $('.jenis_koperasi').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getKelompokKoperasi() {
                var vm = this;
                vm.$http({
                    url: '/kelompok_koperasi/show',
                    method: 'GET',
                }).then((res) => {
                    vm.kelompok_koperasis = res.data.data;
                    $('.kelompok_koperasi').select2({placeholder: 'Pilih Kelompok Koperasi'})
                    .val(vm.formRequest.kelompok_koperasi_id)
                    .change(function(e) {
                        vm.formRequest.kelompok_koperasi_id = $('.kelompok_koperasi').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getSektorUsaha() {
                var vm = this;
                vm.$http({
                    url: '/sektor_usaha/show',
                    method: 'GET',
                }).then((res) => {
                    vm.sektor_usahas = res.data.data;
                    $('.sektor_usaha').select2({placeholder: 'Pilih Sektor Usaha'})
                    .val(vm.formRequest.sektor_usaha_id)
                    .change(function(e) {
                        vm.formRequest.sektor_usaha_id = $('.sektor_usaha').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getUnitUsaha() {
                var vm = this;
                vm.$http({
                    url: '/unit_usaha/show',
                    method: 'GET',
                }).then((res) => {
                    vm.unit_usahas = res.data.data;
                    $('.unit_usaha').select2({placeholder: 'Pilih Unit Usaha'})
                    .val(vm.formRequest.unit_usaha_id)
                    .change(function(e) {
                        vm.formRequest.unit_usaha_id = $('.unit_usaha').val()
                    });
                }).catch((error) => {
                    toastr.error('Gagal mengambil data, sesuatu error terjadi.')
                });
            },
            getMasalahKoperasi() {
                var vm = this
                vm.$http({
                    url: '/masalah_koperasi/show',
                    method: 'GET',
                }).then((res) => {
                    vm.masalah_koperasis = res.data.data;
                    $('.masalah_koperasi').select2({placeholder: 'Pilih Masalah Koperasi'})
                    .val(vm.formRequest.masalah_koperasi)
                    .change(function(e) {
                        vm.formRequest.masalah_koperasi = $(this).val()
                    });
                }).catch((error) => {
                    
                });
            },
            loadStep2() {
                var vm = this;
                $('.tgl_badan_hukum').datepicker({
                    format: "yyyy-mm-dd",
                    language: "id"
                })
                .val(vm.formRequest.tgl_badan_hukum)
                .on('change', function(v) {

                    vm.formRequest.tgl_badan_hukum = $(this).val();
                });

                $('.tgl_pad').datepicker({
                    format: "yyyy-mm-dd",
                    language: "id"
                })
                .val(vm.formRequest.tgl_pad)
                .on('change', function(v) {
                    vm.formRequest.tgl_pad = $(this).val();
                });

                $('.tgl_rat').datepicker({
                    format: "yyyy-mm-dd",
                    language: "id"
                })
                .val(vm.formRequest.tgl_rat)
                .on('change', function(v) {
                    vm.formRequest.tgl_rat = $(this).val();
                });

                // setTimeout(function() {
                //     $(".selectpicker").selectpicker()
                // })
                // .val(vm.formRequest.status)
            },
            tahunKoperasi(){
                var vm = this;
                $('.tahun_koperasi').datepicker({
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
            reportKoperasi(){
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
                            url: '/export/koperasi' ,
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
                            $('#exampleModalLong').modal('toggle');
                            vm.year = '';
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
            vm.tahunKoperasi();
            this.$parent.middleware('admin');
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