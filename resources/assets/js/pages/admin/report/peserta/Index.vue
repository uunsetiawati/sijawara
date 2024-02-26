<template>
  <div class="container">
    <transition enter-active-class="animated slideInDown" leave-active-class="animated slideOutUp">
      <div v-if="showCourses" class="card card-custom mb-10">
        <div class="card-body">
          <div class="row">
            <div class="col-12 d-flex justify-content-end">
              <button type="button" class="btn btn-danger btn-sm" @click="(showCourses = false) || (showPeserta = true)">
                <i class="fa fa-chevron-left"></i>
                KEMBALI
              </button>
            </div>
            <div class="col-md-1 d-flex align-items-start justify-content-center mx-4 px-0">
              <img v-if="selectedPeserta.image" :src="selectedPeserta.image_url" width="120" class="rounded" style="max-width: 100%">
              <span v-else class="svg-icon svg-icon-7x rounded" style="background: #cbd5e1">
                <svg v-if="$auth.user().gender == '0'" enable-background="new 0 0 464.002 464.002" version="1.1" viewBox="0 0 464 464" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="m120 185c0 43-23 157-56 183l135.48 33.548c20.016-172.04-79.484-216.54-79.484-216.54z" fill="#E8A055"/>
                    <path d="m344 185c0 43 23 157 56 183l-135.48 33.548c-20.016-172.04 79.484-216.54 79.484-216.54z" fill="#F6B45E"/>
                    <path d="m380.38 436.83-2.984-22.383-6.542-49.067c-1.779-13.344-10.151-24.898-22.277-30.744l-30.861-14.879c-3.003-1.448-6.501-0.135-7.99 2.804l-18.782-6.911c-6.533-2.178-10.94-8.292-10.94-15.179v-25.802l34.461-14.359c17.886-7.454 29.537-24.931 29.537-44.309v-72c0-22.091-17.909-72-40-72h-144c-22.092 0-40 49.909-40 72v72c0 19.378 11.651 36.855 29.538 44.308l34.462 14.359v25.801c0 6.887-4.407 13.001-10.94 15.179l-18.782 6.911c-1.489-2.938-4.987-4.251-7.99-2.804l-30.861 14.879c-12.126 5.847-20.498 17.4-22.277 30.744l-6.542 49.067-2.984 22.383c-1.919 14.389 9.274 27.173 23.789 27.173h249.18c14.515 0 25.708-12.784 23.79-27.171z" fill="#FFD7A3"/>
                    <path d="m320 326.34-19.834-7.298c-9.615 28.45-36.469 48.959-68.166 48.959s-58.55-20.509-68.167-48.959l-19.833 7.298v9.661c0 48.601 39.399 88 88 88s88-39.399 88-88v-9.661z" fill="#72967D"/>
                    <path d="m380.38 436.83-9.526-71.451c-1.779-13.344-10.151-24.897-22.277-30.744l-30.861-14.879c-3.107-1.498-6.75-0.046-8.143 3.109-20.236 45.826-54.904 67.136-77.571 77.139-22.667-10.002-57.335-31.313-77.569-77.14-1.393-3.155-5.036-4.606-8.143-3.109l-30.861 14.879c-12.126 5.847-20.498 17.4-22.277 30.744l-9.526 71.451c-1.918 14.387 9.274 27.172 23.79 27.172h249.18c14.514 1e-3 25.707-12.784 23.789-27.171z" fill="#8ABE69"/>
                    <path d="m237.11 410.86c38.651-18.172 68.226-48.756 86.091-88.465l-5.484-2.644c-3.107-1.498-6.75-0.046-8.143 3.109-20.235 45.826-54.903 67.136-77.57 77.139-22.667-10.002-57.335-31.313-77.569-77.14-1.393-3.155-5.036-4.606-8.143-3.109l-5.483 2.644c17.865 39.709 47.439 70.293 86.09 88.465l5.105 2.402 5.106-2.401z" fill="#9BCE7A"/>
                    <path d="m144 429.73c0-8.895-2.965-17.536-8.426-24.558l-39.339-50.579c-1.497 3.403-2.582 7.011-3.086 10.79l-9.526 71.451c-1.918 14.387 9.274 27.172 23.79 27.172h36.587v-34.276z" fill="#9BCE7A"/>
                    <path d="m280 274.67-96 1e-3v25.801c0 5.693-3.017 10.852-7.752 13.701 66.923 11.562 103.75-39.499 103.75-39.503z" fill="#FDC88E"/>
                    <path d="m320 429.73c0-8.895 2.965-17.536 8.426-24.558l39.339-50.579c1.497 3.403 2.582 7.011 3.086 10.79l9.526 71.451c1.918 14.387-9.274 27.172-23.79 27.172h-36.587v-34.276z" fill="#9BCE7A"/>
                    <path d="m314.46 260.31-51.694 21.539c-9.75 4.062-20.207 6.154-30.769 6.154s-21.02-2.092-30.77-6.154l-51.691-21.538c-17.886-7.454-29.538-24.931-29.538-44.309v-72c0-22.091 17.909-72 40-72h144c22.091 0 40 49.909 40 72v72c1e-3 19.378-11.651 36.855-29.538 44.308z" fill="#FFE1B2"/>
                    <circle cx="120" cy="184" r="24" fill="#FFD7A3"/>
                    <circle cx="344" cy="184" r="24" fill="#FFE1B2"/>
                    <path d="m176 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                    <path d="m288 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                    <path d="m232 248.22c-14.223 0-27.527-3.5-36.5-9.605-3.652-2.484-4.602-7.461-2.113-11.113 2.48-3.648 7.461-4.598 11.113-2.113 6.289 4.277 16.57 6.832 27.5 6.832s21.211-2.555 27.5-6.832c3.66-2.492 8.629-1.539 11.113 2.113 2.488 3.652 1.539 8.629-2.113 11.113-8.972 6.105-22.277 9.605-36.5 9.605z" fill="#E4B07B"/>
                    <path d="m245.88 86.403-10.876-6.398-115 73.741v62.255c0 19.378 11.651 36.855 29.538 44.308l51.69 21.538c2.53 1.054 5.112 1.962 7.727 2.749-22.844-16.711-38.05-31.32-46.96-40.872-6.482-6.95-9.995-16.121-9.995-25.625v-48.271c21.94-25.448 81.862-62.68 93.876-83.425z" fill="#FFD7A3"/>
                    <path d="m232.23 80.005c0 22.667 112 62.667 112 112 0 139.67 55.772 176 55.772 176-17-55.663-7.171-289.29-95.773-352-16.25-11.5-37.154-16.155-48-16-20.695 0.296-24 8-24 8v72.001h1e-3z" fill="#FFC85C"/>
                    <path d="m324 72.352c0 10.77-21.73 19.5-32.5 19.5-10.769 0-19.5-8.73-19.5-19.5s8.73-19.5 19.5-19.5 32.5 8.73 32.5 19.5z" fill="#FFE095"/>
                    <path d="m324 72.352c0-10.77 21.73-19.5 32.5-19.5s19.5 8.73 19.5 19.5-8.73 19.5-19.5 19.5-32.5-8.73-32.5-19.5z" fill="#FFE095"/>
                    <path d="m324 72.352c9.327 5.385 6.022 28.569 0.637 37.896s-17.311 12.522-26.638 7.138-12.522-17.311-7.138-26.638c5.387-9.327 23.813-23.781 33.139-18.396z" fill="#FFEEB1"/>
                    <path d="m324 72.352c-9.327-5.385-6.022-28.569-0.638-37.896 5.385-9.327 17.311-12.522 26.638-7.138s12.522 17.311 7.137 26.638c-5.384 9.327-23.81 23.781-33.137 18.396z" fill="#FFEEB1"/>
                    <path d="m324 72.352c-9.327 5.385-6.022 28.569-0.638 37.896 5.385 9.327 17.311 12.522 26.638 7.138s12.522-17.311 7.137-26.638c-5.384-9.327-23.81-23.781-33.137-18.396z" fill="#FFF2CE"/>
                    <path d="m324 72.352c9.327-5.385 6.022-28.569 0.637-37.896s-17.311-12.522-26.638-7.138-12.522 17.311-7.138 26.638c5.387 9.327 23.813 23.781 33.139 18.396z" fill="#FFF2CE"/>
                    <circle cx="324" cy="72.352" r="13" fill="#fff"/>
                    <path d="m232.23 80.005c0 22.667-112 62.667-112 112 0 139.67-55.773 176-55.773 176 17-55.663 7.171-289.29 95.773-352 16.25-11.5 37.154-16.155 48-16 20.695 0.296 24 8 24 8v72.001z" fill="#FFC85C"/>
                    <path d="m208.23 5e-3c-10.846-0.155-31.75 4.5-48 16-88.602 62.702-78.773 296.33-95.773 352 0 0 55.772-36.329 55.772-176 0-15.446 10.98-29.977 26.064-43.348 22.714-123.32 85.937-140.65 85.937-140.65s-3.305-7.704-24-8z" fill="#F6B45E"/>
                </svg>
                <svg v-else enable-background="new 0 0 464.001 464.001" version="1.1" viewBox="0 0 464 464" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="m388.63 437.02-10.126-81.012c-1.529-12.228-9.943-22.492-21.633-26.389l-39.047-13.016c-5.362-1.788-11.244-0.649-15.379 2.874l-11.502-3.834c-6.533-2.178-10.94-8.292-10.94-15.179v-25.802l34.461-14.359c17.887-7.451 29.538-24.928 29.538-44.306v-8c13.255 0 24-10.745 24-24 0-5.979-2.191-11.443-5.808-15.645 6.791-24.718 25.878-102.91 5.808-136.36l8-32s-84 2-128 16l16-16s-112.5 0-135.99 39.993l-7e-3 7e-3s-40-0.333-40 48c0 17.69 9.867 61.862 14.103 80.015-3.793 4.244-6.103 9.844-6.103 15.985 0 13.255 10.745 24 24 24v8c0 19.377 11.651 36.854 29.538 44.308l34.462 14.359v25.801c0 6.887-4.407 13.001-10.94 15.179l-11.502 3.834c-4.135-3.523-10.017-4.662-15.379-2.874l-39.047 13.016c-11.691 3.897-20.105 14.161-21.633 26.389l-10.126 81.012c-1.791 14.324 9.378 26.976 23.814 26.976h265.63c14.436 0 25.606-12.652 23.815-26.977z" fill="#FFD7A3"/>
                        <path d="m280 274.67-96 1e-3v25.801c0 5.759-3.186 10.831-8.017 13.659 67.094 11.743 104.02-39.461 104.02-39.461z" fill="#FDC88E"/>
                        <path d="M104,176c0,0-16-65.474-16-88c0-48.333,40-48,40-48l0.007-0.007C151.5,0,264,0,264,0l-16,16    C292,2,376,0,376,0l-8,32c24,40-8,144-8,144H104z" fill="#734A3E"/>
                        <path d="m264 0s-112.5 0-135.99 39.993l-7e-3 7e-3s-40-0.333-40 48c0 22.526 16 88 16 88s166.33-74.333 272-176c0 0-84 2-128 16l16-16z" fill="#623F33"/>
                    <path d="m344 160v-16c0-22.091-17.909-40-40-40h-144c-22.091 0-40 17.909-40 40v16c-13.255 0-24 10.745-24 24s10.745 24 24 24v8c0 19.377 11.651 36.854 29.538 44.308l51.691 21.538c9.75 4.063 20.208 6.154 30.77 6.154s21.019-2.092 30.769-6.154l51.694-21.539c17.887-7.452 29.538-24.929 29.538-44.307v-8c13.255 0 24-10.745 24-24s-10.745-24-24-24z" fill="#FFE1B2"/>
                        <path d="m176 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                        <path d="m288 192c-4.4 0-8-3.6-8-8v-8c0-4.4 3.6-8 8-8s8 3.6 8 8v8c0 4.4-3.6 8-8 8z" fill="#623F33"/>
                            <path d="m232 248.22c-14.223 0-27.527-3.5-36.5-9.605-3.652-2.484-4.602-7.461-2.113-11.113 2.48-3.648 7.461-4.598 11.113-2.113 6.289 4.277 16.57 6.832 27.5 6.832s21.211-2.555 27.5-6.832c3.66-2.492 8.629-1.539 11.113 2.113 2.488 3.652 1.539 8.629-2.113 11.113-8.972 6.105-22.277 9.605-36.5 9.605z" fill="#E4B07B"/>
                        <path d="m388.63 437.02-10.126-81.012c-1.528-12.228-9.943-22.492-21.633-26.389l-39.047-13.016c-6.8-2.267-14.45 0.154-18.291 6.206-14.182 22.344-39.107 37.187-67.531 37.187s-53.349-14.844-67.53-37.187c-3.841-6.052-11.491-8.473-18.291-6.206l-39.047 13.016c-11.691 3.897-20.105 14.161-21.633 26.389l-10.126 81.012c-1.791 14.324 9.379 26.977 23.815 26.977h265.63c14.435 0 25.605-12.653 23.814-26.977z" fill="#00BEA4"/>
                        <path d="M92.168,340.168c-3.552,4.497-5.93,9.93-6.669,15.843l-10.126,81.012    C73.582,451.348,84.752,464,99.188,464H144v-52.067c0-7.697-2.774-15.135-7.813-20.953L92.168,340.168z" fill="#00AB9A"/>
                        <path d="m371.83 340.17c3.552 4.497 5.93 9.93 6.669 15.843l10.126 81.012c1.791 14.325-9.379 26.977-23.815 26.977h-44.812v-52.067c0-7.697 2.774-15.135 7.813-20.953l44.019-50.812z" fill="#00AB9A"/>
                    <path d="m162 243.72c-6.482-6.95-9.995-16.121-9.995-25.625v-90.66c25.463-1.909 105.74-8.852 152-23.438h-144c-2.754 0-5.421 0.321-8 0.881v-0.075c-18.257 3.707-32 19.843-32 39.194v16c-13.255 0-24 10.745-24 24s10.745 24 24 24v8c0 19.378 11.651 36.855 29.538 44.308l51.69 21.538c2.53 1.054 5.112 1.962 7.727 2.749-22.844-16.712-38.05-31.321-46.959-40.872z" fill="#FFD7A3"/>
                </svg>
              </span>
            </div>
            <div class="col-md-10">
              <h2 class="mb-3" style="font-weight: bold">{{ selectedPeserta.name }}</h2>
              <div class="row">
                <div class="col-md-6">
                  <div><strong>Email</strong> : {{ selectedPeserta.email }}</div>
                  <div><strong>No. Telp</strong> : {{ selectedPeserta.phone }}</div>
                  <div><strong>Jenis</strong> : {{ selectedPeserta.jenis }}</div>
                </div>
                <div class="col-md-6">
                  <div><strong>Alamat</strong> : {{ selectedPeserta.address || '-' }}</div>
                  <div><strong>Kota</strong> : {{ selectedPeserta.city ? selectedPeserta.city.nm_city : '-' }}</div>
                  <div><strong>Provinsi</strong> : {{ selectedPeserta.province ? selectedPeserta.province.nm_province : '-' }}</div>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-16">
              <h6 class="mb-4">Kursus yang diselesaikan :</h6>
              <mti-paginate
                id="tabelCourses"
                ref="tabelCourses"
                class="mt-sm-2"
                classx="table table-rounded table-striped table-hover border gs-5"
                :columns="columnsCourses"
                url="/laporan/peserta/courses"
                :callback="callbackCourses"
                :post="postCourses"
              >
              </mti-paginate>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition enter-active-class="animated slideOutUp" leave-active-class="animated slideInDown">
      <div v-show="showChart && showPeserta" class="card card-custom">
        <div class="card-body">
          <div class="row">
            <div class="col-12 mb-8 d-flex align-items-center" style="gap: 2rem">
              <div>
                <label for="province" class="d-block">Provinsi :</label>
                <select name="province_id" id="province" v-model="paramsChart.province_id" style="min-width: 200px">
                  <option value="0" selected>SEMUA</option>
                  <option v-for="province in provinces" :value="province.id">{{ province.nm_province }}</option>
                </select>
              </div>
              <div>
                <label for="city" class="d-block">Kota :</label>
                <select name="city_id" id="city" v-model="paramsChart.city_id" :disabled="paramsChart.province_id == 0" style="min-width: 160px">
                  <option value="0" selected>SEMUA</option>
                  <option v-for="city in cities" :value="city.id">{{ city.nm_city }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <canvas id="chart-jenis-peserta" height="200px"></canvas>
            </div>
            <div class="col-md-6">
              <canvas id="chart-gender-peserta" height="200px"></canvas>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition enter-active-class="animated slideOutUp" leave-active-class="animated slideInDown">
      <div v-if="showPeserta" class="card card-custom mt-10">
        <div class="card-body">
          <h4 class="mb-6">Ranking Peserta Berdasarkan Jumlah Kursus yang Diselesaikan :</h4>
          <mti-paginate
            id="tabelPeserta"
            ref="tabelPeserta"
            class="mt-sm-2"
            classx="table table-rounded table-striped table-hover border gs-5"
            :columns="columnsPeserta"
            url="/laporan/peserta"
            :callback="callbackPeserta"
          >
          </mti-paginate>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  data() {
    return {
      showPeserta: true,
      showCourses: false,
      showChart: true,
      columnsPeserta: [
        { name: '#', data: 'angka' },
        { name: 'Nama', data: 'name' },
        { name: 'Kursus diselesaikan', data: 'courses_count' },
        { name: 'Jenis', data: 'jenis' },
        { name: 'Email', data: 'email' },
        // { name: 'No. HP', data: 'phone' },
        { name: 'Aksi', data: 'action' },
      ],
      columnsCourses: [
        { name: '#', data: 'angka' },
        { name: 'Nama Kursus', data: 'name' },
        { name: 'Tipe', data: 'tipe' },
        { name: 'Kategori', data: 'category' },
        { name: 'Jumlah Peserta', data: 'jumlah_peserta' },
        { name: 'Aksi', data: 'action' },
      ],
      postCourses: {
        peserta: ''
      },
      provinces: [],
      cities: [],
      selectedPeserta: {},
      paramsChart: { province_id: 0, city_id: 0 },
      chartJenisPeserta: [],
      chartGenderPeserta: [],
      elemChartJenisPeserta: null,
      elemChartGenderPeserta: null,
    }
  },
  methods: {
    callbackPeserta() {
      const vm = this;
      $("#tabelPeserta").on("click", ".show-course", function (e) {
        const id = $(this).data("id");
        vm.showCourses = true;
        vm.showPeserta = false;
        vm.postCourses.peserta = id;
        vm.selectedPeserta = {};
        KTUtil.scrollTop();
        vm.getPeserta(id);
      });
    },
    callbackCourses() {
      const vm = this;
      $('#tabelCourses').on('click', '.detail-course', function (e) {
        const uuid = $(this).data("id");
        const routeName = $(this).data("route");
        const route = vm.$router.resolve({ name: routeName, params: { uuid: uuid } });
        window.open(route.href, '_blank');
      });
    },
    getPeserta(uuid) {
      const vm = this;
      vm.$http({
        url: `/user/${uuid}/detail`,
        method: 'GET'
      }).then(res  => {
        vm.selectedPeserta = res.data.data;
      }).catch(err => {
        vm.toastr(err.response.data.message, 'Error!');
      });
    },
    getProvince() {
      const vm = this;
      vm.$http({
        url: '/province/show',
        method: 'GET'
      }).then(res => {
        vm.provinces = res.data.data;
      }).catch(err => {
        vm.toastr(err.response.data.message, 'Error!');
      });
    },
    getCities() {
      const vm = this;
      vm.$http({
        url: '/city/show?province_id=' + vm.paramsChart.province_id,
        method: 'GET'
      }).then(res => {
        vm.cities = res.data.data;
      }).catch(err => {
        vm.toastr(err.response.data.message, 'Error!');
      });
    },
    getChartJenisPeserta() {
      const vm = this;
      vm.$http({
        url: '/laporan/chart/jenisPeserta',
        method: 'POST',
        data: vm.paramsChart
      }).then(res => {
        vm.chartJenisPeserta = res.data.data;

        if (vm.elemChartJenisPeserta) {
          vm.elemChartJenisPeserta.destroy();
        }

        setTimeout(() => {
          const chart = document.getElementById('chart-jenis-peserta');
          const labels = vm.chartJenisPeserta.map(item => item.name);
          const datas = vm.chartJenisPeserta.map(item => item.jumlah);

          const data = {
            labels: labels,
            datasets: [{
              data: datas.length ? datas : [0],
              backgroundColor: [
                'rgb(225, 99, 102)',
                'rgb(255, 205, 86)',
                'rgb(246 118 17)',
                'rgb(54, 162, 235)',
              ],
              hoverOffset: 2
            }]
          };

          const config = {
            type: 'doughnut',
            data: data,
            options: {
              legend: {
                position: 'bottom'
              }
            }
          };

          vm.elemChartJenisPeserta = new Chart(chart, config);
        }, 100);
      }).catch(err => {
        vm.toastr(err.response.data.message, 'Error!');
      });
    },
    getChartGenderPeserta() {
      const vm = this;
      vm.$http({
        url: '/laporan/chart/genderPeserta',
        method: 'POST',
        data: vm.paramsChart
      }).then(res => {
        vm.chartGenderPeserta = res.data.data;

        if (vm.elemChartGenderPeserta) {
          vm.elemChartGenderPeserta.destroy();
        }

        setTimeout(() => {
          const chart = document.getElementById('chart-gender-peserta');
          const labels = vm.chartGenderPeserta.map(item => item.name);
          const datas = vm.chartGenderPeserta.map(item => item.jumlah);

          const data = {
            labels: labels,
            datasets: [{
              data: datas.length ? datas : [0],
              backgroundColor: [
                'rgb(255, 99, 102)',
                'rgb(54, 162, 235)',
              ],
              hoverOffset: 2
            }]
          };

          const config = {
            type: 'doughnut',
            data: data,
            options: {
              legend: {
                position: 'bottom'
              }
            }
          };

          vm.elemChartGenderPeserta = new Chart(chart, config);
        }, 100);
      }).catch(err => {
        vm.toastr(err.response.data.message, 'Error!');
      });
    },
  },
  watch: {
    provinces() {
      const vm = this;
      $('#province').select2({
        placeholder: "Pilih Provinsi",
      })
      .val(vm.paramsChart.province_id);
    },
    cities() {
      const vm = this;
      $('#city').select2({
        placeholder: "Pilih Kota",
      })
      .val(vm.paramsChart.city_id);
    },
  },
  mounted() {
    const vm = this;
    $('#province').select2({
      placeholder: "Pilih Provinsi",
    })
    .val(vm.paramsChart.province_id)
    .on('change', function(v) {
      vm.paramsChart.province_id = $('#province').val();
      vm.paramsChart.city_id = '0';
      vm.getCities();

      vm.getChartJenisPeserta();
      vm.getChartGenderPeserta();
    });
    $('#city').select2({
      placeholder: "Pilih Kota",
    })
    .val(vm.paramsChart.city_id)
    .on('change', function(v) {
      vm.paramsChart.city_id = $('#city').val();

      vm.getChartJenisPeserta();
      vm.getChartGenderPeserta();
    });
    this.getProvince();
    this.getCities();
    this.getChartJenisPeserta();
    this.getChartGenderPeserta();
  }
}
</script>