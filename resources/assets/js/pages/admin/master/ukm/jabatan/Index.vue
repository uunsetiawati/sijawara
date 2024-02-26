<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
            <div v-if="showContent" class="card card-custom mb-4 card-create">
                <div class="card-body">
                    <form method="POST" @submit.prevent="send">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" v-model="formRequest.name">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
                                <button @click="() => {this.showContent = false;}" type="button" class="btn btn-sm btn-danger">BATAL</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
        <div class="card card-custom">
            <div class="card-body">
                <div v-if="!showContent" class="row">
                    <div class="col-md-12">
                        <button @click="setShowCreate" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <mti-paginate url="/jabatan_ukm/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="categoryColumns" classHead="pt-2" :callback="loadTable"></mti-paginate>
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
                categoryColumns: [
                    {name: '#', data: 'angka', style: 'width: 50px;'},
                    {name: 'Nama', data: 'name'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],
                formRequest: {},
                showContent: false,
                type: 'create'
            }
        },
        methods: {
            loadTable() {
                var vm = this;
                $('#tableIndex').on('click', '.edit', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    vm.getCategory(id, el);
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
                                url: `/jabatan_ukm/${id}/delete`,
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
            getKoperasi(id, el) {
                var vm = this;
                KTApp.block(el);
                vm.$http({
                    url: `/jabatan_ukm/${id}/edit`,
                    method: 'GET',
                }).then((res) => {
                    KTUtil.scrollTop();
                    KTApp.unblock(el);
                    vm.formRequest = res.data.data;
                    vm.setShowEdit();
                }).catch((error) => {
                    KTApp.unblock(el);
                    toastr.error(error.response.data.message);
                });
            },
            send() {
                var vm = this;
                var url = '/jabatan_ukm/create';
                if(vm.type != 'create') {
                    url = `/jabatan_ukm/${vm.formRequest.uuid}/update`;
                }
                KTApp.block($('.card-create'));
                vm.$http({
                    url: url,
                    method: 'POST',
                    data: vm.formRequest
                }).then((res) => {
                    KTApp.unblock($('.card-create'));
                    toastr.success(res.data.data);
                    vm.showContent = false;
                    vm.$refs.tableIndex.reload();
                }).catch((error) => {
                    KTApp.unblock($('.card-create'));
                    toastr.error(error.response.data.message);
                    vm.showContent = false;
                });
            },
            setShowCreate() {
                this.formRequest = {};
                this.type = 'create';
                this.showContent = true;
            },
            setShowEdit() {
                this.type = 'update';
                this.showContent = true;
            }
        },
        mounted() {
            this.$parent.middleware('admin');
        }
    }
</script>