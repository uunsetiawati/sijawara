<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-12">
                <div class="card card-custom card-stretch gutter-b bg-diagonal bg-diagonal-success bg-diagonal-r-light">
                    <div class="card-body">
                        <h1 class="font-size-h2 mb-0 text-center text-white">{{ $t('about.about') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-8 offset-md-2 text-center">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://www.youtube.com/embed/sDrEVtx8220" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('about.head_of_departement') }}</h2>
                    </div>
                    <div class="card-body">
                        <p class="font-size-h6" v-html="$t('about.departement_description')"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('about.head_of_upt') }}</h2>
                    </div>
                    <div class="card-body">
                        <p class="font-size-h6">{{ $t('about.upt_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('about.vision') }}</h2>
                    </div>
                    <div class="card-body">
                        <p class="font-size-h6">{{ $t('about.vision_description') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('about.mission') }}</h2>
                    </div>
                    <div class="card-body">
                        <p class="font-size-h6">
                            <ul>
                                <div v-html="$t('about.mission_description')"></div>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header bg-success justify-content-center">
                        <h2 class="card-title font-size-h2 text-white" style="z-index: 2;">{{ $t('about.structure') }}</h2>
                    </div>
                    <div class="card-body text-center">
                        <p class="font-size-h6">{{ $t('about.structure_description') }}</p>
                        <img class="img-fluid" :src="`${base_url}/assets/media/struksi.jpg`">
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
                
            }
        },
        methods: {

        },
        mounted() {
            
        }
    }
</script>