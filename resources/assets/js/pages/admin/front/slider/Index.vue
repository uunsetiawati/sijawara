<template>
    <div class="container mb-8">
        <div class="row">
            <transition enter-active-class="animated slideInDown">
            <div v-if="showContent" class="col-md-12 mb-4">
                <div class="card card-custom card-content">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ ((type == 'create') ? 'Create' : 'Edit') }} Slider</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form @submit.prevent="send" method="POST" id="formRequest">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <div class="h-400px image-input image-input-empty image-input-outline w-700px" id="imageUpload" :style="((type == 'create') ? 'background-image: url(assets/media/placeholder/375x225.png)' : `background-image: url(${formRequest.image_url})`)">
                                                <div class="h-400px image-input-wrapper w-700px"></div>
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
                                        <div class="col-md-12 form-group mt-4">
                                            <label>Nama Slider</label>
                                            <input type="text" class="form-control" name="name" placeholder="Nama Slider" v-model="formRequest.name" required/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button form="formRequest" type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" @click="setHideContent" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
            </transition>
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="setShowContent" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <mti-paginate url="/slider/index" ref="tableIndex" id="tableIndex" classx="rounded table table-hover table-secondary" :columns="sliderColumns" classHead="pt-2" :callback="loadTable"></mti-paginate>
                            </div>
                        </div>
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
                sliderColumns: [
                    {name: '#', data: 'image', style: 'width: 235px;'},
                    {name: 'Nama', data: 'name'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],
                formRequest: {image_url: ""},
                type: 'create',

                showContent: false,
            }
        },
        methods: {
            loadTable() {
                var vm = this;
                $('#tableIndex').on('click', '.edit', function(e) {
                    var el = $(this);
                    KTApp.block(el)
                    vm.getSlider($(this).data('id'), function() {KTApp.unblock(el)});
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
                                url: `/slider/${id}/delete`,
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
            getSlider(uuid, callback=null) {
                var vm = this;
                vm.$http({
                    url: `/slider/${uuid}/edit`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    vm.setShowEditContent();
                    callback()
                }).catch((error) => {
                    callback()
                });
            },
            send() {
                var vm = this;
                var url = '/slider/create';
                if(vm.type != 'create') {
                    url = `/slider/${vm.formRequest.uuid}/update`
                }

                KTApp.block($(".card-content"))
                var formData = new FormData($('#formRequest')[0]);

                vm.$http({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    KTApp.unblock($(".card-content"))
                    vm.setHideContent();
                    vm.$refs.tableIndex.reload()
                    toastr.success(res.data.data);
                }).catch((error) => {
                    KTApp.unblock($(".card-content"))
                    if(vm.type != 'create') {
                        vm.setHideContent();
                    }
                    vm.$refs.tableIndex.reload()
                    toastr.error(error.response.data.message);
                });
            },
            setHideContent() {
                var vm = this;
                vm.formRequest = {'image_url': ""};
                vm.showContent = false;
            },
            setShowContent() {
                var vm = this;
                vm.type = 'create';
                vm.showContent = true;
                setTimeout(function() {
                    var avatar = new KTImageInput('imageUpload');
                }, 100)
            },
            setShowEditContent() {
                var vm = this;
                vm.type = 'edit';
                vm.showContent = true;
                setTimeout(function() {
                    var avatar = new KTImageInput('imageUpload');
                    KTUtil.scrollTop()
                }, 100)
            }
        },
        mounted() {
            this.$parent.middleware('admin');
        }
    }
</script>