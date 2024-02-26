"use strict";var KTWizard1=function(){var e,t,i,a=[];return{init:function(){e=KTUtil.getById("kt_wizard_v1"),t=KTUtil.getById("kt_form"),(i=new KTWizard(e,{startStep:1,clickableSteps:!0})).on("beforeNext",function(e){i.stop(),a[e.getStep()-1].validate().then(function(e){"Valid"==e?(i.goNext(),KTUtil.scrollTop()):Swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn font-weight-bold btn-light"}}).then(function(){KTUtil.scrollTop()})})}),i.on("change",function(e){KTUtil.scrollTop()}),a.push(FormValidation.formValidation(t,{fields:{address1:{validators:{notEmpty:{message:"Address is required"}}},postcode:{validators:{notEmpty:{message:"Postcode is required"}}},city:{validators:{notEmpty:{message:"City is required"}}},state:{validators:{notEmpty:{message:"State is required"}}},country:{validators:{notEmpty:{message:"Country is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),a.push(FormValidation.formValidation(t,{fields:{package:{validators:{notEmpty:{message:"Package details is required"}}},weight:{validators:{notEmpty:{message:"Package weight is required"},digits:{message:"The value added is not valid"}}},width:{validators:{notEmpty:{message:"Package width is required"},digits:{message:"The value added is not valid"}}},height:{validators:{notEmpty:{message:"Package height is required"},digits:{message:"The value added is not valid"}}},packagelength:{validators:{notEmpty:{message:"Package length is required"},digits:{message:"The value added is not valid"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),a.push(FormValidation.formValidation(t,{fields:{delivery:{validators:{notEmpty:{message:"Delivery type is required"}}},packaging:{validators:{notEmpty:{message:"Packaging type is required"}}},preferreddelivery:{validators:{notEmpty:{message:"Preferred delivery window is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),a.push(FormValidation.formValidation(t,{fields:{locaddress1:{validators:{notEmpty:{message:"Address is required"}}},locpostcode:{validators:{notEmpty:{message:"Postcode is required"}}},loccity:{validators:{notEmpty:{message:"City is required"}}},locstate:{validators:{notEmpty:{message:"State is required"}}},loccountry:{validators:{notEmpty:{message:"Country is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}}))}}}();jQuery(document).ready(function(){KTWizard1.init()});