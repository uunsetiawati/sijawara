<template>
    <div class="row">
        <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
            <div v-if="showContent" class="col-md-12 mb-4">
                <!-- <div class="card card-custom mb-4 card-create">
                    <div class="card-body"> -->
                        <form method="POST" @submit.prevent="send">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Pronvinsi</label>
                                    <select type="text" class="form-control province" v-model="formRequest.province_id">
                                        <option v-for="province in provinces" :value="province.id">{{ province.nm_province }}</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" v-model="formRequest.nm_city">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
                                    <button @click="() => {this.showContent = false;}" type="button" class="btn btn-sm btn-danger">BATAL</button>
                                </div>
                            </div>
                        </form>
                    <!-- </div>
                </div> -->
            </div>
        </transition>
        <div v-if="!showContent" class="col-md-12 mb-4">
            <button class="btn btn-primary btn-sm" @click="setShowCreate"><i class="fa fa-plus"></i> TAMBAH</button>
        </div>
        <div class="col-md-12">
            <mti-paginate id="myTable" ref="myTable" classx="rounded table table-hover table-secondary" url="/city/index" :columns="cityColumns" :callback="loadTable"></mti-paginate>
        </div>
    </div>
</template>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                cityColumns: [
                    {name: 'Nama', data: 'nm_city'},
                    {name: 'Provinsi', data: 'province.nm_province'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px'},
                ],
                provinces: [],
                formRequest: {},
                showContent: false,
                type: 'create'
            }
        },
        methods: {
            loadTable() {
                var vm = this;
                $('#myTable').on('click', '.edit', function(e) {
                    var id = $(this).data('id');
                    var el = $(this);
                    vm.getCategory(id, el);
                });

                $('#myTable').on('click', '.delete', function(e) {
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
                                url: `/city/${id}/delete`,
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
                                vm.$refs.myTable.reload()
                            });
                        }
                    })
                });
            },
            getProvinces() {
                var vm = this;
                vm.$http({
                    url: '/province/show',
                    method: 'GET',
                }).then((res) => {
                    vm.provinces = res.data.data;
                    setTimeout(function() {
                        $('.province').select2({placeholder: 'Pilih Pronvinsi'})
                        .val(vm.formRequest.province_id)
                        .change(function() {
                            vm.formRequest.province_id = $('.province').val()
                        })
                    })
                }).catch((error) => {
                    
                });
            },
            getCategory(id, el) {
                var vm = this;
                KTApp.block(el);
                vm.$http({
                    url: `/city/${id}/edit`,
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
                var url = '/city/create';
                if(vm.type != 'create') {
                    url = `/city/${vm.formRequest.uuid}/update`;
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
                    vm.$refs.myTable.reload();
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
                this.getProvinces();
            },
            setShowEdit() {
                this.type = 'update';
                this.showContent = true;
                this.getProvinces();
            }
        },
        mounted() {
            this.$parent.$parent.middleware('admin');
        }
    }
</script>