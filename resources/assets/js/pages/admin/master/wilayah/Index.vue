<template>
    <div class="container mb-8">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin: Wizard-->
                <div class="wizard wizard-2" id="kt_wizard_v2" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin: Wizard Nav-->
                    <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-steps">
                            <template v-for="menu in menus" v-if="rendered">
                                <router-link :to="{name: menu.path}" class="wizard-step" data-wizard-type="step" :data-wizard-state="activeMenu(menu.path)">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-icon">
                                            <i :class="menu.icon"></i>
                                        </div>
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">{{ menu.name }}</h3>
                                        </div>
                                    </div>
                                </router-link>
                            </template>
                        </div>
                    </div>
                    <!--end: Wizard Nav-->
                    <!--begin: Wizard Body-->
                    <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin: Wizard Form-->
                        <router-view></router-view>
                        <!--end: Wizard Form-->
                    </div>
                    <!--end: Wizard Body-->
                </div>
                <!--end: Wizard-->
            </div>
        </div>
    </div>
</template>

<style>
    .wizard.wizard-2{display:-webkit-box;display:-ms-flexbox;display:flex}.wizard.wizard-2 .wizard-nav{padding:0;-webkit-box-flex:0;-ms-flex:0 0 300px;flex:0 0 300px;width:300px;max-width:100%}.wizard.wizard-2 .wizard-nav .wizard-steps{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step{padding:.75rem 1.5rem;position:relative;border-radius:.5rem;-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper{display:-webkit-box;display:-ms-flexbox;display:flex}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-icon{font-size:2.5rem;margin-right:1.1rem;-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-icon i{color:#b5b5c3}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-icon .svg-icon svg g [fill]{-webkit-transition:fill .3s ease;transition:fill .3s ease;fill:#b5b5c3}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-icon .svg-icon svg:hover g [fill]{-webkit-transition:fill .3s ease;transition:fill .3s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-label{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title{color:#181c32;font-weight:500;font-size:1.1rem}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-desc{color:#7e8299}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-arrow{color:#7e8299;font-size:1.25rem}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step .wizard-arrow.last{display:none}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current]{background-color:#f3f6f9;-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon{-webkit-transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,-webkit-box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease;transition:color .15s ease,background-color .15s ease,border-color .15s ease,box-shadow .15s ease,-webkit-box-shadow .15s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon i{color:#3699ff!important}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon .svg-icon svg g [fill]{-webkit-transition:fill .3s ease;transition:fill .3s ease;fill:#3699ff!important}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current] .wizard-icon .svg-icon svg:hover g [fill]{-webkit-transition:fill .3s ease;transition:fill .3s ease}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current]:after{left:100%;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);content:" ";height:0;width:0;border:solid transparent;position:absolute;border-left-color:#f3f6f9;border-width:1rem}.wizard.wizard-2 .wizard-body{width:100%}@media (min-width:992px) and (max-width:1399.98px){.wizard.wizard-2 .wizard-nav{-webkit-box-flex:0;-ms-flex:0 0 325px;flex:0 0 325px;width:325px}}@media (max-width:991.98px){.wizard.wizard-2{display:block}.wizard.wizard-2 .wizard-nav{width:100%;border-bottom:1px solid #ebedf3}.wizard.wizard-2 .wizard-nav .wizard-steps .wizard-step[data-wizard-state=current]:after{content:none}.wizard.wizard-2 .wizard-body{width:100%}}
</style>

<script>
    "use strict";var KTWizard2=function(){var e,t,i,r=[];return{init:function(){e=KTUtil.getById("kt_wizard_v2"),t=KTUtil.getById("kt_form"),(i=new KTWizard(e,{startStep:1,clickableSteps:!1})).on("beforeNext",function(e){i.stop(),r[e.getStep()-1].validate().then(function(e){"Valid"==e?(i.goNext(),KTUtil.scrollTop()):Swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn font-weight-bold btn-light"}}).then(function(){KTUtil.scrollTop()})})}),i.on("change",function(e){KTUtil.scrollTop()}),r.push(FormValidation.formValidation(t,{fields:{fname:{validators:{notEmpty:{message:"First name is required"}}},lname:{validators:{notEmpty:{message:"Last Name is required"}}},phone:{validators:{notEmpty:{message:"Phone is required"}}},email:{validators:{notEmpty:{message:"Email is required"},emailAddress:{message:"The value is not a valid email address"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),r.push(FormValidation.formValidation(t,{fields:{address1:{validators:{notEmpty:{message:"Address is required"}}},postcode:{validators:{notEmpty:{message:"Postcode is required"}}},city:{validators:{notEmpty:{message:"City is required"}}},state:{validators:{notEmpty:{message:"State is required"}}},country:{validators:{notEmpty:{message:"Country is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),r.push(FormValidation.formValidation(t,{fields:{delivery:{validators:{notEmpty:{message:"Delivery type is required"}}},packaging:{validators:{notEmpty:{message:"Packaging type is required"}}},preferreddelivery:{validators:{notEmpty:{message:"Preferred delivery window is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),r.push(FormValidation.formValidation(t,{fields:{locaddress1:{validators:{notEmpty:{message:"Address is required"}}},locpostcode:{validators:{notEmpty:{message:"Postcode is required"}}},loccity:{validators:{notEmpty:{message:"City is required"}}},locstate:{validators:{notEmpty:{message:"State is required"}}},loccountry:{validators:{notEmpty:{message:"Country is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),r.push(FormValidation.formValidation(t,{fields:{ccname:{validators:{notEmpty:{message:"Credit card name is required"}}},ccnumber:{validators:{notEmpty:{message:"Credit card number is required"},creditCard:{message:"The credit card number is not valid"}}},ccmonth:{validators:{notEmpty:{message:"Credit card month is required"}}},ccyear:{validators:{notEmpty:{message:"Credit card year is required"}}},cccvv:{validators:{notEmpty:{message:"Credit card CVV is required"},digits:{message:"The CVV value is not valid. Only numbers is allowed"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}}))}}}();jQuery(document).ready(function(){KTWizard2.init()});
</script>

<script>
    export default {
        data() {
            return{
                rendered: true,
                activeMenuNow: this.$router.currentRoute.name,
                menus: [
                    {name: 'Provinsi', path: 'admin.master.wilayah.province', icon: 'fa fa-globe-americas icon-2x'},
                    {name: 'Kab/Kota', path: 'admin.master.wilayah.city', icon: 'fa fa-globe-asia icon-2x'},
                ]
            }
        },
        methods: {
            activeMenu(menu) {
                if (this.$router.currentRoute.name == menu) { 
                    return 'current';
                } else {
                    return 'pending';
                }
            },
            async reload() {
              this.rendered = false;
              await this.$nextTick();
              this.rendered = true;
            }
        },
        watch: {
            $route(to, from) {
                this.reload()
            }
        },
        updated() {
            if(this.$router.currentRoute.name == 'admin.master.wilayah'){
                this.$router.push({ name: this.menus[0].path});
            }
        },
        mounted() {
            this.$parent.middleware('admin');
            if(this.$router.currentRoute.name == 'admin.master.wilayah'){
                this.$router.push({ name: this.menus[0].path});
            }
        }
    }
</script>