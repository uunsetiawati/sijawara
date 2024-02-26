<template>
  <div class="container mb-8">
    <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
      <div v-if="showContentNotif" class="card card-custom mb-4 card-create">
        <div class="card-body">
          <form
            class="kt-form"
            id="myFormNotif"
            @submit.prevent="sendNotif"
            autocomplete="off"
          >
            <div class="row">
              <div class="col-md-12">
                <div class="mb-4">
                  <label class="required form-label">Judul :</label>
                  <input
                    type="text"
                    class="form-control"
                    name="judul"
                    v-model="formRequest.judul"
                    placeholder="Judul"
                  />
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-4">
                  <label class="required form-label">Isi :</label>
                  <textarea
                    type="text"
                    class="summernote form-control"
                    name="isi"
                    v-model="formRequest.isi"
                    placeholder="Isi"
                    rows="6"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4 mt-1">
                  <label class="form-label">Gambar :</label>
                  <div class="h-225px image-input image-input-empty image-input-outline w-375px d-block" id="imageUpload" :style="((type == 'create') ? 'background-image: url(assets/media/placeholder/375x225.png)' : `background-image: url(${formRequest.image_url})`)">
                    <div class="h-225px image-input-wrapper w-375px shadow-none border-0"></div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary shadow-sm" data-action="change" data-toggle="tooltip" title="" data-original-title="Change image">
                      <i class="fa fa-pen icon-sm text-muted"></i>
                      <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                      <input type="hidden" name="image_remove"/>
                    </label>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel image">
                      <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove image">
                      <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4 mt-1">
                  <label class="required form-label">Topik :</label>
                  <select class="form-select form-select-solid w-100" data-control="select2" v-model="formRequest.topics" name="topics[]" data-placeholder="Topik" data-allow-clear="true" multiple="multiple">
                    <option v-for="topic in topics" :value="topic.uuid" :key="topic.uuid">{{ topic.name }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="kt-form__actions mt-5">
              <button type="submit" class="btn btn-primary btn-sm mb-2 me-2">
                <i class="fa fa-paper-plane fs-2 me-3"></i> SEND
              </button>
              <button @click="showContentNotif = false"
                type="button" class="btn btn-danger btn-sm mb-2 me-2">
                <i class="las la-ban fs-2 me-2"></i> CANCEL
              </button>
            </div>
          </form>
        </div>
      </div>
      <div v-if="showContentTopic" class="card card-custom mb-4 card-create">
        <div class="card-body">
          <form
            class="kt-form"
            id="myFormTopic"
            @submit.prevent="sendTopic"
            autocomplete="off"
          >
            <div class="row">
              <div class="col-md-12">
                <div class="mb-4">
                  <label class="required form-label">Nama Grup Topik: </label>
                  <input type="text" class="form-control" v-model="formRequest.name" name="name" placeholder="Grup Topik">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-6 mt-1">
                  <div class="d-flex align-items-center mb-4">
                    <label class="required form-label">Pilih User untuk masuk ke dalam Grup Topik :</label>
                    <button type="button" class="btn btn-sm btn-light-info ml-auto" data-toggle="modal" data-target="#modalSelectedUser">
                      <i class="fa fa-eye"></i> Lihat User yang dipilih
                    </button>
                  </div>
                  <mti-paginate
                    id="tabelUser"
                    ref="tabelUser"
                    class="mt-sm-2"
                    classx="table table-rounded table-striped table-hover border gs-5"
                    :columns="columnsUser"
                    url="/user/forTopic"
                    :callback="callbackUser"
                    @onreload="reloadUserState"
                  >
                  </mti-paginate>

                  <div class="modal fade" tabindex="-1" id="modalSelectedUser">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">User yang dipilih untuk masuk ke Grup Topik</h5>

                          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                              <span class="svg-icon svg-icon-2x"></span>
                          </div>
                        </div>

                        <div class="modal-body">
                          <mti-paginate
                            id="tabelSelectedUser"
                            ref="tabelSelectedUser"
                            class="mt-sm-2"
                            classx="table table-rounded table-striped table-hover border gs-5"
                            :columns="columnsSelectedUser"
                            url="/user/forTopic"
                            :post="{ includes: selectedUsers }"
                          >
                          </mti-paginate>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="kt-form__actions mt-5">
              <button type="submit" class="btn btn-primary btn-sm mb-2 me-2">
                <i class="las la-save fs-2 me-3"></i> SAVE
              </button>
              <button @click="showContentTopic = false"
                type="button" class="btn btn-danger btn-sm mb-2 me-2">
                <i class="las la-ban fs-2 me-2"></i> CANCEL
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
    <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutRight">
      <div v-if="showPaginate" class="card card-custom">
        <div class="card-body">
          <div v-if="!showContentNotif && !showContentTopic" class="row mb-5" align="right">
            <div class="col-md-12">
              <button @click="setShowCreate('showContentNotif')" class="btn btn-sm btn-primary mr-4">
                <i class="fa fa-plus"></i> KIRIM NOTIFIKASI
              </button>
              <button @click="setShowCreate('showContentTopic')" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i> BUAT GRUP TOPIK
              </button>
            </div>
          </div>

          <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" data-toggle="tab" role="tab" href="#tab-notifikasi">Notifikasi</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" data-toggle="tab" role="tab" href="#tab-grup-topik">Grup Topik</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-notifikasi" role="tabpanel">
              <div class="row">
                <div class="col-md-12">
                  <mti-paginate
                    id="tabelNotifikasi"
                    ref="tabelNotifikasi"
                    class="mt-sm-2"
                    classx="table table-rounded table-striped table-hover border gs-5"
                    :columns="columnsNotifikasi"
                    url="/notifikasi/index"
                    :callback="callbackNotifikasi"
                  >
                  </mti-paginate>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-grup-topik" role="tabpanel">
              <div class="row">
                <div class="col-md-12">
                  <mti-paginate
                    id="tabelTopic"
                    ref="tabelTopic"
                    class="mt-sm-2"
                    classx="table table-rounded table-striped table-hover border gs-5"
                    :columns="columnsTopic"
                    url="/topic/index"
                    :callback="callbackTopic"
                  >
                  </mti-paginate>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
// AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

export default {
  data() {
    return {
      showContentNotif: false,
      showContentTopic: false,
      showPaginate: true,
      formRequest: { topics: [] },
      columnsNotifikasi: [
        { name: "#", data: "angka", style: "width: 50px" },
        { name: "Judul", data: "judul" },
        { name: "Action", data: "action", style: "width: 180px" },
      ],
      columnsTopic: [
        { name: "#", data: "angka", style: "width: 50px" },
        { name: "Nama", data: "name" },
        { name: "Action", data: "action", style: "width: 100px" },
      ],
      columnsUser: [
        { name: "#", data: "angka", style: "width: 50px" },
        { name: "Nama", data: "name" },
        { name: "NIK", data: "nik" },
        { name: "Email", data: "email" },
        { name: "Action", data: "action", style: "width: 50px" },
      ],
      columnsSelectedUser: [
        { name: "#", data: "angka", style: "width: 50px" },
        { name: "Nama", data: "name" },
        { name: "NIK", data: "nik" },
        { name: "Email", data: "email" },
      ],
      type: "create",
      topics: [],
      selectedUsers: [],
    };
  },
  methods: {
    sendNotif() {
      const vm = this;
      let url = "/notifikasi/create";
      const formData = new FormData($("#myFormNotif")[0]);
      formData.append('isi', $('.summernote').summernote('code'));

      if (vm.type != "create") {
        url = `/notifikasi/${vm.formRequest.uuid}/update`;
      }

      KTApp.block($(".card-create"));
      vm.$http({
        url: url,
        method: "POST",
        data: formData,
      })
        .then((res) => {
          KTUtil.scrollTop();
          KTApp.unblock($(".card-create"));
          toastr.success(res.data.data);
          vm.showContentNotif = false;
          vm.$refs.tabelNotifikasi.reload();
        })
        .catch((error) => {
          KTApp.unblock($(".card-create"));
          toastr.error(error.response.data.message);
        });
    },
    sendTopic() {
      const vm = this;
      let url = "/topic/create";
      const formData = new FormData($("#myFormTopic")[0]);
      vm.selectedUsers.forEach(user => formData.append('users[]', user));

      if (vm.type != "create") {
        url = `/topic/${vm.formRequest.uuid}/update`;
      }

      KTApp.block($(".card-create"));
      vm.$http({
        url: url,
        method: "POST",
        data: formData,
      })
        .then((res) => {
          KTUtil.scrollTop();
          KTApp.unblock($(".card-create"));
          toastr.success(res.data.data);
          vm.showContentTopic = false;
          vm.$refs.tabelTopic.reload();
        })
        .catch((error) => {
          KTApp.unblock($(".card-create"));
          toastr.error(error.response.data.message);
        });
    },
    delete(uuid, type) {
      var vm = this;
      vm.$http({
        url: "/" + type + "/" + uuid + "/delete",
        method: "DELETE",
      })
        .then((res) => {
          vm.$refs[type == 'notifikasi' ? 'tabelNotifikasi' : 'tabelTopic'].reload();
          Swal.fire(res.data.data, "Berhasil!");
        })
        .catch((error) => {
          toastr.error(error.response.data.message, "Gagal!");
        });
    },
    getEdit(uuid, a, type) {
      const vm = this;
      vm.$http({
        url: "/" + type + "/" + uuid + "/edit",
        method: "GET",
      })
        .then((res) => {
          vm.formRequest = res.data.data;
          vm.selectedUsers = res.data.data.users.map(user => user.uuid);
          vm.setShowEdit(a);
          KTUtil.scrollTop();
        })
        .catch((error) => {
          toastr.error(error.response.data.message, "Gagal!");
          vm.$refs.tabelNotifikasi.reload();
        });
    },
    setShowCreate(a) {
      const vm = this;
      this.formRequest = { topics: [] };
      this.selectedUsers = [];
      this.type = "create";
      this[a] = true;
      this.getTopics();
      setTimeout(() => {
        this.loadNote();
        this.loadImageUpload('imageUpload');
        $('select[name="topics[]"]').select2().val(vm.formRequest.topics).on('change', function(v) {
          vm.formRequest.topics = $('select[name="topics[]"]').val();
        });
      }, 100);
    },
    setShowEdit(a) {
      this.type = "update";
      this[a] = true;
      setTimeout(() => {
        this.loadNote(true);
        this.loadImageUpload('imageUpload');
      }, 100);
    },
    getTopics() {
      const vm = this;
      vm.$http({
        url: "/topic/show",
        method: "GET",
      }).then((res) => {
        vm.topics = res.data.data;
      }).catch((error) => {
        toastr.error("Sesuatu error terjadi.", "Gagal!");
      });
    },
    resend(uuid) {
      const vm = this;
      KTApp.block('#tabelNotifikasi');
      vm.$http({
        url: `/notifikasi/${uuid}/resend`,
        method: "POST",
      }).then(res => {
        toastr.success(res.data.data, 'Berhasil!');
        KTApp.unblock('#tabelNotifikasi');
      }).catch(error => {
        toastr.error(error.response.data.message, "Gagal!");
        KTApp.unblock('#tabelNotifikasi');
      });
    },
    callbackNotifikasi() {
      const vm = this;
      $("#tabelNotifikasi").on("click", ".resend", function (e) {
        const id = $(this).data("id");
        Swal.fire({
          title: "Apakah Anda yakin untuk mengirim ulang notifikasi?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Kirim Ulang!",
        }).then((result) => {
          if (result.isConfirmed) {
            vm.resend(id);
          }
        });
      });
      $("#tabelNotifikasi").on("click", ".delete", function (e) {
        const id = $(this).data("id");
        Swal.fire({
          title: "Apakah Anda yakin?",
          text: "Data yang telah dihapus tidak dapat dikembalikan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            vm.delete(id, 'notifikasi');
          }
        });
      });
    },
    callbackTopic() {
      const vm = this;
      $("#tabelTopic").on("click", ".edit", function (e) {
        const id = $(this).data("id");
        vm.getEdit(id, 'showContentTopic', 'topic');
      });
      $("#tabelTopic").on("click", ".delete", function (e) {
        const id = $(this).data("id");
        Swal.fire({
          title: "Apakah Anda yakin?",
          text: "Data yang telah dihapus tidak dapat dikembalikan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            vm.delete(id, 'topic');
          }
        });
      });
    },
    callbackUser() {
      const vm = this;
      $("#tabelUser").on("click", ".check", function (e) {
        const id = $(this).data("id");
        vm.selectUser(id);
      });
    },
    reloadUserState() {
      const vm = this;
      const currentTableUser = $("#tabelUser button");
      currentTableUser.each(function () {
        if (vm.selectedUsers.includes($(this).data("id"))) {
          $(this).removeClass("btn-light-primary");
          $(this).addClass("btn-light-danger");
          $(this).html('<i class="fa fa-times"></i>');
        } else {
          $(this).removeClass("btn-light-danger");
          $(this).addClass("btn-light-primary");
          $(this).html('<i class="fa fa-check"></i>');
        }
      });
      vm.$refs.tabelSelectedUser.reload();
    },
    selectUser(id) {
      const vm = this;
      if (vm.selectedUsers.includes(id)) {
        vm.selectedUsers.splice(vm.selectedUsers.indexOf(id), 1);
      } else {
        vm.selectedUsers.push(id);
      }
      vm.reloadUserState();
    },
    loadImageUpload(elem) {
      const ktImage = new KTImageInput(elem);
    },
    loadNote(withContent = false) {
      $('.summernote').summernote({
        tabsize: 2,
        height: 160,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'help']]
        ]
      });

      if (withContent){
        $(".summernote").summernote("code", this.formRequest.isi);
      }
    },
    loadJs() {},
  },
  mounted() {},
};
</script>

<style scoped>
.image-input:not(.image-input-empty) {
  background-image: none!important;
}

.image-input-wrapper {
  background-color: rgba(228, 230, 239, 0.25) !important;
  background-size: contain;
  background-position: center;
}
</style>

<style>
.select2-container .select2-search--inline .select2-search__field {
  margin: 4px 0
}
</style>