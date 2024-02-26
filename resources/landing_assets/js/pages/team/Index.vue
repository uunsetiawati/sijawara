<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('team.team') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <template v-for="(widyaswara, key) in widyaswaras">
                <div v-if="key == 0" class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 mb-8 kepalaupt">
                            <div class="card card-custom position-relative overflow-hidden" style="cursor: pointer" data-toggle="modal" :data-target="'#' +'team-' +  widyaswara.id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-md-center flex-column flex-md-row">
                                            <img :src="widyaswara.photo_url" :alt="widyaswara.name" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-column">
                                            <div class="bg-success text-white pr-2 pl-2 pt-2 text-center">
                                                <div class="font-weight-bold font-size-h6">Koordinator Widyaiswara</div>
                                            </div>
                                            <div class="bg-success text-white pr-2 pl-2 pt-2 text-center">
                                                <div class="font-weight-bold font-size-h6">{{ widyaswara.name }}</div>
                                            </div>
                                            <div class="bg-success text-white pr-2 pl-2 pb-2 text-center">
                                                <div class="font-weight-bold font-size-h6">{{ widyaswara.position }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" :id="'team-' + widyaswara.id" tabindex="-1" aria-labelledby="popupDetailWidyaiswara" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ widyaswara.name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img :src="widyaswara.popup_url" :alt="widyaswara.name" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="col-md-3 mb-8">
                    <div class="card card-custom position-relative overflow-hidden" style="cursor: pointer" data-toggle="modal" :data-target="'#' +'team-' +  widyaswara.id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-md-center flex-column flex-md-row">
                                    <img :src="widyaswara.photo_url" :alt="widyaswara.name" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="d-flex flex-column">
                                    <div class="bg-success text-white pr-2 pl-2 pt-2 text-center">
                                        <div class="font-weight-bold font-size-h6">{{ widyaswara.name }}</div>
                                    </div>
                                    <div class="bg-success text-white pr-2 pl-2 pb-2 text-center">
                                        <div class="font-weight-bold font-size-h6">{{ widyaswara.position }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" :id="'team-' + widyaswara.id" tabindex="-1" aria-labelledby="popupDetailWidyaiswara" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ widyaswara.name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img :src="widyaswara.popup_url" :alt="widyaswara.name" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<style>
    @media (min-width: 768px) {
        .kepalaupt {
            margin-left: 37.77777%!important;
        }
    }
</style>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                widyaswaras: [],
            }
        },
        methods: {
            getWidyaswara() {
                var vm = this;
                vm.$http({
                    url: '../front/widyaiswara/show',
                    method: 'GET',
                }).then((res) => {
                    vm.widyaswaras = res.data.data
                }).catch((error) => {
                    
                });
            },
        },
        mounted() {
            KTUtil.scrollTop();
            this.getWidyaswara();
        }
    }
</script>