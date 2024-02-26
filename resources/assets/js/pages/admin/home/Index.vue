<template>
	<div class="container mb-8">
		<div class="row">
			<div class="col-md-3">
				<div class="card card-custom card-stretch gutter-b bg-primary" style="cursor: pointer;" @click="gotoPage('admin.master.user')">
					<div class="card-body my-0">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="card-title font-weight-bolder text-white font-size-h3 mb-0 d-block">
									<i class="fa fa-user text-white"></i> Pengguna
								</div>
							</div>
						</div>
						<div class="d-flex flex-row font-size-sm font-weight-bold justify-content-between text-white">
							<span class="font-size-h4">{{ data.user.active }} Aktif</span>
							<span class="font-size-h4">{{ data.user.pending }} Pending</span>
						</div>
						<div class="progress progress-xs bg-white-o-90">
							<div class="progress-bar bg-white" role="progressbar" :style="`width: ${data.user.percent}%;`" :aria-valuenow="data.user.percent" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-danger" role="progressbar" :style="`width: ${(100-data.user.percent)}%;`" :aria-valuenow="(100-data.user.percent)" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card card-custom card-stretch gutter-b bg-warning" style="cursor: pointer;" @click="gotoPage('admin.course.list')">
					<div class="card-body my-0">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="card-title font-weight-bolder text-white font-size-h3 mb-0 d-block">
									<i class="fas fa-chalkboard-teacher text-white"></i> Kursus Mandiri
								</div>
							</div>
						</div>
						<div class="d-flex flex-row font-size-sm font-weight-bold justify-content-between text-white">
							<span class="font-size-h4">{{ data.course.active }} On</span>
							<span class="font-size-h4">{{ data.course.pending }} Off</span>
						</div>
						<div class="progress progress-xs bg-white-o-90">
							<div class="progress-bar bg-white" role="progressbar" :style="`width: ${data.course.percent}%;`" :aria-valuenow="data.course.percent" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-danger" role="progressbar" :style="`width: ${(100-data.course.percent)}%;`" :aria-valuenow="(100-data.course.percent)" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card card-custom card-stretch gutter-b bg-success" style="cursor: pointer;" @click="gotoPage('admin.course.other.list')">
					<div class="card-body my-0">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="card-title font-weight-bolder text-white font-size-h3 mb-0 d-block">
									<i class="fas fa-laptop text-white"></i> Kursus Online
								</div>
							</div>
						</div>
						<div class="d-flex flex-row font-size-sm font-weight-bold justify-content-between text-white">
							<span class="font-size-h4">{{ data.course_online.active }} On</span>
							<span class="font-size-h4">{{ data.course_online.pending }} Off</span>
						</div>
						<div class="progress progress-xs bg-white-o-90">
							<div class="progress-bar bg-white" role="progressbar" :style="`width: ${data.course_online.percent}%;`" :aria-valuenow="data.course_online.percent" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-danger" role="progressbar" :style="`width: ${(100-data.course_online.percent)}%;`" :aria-valuenow="(100-data.course_online.percent)" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card card-custom card-stretch gutter-b bg-info" style="cursor: pointer;" @click="gotoPage('admin.course.other.list')">
					<div class="card-body my-0">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="card-title font-weight-bolder text-white font-size-h3 mb-0 d-block">
									<i class="far fa-building text-white"></i> Kursus Offline
								</div>
							</div>
						</div>
						<div class="d-flex flex-row font-size-sm font-weight-bold justify-content-between text-white">
							<span class="font-size-h4">{{ data.course_offline.active }} On</span>
							<span class="font-size-h4">{{ data.course_offline.pending }} Off</span>
						</div>
						<div class="progress progress-xs bg-white-o-90">
							<div class="progress-bar bg-white" role="progressbar" :style="`width: ${data.course_offline.percent}%;`" :aria-valuenow="data.course_offline.percent" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-danger" role="progressbar" :style="`width: ${(100-data.course_offline.percent)}%;`" :aria-valuenow="(100-data.course_offline.percent)" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				data: {user: {active: 0, pending: 0, percent: 0}, course: {active: 0, pending: 0, percent: 0}, course_online: {active: 0, pending: 0, percent: 0}, course_offline: {active: 0, pending: 0, percent: 0}},
			}
		},
		methods: {
			getDashboard() {
				var vm = this;
				KTApp.block(".card-custom",{
					overlayColor:"#000000",
					type:"v2",
					state:"primary",
					message:"Processing...",
					opacity: 0.3
				});
				vm.$http({
				    url: '/home/getDashboard',
				    method: 'GET',
				}).then((res) => {
					vm.data = res.data.data;
					KTApp.unblock(".card-custom")
				}).catch((error) => {
					KTApp.unblock(".card-custom")				    
				});
			},
			gotoPage(name) {
				this.$router.push({name: name});
			}
		},
		mounted() {
			this.$parent.middleware('admin');
			this.getDashboard()
		}
	}
</script>