<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="card-title">
                                <span class="card-icon"><i class="fa fa-cogs text-primary"></i></span>
                                <h3 class="card-label">Pengaturan Website</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body loding">
                        <form class="kt-form kt-form--label-right" enctype="multipart/form-data" id="myForm" @submit.prevent="saveData">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Bahasa</label>
                                <div class="col-10">
                                    <select class="form-control lang" name="lang" v-model="formRequest.lang">
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">Nama Website</label>
                                <div class="col-10">
                                    <input class="form-control" name="name" type="text" v-model="formRequest.name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-search-input" class="col-2 col-form-label">Deskripsi</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="description" v-model="formRequest.description" rows="5">{{ formRequest.description }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                </div>
                                <div class="col-10">
                                    <button type="submit" id="btnChange" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="card-title">
                                <span class="card-icon"><i class="fa fa-cogs text-primary"></i></span>
                                <h3 class="card-label">Background & Logo</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body loding">
                        <div class="alert alert-custom alert-outline-danger fade show mb-5" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">Jangan Ubah Jika Tidak Ada Perbahan!</div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Background Login</label>
                            <div class="col-10">
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="background">
                                        <div class="image-input-wrapper" style="width: 350px; height: 235px;" :style="((formRequest.backgrounddir) ? 'background-image: url('+formRequest.backgrounddir+')' : '')"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input @change="imageValidate" form="myForm" type="file" name="background_file" accept=".png, .jpg, .jpeg">
                                        </label>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Logo Luar</label>
                            <div class="col-10">
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="logo_white">
                                        <div class="image-input-wrapper" style="width: 350px; height: 95px;" :style="((formRequest.logowhitedir) ? 'background-image: url('+formRequest.logowhitedir+')' : '')"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input @change="imageValidate" form="myForm" type="file" name="logo_white_file" accept=".png, .jpg, .jpeg">
                                        </label>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Logo Dalam</label>
                            <div class="col-10">
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="logo_dark">
                                        <div class="image-input-wrapper" style="width: 350px; height: 95px;" :style="((formRequest.logodarkdir) ? 'background-image: url('+formRequest.logodarkdir+')' : '')"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input @change="imageValidate" form="myForm" type="file" name="logo_dark_file" accept=".png, .jpg, .jpeg">
                                        </label>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                showContent: false,
                type: 'create',
                formRequest: {
                    lang: 'id',
                },
            }
        },
        methods:{
            loadJs() {
                new KTImageInput("background");
                new KTImageInput("logo_dark");
                new KTImageInput("logo_white");
            },
            getData(cb=null) {
                var vm = this;
                vm.$http({
                    url: `/setting/${vm.formRequest.lang}/edit`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    cb;
                }).catch((error) => {
                    toastr.success('Sesuatu error terjadi.', 'Gagal!');
                });
            },
            imageValidate: function(e) {
                e.preventDefault();
                var target = e.target;
                const images = e.target.files[0];
                var name = images.name.split('.');
                var ext = name[name.length-1];
                var myarr = ["png", "jpg", "jpeg", "PNG", "JPG", "JPEG"];
                if(myarr.indexOf(ext) > -1){
                    return;
                }else{
                    alert('Gambar Harus Berformat : jpg, png, jpeg');
                    images.value = "";
                }
            },
            saveData() {
                var vm = this;
                var data = new FormData($('#myForm')[0]);
                var url = '/setting/update';
                var btn = KTUtil.getById('btnChange');
                KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");
                KTApp.block(".loding",{
                    overlayColor:"#000000",
                    type:"v2",
                    state:"primary",
                    message:"Processing...",
                    opacity: 0.2
                });
                vm.$http({
                    url: url,
                    method: 'POST',
                    data: data
                }).then((res) => {
                    KTUtil.btnRelease(btn);
                    vm.$parent.getConfig();
                    vm.formRequest = res.data.data;
                    toastr.success('', 'Berhasil!');
                    KTApp.unblock(".loding");
                }).catch((error) => {
                    toastr.error(error.response.data.message, 'Gagal!');
                    KTUtil.btnRelease(btn);
                    KTApp.unblock(".loding");
                });
            },
            language(){
                var vm = this;
                setTimeout(()=>{
                    $('.lang').select2({placeholder: 'Pilih'})
                    .val(vm.formRequest.lang)
                    .change(function(e) {
                        vm.formRequest.lang = $('.lang').val()
                        vm.getData();
                    });
                });
            }
        },
        mounted() {
            this.$parent.middleware('admin');
            this.getData(this.language());
            this.loadJs();
        }

    }
</script>
