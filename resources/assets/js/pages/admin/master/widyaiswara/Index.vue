<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInUp">
            <div v-if="showIndex" class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button @click="setShowCreate" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/widyaiswara/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="widyaiswaraColumns" classHead="pt-2" :callback="callback"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition enter-active-class="animated slideInUp">
            <div v-if="showContent" class="card card-custom">
                <form @submit.prevent="sendData" id="formRequest">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ ((type == 'create') ? 'Create' : 'Edit') }} Widyaiswara</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group d-flex flex-column">
                                <label class="d-block text-center">Image <span v-if="type != 'create'" style="color: red;font-size: 10px;" class="">* jangan ubah jika tidak ada berubahan!</span></label>
                                <div class="h-300px image-input image-input-empty image-input-outline w-250px mx-auto" id="imageUpload" :style="((type == 'create') ? 'background-image: url(assets/media/placeholder/375x225.png)' : `background-image: url(${formRequest.photo_url})`)" style="background-position: center;">
                                    <div class="h-300px image-input-wrapper w-250px"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="profile_avatar_remove"/>
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 form-group d-flex flex-column">
                                <label class="d-block text-center">Detail Image (Popup) <span v-if="type != 'create'" style="color: red;font-size: 10px;" class="">* jangan ubah jika tidak ada berubahan!</span></label>
                                <div class="h-300px image-input image-input-empty image-input-outline w-250px mx-auto" id="detailImageUpload" :style="((type == 'create') ? 'background-image: url(assets/media/placeholder/375x225.png)' : `background-image: url(${formRequest.popup_url})`)" style="background-position: center;">
                                    <div class="h-300px image-input-wrapper w-250px"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="detail_image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="popup_image_remove"/>
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel popup">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove popup">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" placeholder="Nama" v-model="formRequest.name" required/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" name="position" placeholder="Jabatan" v-model="formRequest.position" required/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Tentang</label>
                                <input type="text" class="form-control" name="about" placeholder="Jabatan" v-model="formRequest.about"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" @click="setShowIndex" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</template>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                widyaiswaraColumns: [
                    {name: '#', data: 'image'},
                    {name: 'Nama', data: 'name'},
                    {name: 'Posisi', data: 'position'},
                    {name: 'Tentang', data: 'about'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],

                formRequest: {},

                showIndex: true,
                showContent: false,

                type: 'create',
            }
        },
        methods: {
            callback() {
                var vm = this;

                $('#tableIndex').on('click', '.edit', function(e) {
                    var el = $(this);
                    KTApp.block(el)
                    vm.getWidyaiswara($(this).data('id'), function() {KTApp.unblock(el)});
                });

                $('#tableIndex').on('click', '.delete', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    KTApp.block(el)
                    Swal.fire({
                        title: 'Apakah Anda yakin akan menghapus?',
                        showCancelButton: true,
                        icon: 'warning',
                        iconHtml: '?',
                        confirmButtonText: 'Ya',
                        showLoaderOnConfirm: true,
                        preConfirm: (login) => {
                            return vm.$http({
                                url: `/widyaiswara/${id}/delete`,
                                method: 'DELETE',
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
            sendData() {
                var vm = this;
                KTApp.block($(".card-custom"))
                var formData = new FormData($('#formRequest')[0]);
                var url = '/widyaiswara/create';
                if(vm.type != 'create') {
                    url = `/widyaiswara/${vm.formRequest.uuid}/update`;
                }
                vm.$http({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    KTApp.unblock($(".card-custom"))
                    vm.setShowIndex();
                    toastr.success(res.data.data);
                }).catch((error) => {
                    KTApp.unblock($(".card-custom"))
                    if(vm.type != 'create') {
                        vm.setShowIndex();
                    }
                    toastr.error(error.response.data.message);
                });

            },
            getWidyaiswara(uuid, callback=null) {
                var vm = this;
                vm.$http({
                    url: `/widyaiswara/${uuid}/edit`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    callback();
                    vm.setShowEdit();
                }).catch((error) => {
                    callback();
                });
            },
            loadImageUpload() {
                var avatar = new KTImageInput('imageUpload');
                var popup = new KTImageInput('detailImageUpload');
            },
            setShowIndex() {
                var vm = this;
                vm.showIndex = true;
                vm.showContent = false;
                vm.formRequest = {};
            },
            setShowCreate() {
                var vm = this;
                vm.type = 'create';
                vm.showIndex = false;
                vm.showContent = true;
                vm.formRequest = {};
                setTimeout(() => {
                    vm.loadImageUpload()
                }, 100)
            },
            setShowEdit() {
                var vm = this;
                vm.type = 'update';
                vm.showIndex = false;
                vm.showContent = true;
                setTimeout(() => {
                    vm.loadImageUpload()
                }, 100)
            }
        },
        mounted() {
            this.$parent.middleware('admin');
        }
    }
</script>