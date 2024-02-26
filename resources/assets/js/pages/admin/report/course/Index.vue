<template>
  <div class="container">
    <div class="card card-custom">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 d-flex align-items-center">
            <div class="d-flex align-items-center">
              <label for="tahun" class="mr-4">Tahun :</label>
              <select name="tahun" id="tahun" v-model="selectedTahun" style="width: 80px">
                <option v-for="tahun in tahuns" :value="tahun">{{ tahun }}</option>
              </select>
            </div>
            <div class="d-flex align-items-center ml-12">
              <label for="category" class="mr-4">Kategori :</label>
              <select name="category" id="category" v-model="selectedCategory" style="min-width: 150px">
                <option value="semua" selected>Semua</option>
                <option v-for="category in categories" :value="category.nm_category">{{ category.nm_category }}</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 my-8">
            <h6>Kursus Mandiri</h6>
            <canvas id="chart-course-mandiri"></canvas>
          </div>
          <div class="col-md-6 my-8">
            <h6>Kursus Online</h6>
            <canvas id="chart-course-online"></canvas>
          </div>
          <div class="col-md-6 my-8">
            <h6>Kursus Offline</h6>
            <canvas id="chart-course-offline"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  data() {
    return {
      tahuns: [],
      selectedTahun: new Date().getFullYear(),
      categories: [],
      selectedCategory: "semua",

      chartCourses: {},
      chartOnlineCourses: {},
      chartOfflineCourses: {},
    }
  },
  methods: {
    getCategories() {
      const vm = this;
      vm.$http({
        url: '/course/category/show',
        method: 'GET'
      }).then(res => {
        vm.categories = res.data.data;
        $('#category').select2({
          minimumResultsForSearch: -1 // Disable search
        })
        .val(vm.selectedCategory)
        .on('change', function(v) {
          vm.selectedCategory = $('#category').val();
        });
      });
    },
    getCourse(type) {
      const vm = this;
      vm.$http({
        url: '/laporan/chart/lineCourses',
        method: 'POST',
        data: { type: type, tahun: vm.selectedTahun, category: vm.selectedCategory },
      }).then(res => {
        if (type == 'mandiri') {
          if (vm.chartCourses.elem) vm.chartCourses.elem.destroy();
          vm.chartCourses = res.data.data;
        } else if (type == 'online') {
          if (vm.chartOnlineCourses.elem) vm.chartOnlineCourses.elem.destroy();
          vm.chartOnlineCourses = res.data.data;
        } else if (type == 'offline') {
          if (vm.chartOfflineCourses.elem) vm.chartOfflineCourses.elem.destroy();
          vm.chartOfflineCourses = res.data.data;
        }
        vm.renderChart(type);
      });
    },
    renderChart(type) {
      const vm = this;
      let chartType = '';
      switch (type) {
        case 'mandiri':
          chartType = 'chartCourses';
          break;

        case 'online':
          chartType = 'chartOnlineCourses';
          break;

        case 'offline':
          chartType = 'chartOfflineCourses';
          break;
      
        default:
          break;
      }

      const labels = vm[chartType].labels;
      const courses = vm[chartType].courses;
      const users = vm[chartType].users;

      const chart = document.getElementById('chart-course-' + type);
      const data = {
        labels: labels,
        datasets: [{
          label: 'Kursus yang dibuat',
          data: courses,
          fill: 'start',
          type: 'bar',
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          order: 2
        }, {
          label: 'Peserta yang bergabung',
          data: users,
          fill: 'start',
          type: 'line',
          borderColor: 'rgb(255, 99, 102)',
          backgroundColor: 'rgba(255, 110, 102, 0.2)',
          tension: 0.2,
          order: 1
        }]
      };
      const config = {
        type: 'line',
        data: data,
        options: {
          legend: {
            position: 'bottom'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                userCallback: function(label) {
                  if (Math.floor(label) === label) return label;
                },
              }
            }],
          },
        }
      };
      vm[chartType].elem = new Chart(chart, config);
    },
  },
  mounted() {
    const vm = this;
    vm.getCategories();
    vm.getCourse('mandiri');
    vm.getCourse('online');
    vm.getCourse('offline');

    const start = new Date().getFullYear() - 4;
    const end = new Date().getFullYear();
    for (let i = start; i <= end; i++) {
      vm.tahuns.push(i);
    }

    $('#tahun').select2({
      minimumResultsForSearch: -1 // Disable search
    })
    .val(vm.selectedTahun)
    .on('change', function(v) {
      vm.selectedTahun = $('#tahun').val();
    });
  },
  watch: {
    selectedTahun() {
      const vm = this;
      vm.getCourse('mandiri');
      vm.getCourse('online');
      vm.getCourse('offline');
    },
    selectedCategory() {
      const vm = this;
      vm.getCourse('mandiri');
      vm.getCourse('online');
      vm.getCourse('offline');
    }
  }

}
</script>