<template>
	<!-- <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v1" style="background-image: url(/assets/media/error/bg1.jpg);">
		<div class="kt-error-v1__container">
			<h1 class="kt-error-v1__number" style="-webkit-text-stroke-width: .35rem; -moz-text-stroke-width: .35rem; text-stroke-width: .35rem; -webkit-text-stroke-color: #5d80c1; -moz-text-stroke-color: #5d80c1; text-stroke-color: #5d80c1; color: rgba(255, 255, 255, 0);">404</h1>
			<p class="kt-error-v1__desc">
				OOPS! Halaman yang anda cari tidak ditemukan ...
			</p>
			<p class="kt-error-v1__desc">
				<router-link :to="{name: 'home'}" class="btn btn-primary btn-sm"><i class="flaticon2-left-arrow-1"></i> HALAMAN UTAMA</router-link>
			</p>
		</div>
	</div> -->
	<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url(assets/media/error/bg1.jpg);">
		<!--begin::Content-->
		<h1 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 10rem">404</h1>
		<p class="font-size-h3 text-muted font-weight-normal">OOPS! Halaman yang anda cari tidak ditemukan ...</p>
		<p class="font-size-h3 text-muted font-weight-normal"><a :href="base_url" class="btn btn-primary btn-sm"><i class="flaticon2-left-arrow-1"></i> HALAMAN UTAMA</a></p>
		<!--end::Content-->
	</div>
</template>

<style>
	.kt-error-v1{background-position:50%;background-repeat:no-repeat;background-attachment:fixed;background-size:cover}.kt-error-v1 .kt-error-v1__container .kt-error-v1__number{font-size:150px;margin-left:80px;margin-top:9rem;font-weight:700;color:#595d6e}.kt-error-v1 .kt-error-v1__container .kt-error-v1__desc{font-size:1.5rem;margin-left:80px;color:#74788d}@media (max-width:768px){.kt-error-v1 .kt-error-v1__container .kt-error-v1__number{margin:120px 0 0 3rem;font-size:8rem}.kt-error-v1 .kt-error-v1__container .kt-error-v1__desc{margin-left:3rem;padding-right:.5rem}}
</style>