<template>
    <div class="container mb-8">
        <transition enter-active-class="animated slideInDown">
            <div v-if="showIndex" class="card card-custom">
                <div class="card-body">
                    <div class="mb-3 mt-3 row">
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-60 symbol-2by3 symbol-100 flex-shrink-0 mr-4">
                                    <div class="symbol-label" :style="`background-image: url(${course.image_url})`"></div>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="font-weight-bolder font-size-lg text-primary mb-1">{{ course.nm_course }}</span>
                                    <span class="text-dark-50 font-weight-normal font-size-sm">{{ course.overview.strip_tags().substring(0, 120) }}{{ ((course.overview.strip_tags().length >= 60) ? '...' : '') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <router-link :to="{name: 'admin.course.list'}" class="btn btn-sm btn-danger"><i class="fas fa-chevron-left"></i> KEMBALI</router-link>
                            <button @click="setShowContent" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <mti-paginate url="/course/content/index" id="tableIndex" ref="tableIndex" classx="rounded table table-hover table-secondary" :columns="contentColumns" :post="{course: $route.params.uuid}" classHead="pt-2" :callback="loadTable"></mti-paginate>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
            <div v-if="showContent" class="card card-custom">
                <form @submit.prevent="sendData" id="formRequest">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ ((type == 'create') ? 'Create' : 'Edit') }} Course Content</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 form-group">
                                <label>No. Urut</label>
                                <input type="text" class="form-control" name="no_urut" placeholder="No. Urut" v-model="formRequest.no_urut" required />
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="title" placeholder="Judul" v-model="formRequest.title" required />
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Konten</label>
                                <div class="summernote" id="overviewNotes"></div>
                                <!-- <textarea type="text" class="form-control" rows="5" name="overview" placeholder="Overview"></textarea> -->
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Video</label>
                                <div class="row form-inline">
                                    <label class="col-3 col-form-label">Drive/Youtube</label>
                                    <div class="col-1">
                                       <span class="switch switch-sm switch-primary">
                                            <label>
                                                <input type="checkbox" disabled="" v-model="videoChecked"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <label class="col-3 col-form-label">Upload</label>
                                </div>
                                <input v-if="!videoChecked" class="form-control" type="text" name="video" placeholder="Google Drive/Youtube Link" v-model="formRequest.video">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Module <span v-if="type != 'create'" style="color: red;font-size: 10px;" class="">* jangan ubah jika tidak ada berubahan!</span></label></label>
                                <div class="row form-inline">
                                    <label class="col-3 col-form-label">Google Drive</label>
                                    <div class="col-1">
                                       <span class="switch switch-sm switch-primary">
                                            <label>
                                                <input type="checkbox" v-model="moduleChecked"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <label class="col-3 col-form-label">Upload</label>
                                </div>
                                <input v-if="!moduleChecked" class="form-control" type="text" name="module" placeholder="Google Drive Link" v-model="formRequest.module">
                                <input v-else class="form-control" type="file" name="module">
                            </div>
                            <div class="col-md-12 form-group">
                                <hr/>
                                <label>Petanyaan</label>
                                <div class="row form-inline">
                                    <label class="col-1 col-form-label">Tidak</label>
                                    <div class="col-1">
                                       <span class="switch switch-sm switch-primary">
                                            <label>
                                                <input type="checkbox" v-model="questionChecked"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <label class="col-1 col-form-label">Ada</label>
                                </div>
                                <button v-if="questionChecked" class="btn btn-sm btn-primary" type="button" @click="addQuestion"><i class="fa fa-plus"></i> TAMBAH</button>
                                <template v-if="questionChecked" v-for="(question, index) in formRequest.course_question">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{ index+1 }}.</span>
                                                </div>
                                                <input type="text" class="form-control" name="question" v-model="question.question" placeholder="Soal">
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-5">
                                            <div class="form-group">
                                                <div class="radio-list">
                                                    <label class="radio">
                                                        <input type="radio" v-model="question.answer" :name="`answer_${index}`" value="a"/>
                                                        <span></span>
                                                        a. <input type="text" class="form-control ml-3" style="opacity: 1; z-index: 1; position: unset;" name="a_answer" placeholder="Jawaban A" v-model="question.a_answer">
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" v-model="question.answer" :name="`answer_${index}`" value="b"/>
                                                        <span></span>
                                                        b. <input type="text" class="form-control ml-3" style="opacity: 1; z-index: 1; position: unset;" name="b_answer" placeholder="Jawaban B" v-model="question.b_answer">
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" v-model="question.answer" :name="`answer_${index}`" value="c"/>
                                                        <span></span>
                                                        c. <input type="text" class="form-control ml-3" style="opacity: 1; z-index: 1; position: unset;" name="c_answer" placeholder="Jawaban C" v-model="question.c_answer">
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" v-model="question.answer" :name="`answer_${index}`" value="d"/>
                                                        <span></span>
                                                        d. <input type="text" class="form-control ml-3" style="opacity: 1; z-index: 1; position: unset;" name="d_answer" placeholder="Jawaban D" v-model="question.d_answer">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Penjelasan</span>
                                                </div>
                                                <input type="text" class="form-control" name="description" v-model="question.description" placeholder="Deskripsi Jawaban">
                                            </div>
                                            <hr/>
                                        </div>
                                    </div>
                                </template>
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
                contentColumns: [
                    {name: 'No. Urut', data: 'no_urut', style: 'width: 73px;'},
                    {name: 'Judul', data: 'title', style: 'width: 330px;'},
                    {name: 'Konten', data: 'content'},
                    {name: 'Aksi', data: 'action', style: 'width: 175px;'}
                ],

                formRequest: {course_question: []},
                course: {overview: ""},

                moduleChecked: false,
                videoChecked: false,
                questionChecked: false,

                type: 'create',
                showIndex: true,
                showContent: false,
            }
        },
        methods: {
            addQuestion() {
                var vm = this;
                vm.formRequest.course_question.push({question: "", answer: null, a_answer: "", b_answer: "", c_answer: "", d_answer: "", description: ""});
            },
            loadTable() {
                var vm = this;
                $('#tableIndex').on('click', '.edit', function() {
                    var id = $(this).data('id');
                    vm.getCourseContent(id);
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
                                url: `/course/content/${id}/delete`,
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
            loadNotes(withContent=false) {
                $('.summernote').summernote({
                    height: 150
                });
                if(withContent){
                    $(".summernote").summernote("code", this.formRequest.content);
                }
            },
            getCourse() {
                var vm = this;
                vm.$http({
                    url: '/course/detail',
                    method: 'POST',
                    data: {course: vm.$route.params.uuid}
                }).then((res) => {
                    vm.course = res.data.data;
                }).catch((error) => {
                    toastr.error(error.response.data.message)
                    vm.$router.push({name: 'admin.course.list'});
                });
            },
            getCourseContent(uuid) {
                var vm = this;
                vm.$http({
                    url: `/course/content/${uuid}/edit`,
                    method: 'GET',
                }).then((res) => {
                    vm.formRequest = res.data.data;
                    if(vm.formRequest.course_question.length >= 1) {
                        vm.questionChecked = true;
                    }else{
                        vm.questionChecked = false;
                    }
                    vm.setShowEditContent();
                }).catch((error) => {
                    
                });
            },
            sendData() {
                var vm = this;
                KTApp.block($(".card-custom"))
                var formData = new FormData($('#formRequest')[0]);
                formData.append('content', $('.summernote').summernote('code'));
                formData.append('course_id', vm.course.id);
                if(vm.questionChecked) {
                    formData.append('course_question', JSON.stringify(vm.formRequest.course_question));
                }else{
                    formData.append('course_question', JSON.stringify([]));
                }
                var url = '/course/content/create';
                if(vm.type != 'create') {
                    url = `/course/content/${vm.formRequest.uuid}/update`;
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
            setShowIndex() {
                var vm = this;
                vm.formRequest = {course_question: []};
                vm.showIndex = true;
                vm.showContent = false;
            },
            setShowContent() {
                var vm = this;
                this.type = 'create';
                vm.formRequest = {course_question: []};
                vm.showIndex = false;
                vm.showContent = true;
                setTimeout(function() {
                    vm.loadNotes();
                })
            },
            setShowEditContent() {
                var vm = this;
                this.type = 'edit';
                vm.showIndex = false;
                vm.showContent = true;
                vm.moduleChecked = false;
                setTimeout(function() {
                    vm.loadNotes(true);
                })
            },
        },
        mounted() {
            this.getCourse();
        }
    }
</script>