<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown">
            <div v-if="showIndex" class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button @click="setShowContent" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/course/other/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="courseColumns" classHead="pt-2" :callback="loadTable"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition enter-active-class="animated slideInUp">
            <div v-if="showContent" class="card card-custom">
                <form @submit.prevent="sendData" id="formRequest">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ ((type == 'create') ? 'Create' : 'Edit') }} Course</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 offset-md-4 form-group">
                                <div class="h-225px image-input image-input-empty image-input-outline w-375px" id="imageUpload" :style="((type == 'create') ? 'background-image: url(assets/media/placeholder/375x225.png)' : `background-image: url(${formRequest.image_url})`)">
                                    <div class="h-225px image-input-wrapper w-375px"></div>
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
                            <div class="col-md-12 form-group">
                                <label>Bahasa</label>
                                <select class="form-control" name="lang" v-model="formRequest.lang">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Judul Kursus</label>
                                <input type="text" class="form-control" name="title" placeholder="Judul Kursus" v-model="formRequest.title" required/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Deskripsi</label>
                                <div class="summernote" id="overviewNotes"></div>
                                <!-- <textarea type="text" class="form-control" rows="5" name="overview" placeholder="Overview"></textarea> -->
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Kategori</label>
                                <select class="form-control category" multiple="multiple" v-model="formRequest.categories">
                                    <option v-for="category in categories" :value="category.id">{{ category.nm_category }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="row form-inline">
                                    <label class="col-3 col-form-label">Tidak Aktif</label>
                                    <div class="col-1">
                                       <span class="switch switch-sm switch-success">
                                            <label>
                                                <input type="checkbox" :checked="((type == 'create') ? 'checked' : ((formRequest.is_active == '1') ? 'checked' : false))" name="is_active"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <label class="col-3 col-form-label">Aktif</label>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tanggal Mulai</label>
                                <input type="text" class="form-control tgl_mulai" readonly name="date_start" placeholder="Tanggal Mulai" v-model="formRequest.date_start" required/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tanggal Selesai</label>
                                <input type="text" class="form-control tgl_selesai" readonly name="date_end" placeholder="Tanggal Selesai" v-model="formRequest.date_end" required/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Jam Mulai</label>
                                <input type="text" class="form-control jam_mulai" readonly name="time_start" placeholder="Jam Mulai" v-model="formRequest.time_start" required/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Jam Selesai</label>
                                <input type="text" class="form-control jam_selesai" readonly name="time_end" placeholder="Jam Selesai" v-model="formRequest.time_end" required/>
                            </div>
                            <div class="col-md-6">
                                <label>Type</label>
                                <div class="row form-inline">
                                    <label class="col-3 col-form-label">Offline</label>
                                    <div class="col-1">
                                       <span class="switch switch-sm switch-success">
                                            <label>
                                                <input type="checkbox" :checked="((type == 'create') ? 'checked' : ((formRequest.is_online == '1') ? 'checked' : false))" name="is_online" v-model="typeChecked"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <label class="col-3 col-form-label">Online</label>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Kuota</label>
                                <input type="text" oninput="value=value.replace(/[^\d]/g,'')" class="form-control" name="quota" placeholder="Kuota" v-model="formRequest.quota" required/>
                            </div>
                            <div v-if="typeChecked" class="col-md-6 form-group">
                                <label>Meeting ID</label>
                                <input type="text" class="form-control" name="username" placeholder="Meeting ID" v-model="formRequest.username" required/>
                            </div>
                            <div v-if="typeChecked" class="col-md-6 form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" placeholder="Judul Kursus" v-model="formRequest.password" required/>
                            </div>
                            <div v-if="typeChecked" class="col-md-12 form-group">
                                <label>Meeting URL</label>
                                <input type="text" class="form-control" name="meeting_url" placeholder="Meeting URL" v-model="formRequest.meeting_url" required/>
                            </div>
                            <div v-if="!typeChecked" class="col-md-12 form-group">
                                <label>Tempat</label>
                                <input type="text" class="form-control" name="place" placeholder="Tempat" v-model="formRequest.place" required/>
                            </div>
                            <div v-if="type == 'create'" class="col-md-6 form-group d-flex align-item-center">
                                <input type="checkbox" name="is_notif" id="is_notif" style="width: 16px; height: 16px;" checked />
                                <label for="is_notif" class="ml-2" style="cursor: pointer;">Buat dan kirim notifikasi?</label>
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
                courseColumns: [
                    {name: '#', data: 'angka', style: 'width: 50px;'},
                    {name: '#', data: 'image'},
                    {name: 'Nama Kursus', data: 'title', style: 'width: 235px;'},
                    {name: 'Deskripsi', data: 'description'},
                    {name: 'Type', data: 'is_online'},
                    {name: 'Status', data: 'is_active'},
                    {name: 'Bahasa', data: 'lang'},
                    {name: 'Aksi', data: 'action', style: 'width: 268px;'},
                ],

                formRequest: {categories: []},

                categories: [],

                typeChecked: false,

                showIndex: true,
                showContent: false,

                type: 'create',
            }
        },
        methods: {
            loadTable() {
                var vm = this;

                $('#tableIndex').on('click', '.peserta', function(e) {
                    var el = $(this);
                    KTApp.block(el)
                    var id = $(this).data('id');
                    vm.$router.push({name: 'admin.course.other.peserta', params: {uuid: id}});
                });

                $('#tableIndex').on('click', '.edit', function(e) {
                    var el = $(this);
                    KTApp.block(el)
                    vm.getCourse($(this).data('id'), function() {KTApp.unblock(el)});
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
                                url: `/course/other/${id}/delete`,
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
                formData.append('description', $('.summernote').summernote('code'));
                formData.append('categories', vm.formRequest.categories.join(','));
                var url = '/course/other/create';
                if(vm.type != 'create') {
                    url = `/course/other/${vm.formRequest.uuid}/update`;
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
            loadImageUpload() {
                var vm = this;

                var avatar = new KTImageInput('imageUpload');

                // avatar.on('cancel', function(imageInput) {
                //  console.log('CANCEL => ', imageInput)
                // });

                // avatar.on('change', function(imageInput) {
                //  console.log('CHANGE => ', imageInput)
                // });

                // avatar.on('remove', function(imageInput) {
                //  console.log('REMOVE => ', imageInput)
                // });
            },
            loadTanggal() {
                var vm = this;
                $('.tgl_mulai').datepicker({
                    format: "yyyy-mm-dd"
                })
                .val(vm.formRequest.date_start)
                .on('change', function (e) {
                    vm.formRequest.date_start = $(this).val();
                });

                $('.tgl_selesai').datepicker({
                    format: "yyyy-mm-dd"
                })
                .val(vm.formRequest.date_end)
                .on('change', function(e) {
                    vm.formRequest.date_end = $(this).val();
                });

                $('.jam_mulai').timepicker({
                    timeFormat: 'HH:mm',
                    minuteStep: 5,
                    showMeridian: false,
                    showSeconds: false,
                    showInputs: true,
                    maxHours: 24,
                }).on('changeTime.timepicker', function(e) {
                    vm.formRequest.time_start = e.time.value;
                });

                $('.jam_selesai').timepicker({
                    timeFormat: 'HH:mm',
                    minuteStep: 5,
                    showMeridian: false,
                    showSeconds: false,
                    showInputs: true,
                    maxHours: 24,
                }).on('changeTime.timepicker', function(e) {
                    vm.formRequest.time_end = e.time.value;
                });
            },
            loadNotes(withContent=false) {
                $('.summernote').summernote({
                    height: 150
                });
                if(withContent){
                    $(".summernote").summernote("code", this.formRequest.description);
                }
            },
            // changeSwitchType() {
            //     var vm = this;
            //     if(this.typeChecked) {
                    
            //     }
            // },
            getCourse(uuid, callback=null) {
                var vm = this;
                vm.$http({
                    url: `/course/other/${uuid}/edit`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    vm.typeChecked = ((vm.formRequest.is_online == '1') ? true : false);
                    vm.setShowEditContent();
                    callback()
                }).catch((error) => {
                    callback()
                });
            },
            getCategory() {
                var vm = this;
                vm.$http({
                    url: '/course/category/show',
                    method: 'GET',
                }).then((res) => {
                    vm.categories = res.data.data;
                    $('.category').select2({
                        placeholder: "Pilih Kategori"
                    })
                    .val(vm.formRequest.categories)
                    .on('change', function(v) {
                        vm.formRequest.categories = $('.category').val();
                    });
                }).catch((error) => {
                    
                });
            },
            setShowIndex() {
                this.formRequest = {categories: []};
                this.showIndex = true;
                this.showContent = false;
            },
            setShowContent() {
                var vm = this;
                vm.formRequest = {categories: [], date_start: new Date().toISOString().slice(0,10), date_end: new Date().toISOString().slice(0,10), time_start: new Date().getHours()+':00', time_end: new Date().getHours()+':00'};
                this.type = 'create';
                vm.showIndex = false;
                vm.showContent = true;
                vm.imageChecked = false;
                vm.getCategory()
                setTimeout(function() {
                    vm.loadNotes();
                    setTimeout(function() {
                        vm.loadImageUpload();
                        vm.loadTanggal()
                    }, 100)
                })
            },
            setShowEditContent() {
                var vm = this;
                this.type = 'edit';
                vm.showIndex = false;
                vm.showContent = true;
                vm.imageChecked = true;
                vm.getCategory()
                setTimeout(function() {
                    vm.loadNotes(true);
                    setTimeout(function() {
                        vm.loadImageUpload();
                        vm.loadTanggal();
                    }, 100)
                })
            },
            setShowContentCourse() {
                var vm = this;
                vm.formRequestContent = {categories: []};
                this.type = 'create';
                vm.showIndex = false;
                vm.showContent = true;
                vm.imageChecked = false;
                vm.getCategory()
                setTimeout(function() {
                    vm.loadNotes();
                })
            },
        },
        mounted() {
            this.$parent.middleware('admin');
        }
    }
</script>