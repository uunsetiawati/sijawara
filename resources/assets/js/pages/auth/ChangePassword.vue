<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                                <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                            </g>
                                        </svg>
                                    </span>
                            </span>
                            <h3 class="card-label">
                                Change Password
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="send">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Password Lama</label>
                                    <input type="password" name="old_password" placeholder="Password Lama" v-model="formRequest.old_password" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password" placeholder="Password Baru" v-model="formRequest.password" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Ulangi Password Baru</label>
                                    <input type="password" name="password_confirmed" placeholder="Ulangi Password Baru" v-model="formRequest.password_confirmation" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label></label>
                                    <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
                                    <router-link :to="{name: 'home'}" class="btn btn-sm btn-danger">BATAL</router-link>
                                </div>
                            </div>
                        </form>
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
                formRequest: {},
            }
        },
        methods: {
            send() {
                var vm = this;
                KTApp.block($('.card-body'));
                vm.$http({
                    url: '/user/changePassword',
                    method: 'POST',
                    data: vm.formRequest
                }).then((res) => {
                    KTApp.unblock($('.card-body'));
                    vm.formRequest = {}
                    toastr.success(res.data.data);
                }).catch((error) => {
                    KTApp.unblock($('.card-body'));
                    toastr.error(error.response.data.message);
                });
            }
        },
        mounted() {
            
        }
    }
</script>