require('../../assets/js/bootstrap');

window.Vue = require('vue');

import _ from 'lodash';

import VueRouter from 'vue-router';
import router from './router';
Vue.router = router;
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1`

import App from './pages/App';

import VueI18n from 'vue-i18n';
import lang from './lang/lang.js'
Vue.use(VueI18n, lang);

const i18n = new VueI18n({
   locale: localStorage.getItem('locale') ? localStorage.getItem('locale') : 'id',
   messages: lang
})

const StylePlugin = {
  install(Vue) {
    Vue.mixin({
      mounted() {
        const css = this.$options.style;
        if (!css) return;
        this.$styleTag = document.createElement('style');
        this.$styleTag.appendChild(document.createTextNode(css));
        $("link[name=gfont]").after(this.$styleTag)
        // document.head.appendChild();
      },
      destroyed() {
        if (this.$styleTag) {
          this.$styleTag.remove();
        }
      }
    });
  }
};

Vue.use(StylePlugin);

String.prototype.ucfirst = function() {
    return `${this[0].toUpperCase()}${this.slice(1)}`
}

String.prototype.strip_tags = function() {
    var str = this.toString();
    return str.replace(/<\/?[^>]+>/gi, '');
}

String.prototype.ucword = function() {
    var str = this;
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    return str;
}

String.prototype.indo = function() {

    var months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    var date = this.split('-');
    var day = date[2];
    var month = parseInt(date[1]);
    var year = date[0];
    return day + ' ' + months[month] + ' ' + year;
}

String.prototype.tgl_indo = function(time=false) {

    var months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    var d = this.split(' ');
    var date = d[0].split('-');
    var day = date[2];
    var month = parseInt(date[1]);
    var year = date[0];
    if(time){
        return day + ' ' + months[month] + ' ' + year + ' '+d[1];
    }else{
        return day + ' ' + months[month] + ' ' + year;
    }
}

Number.prototype.rupiah = function() {
    var str = this.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return str;
}

String.prototype.rupiah = function() {
    var str = this.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return str;
}

Vue.config.productionTip = false;

Vue.mixin({
  data: function() {
    return {
      get api_url() {
        return `${process.env.MIX_APP_URL}/api/v1`;
      },
      get base_url() {
        return `${process.env.MIX_APP_URL}`;
      },
      get app_name() {
        return `${process.env.MIX_APP_NAME}`;
      }
    }
  }
})

axios.interceptors.response.use(null, function(error) {
    if (error.response.status === 503) {
        var title = error.response.data.message.title;
        var html = error.response.data.message.description;
        return swal.fire({
          title: '<strong>'+title+'</strong>',
          icon: 'error',
          html: html,
        }).then(function() {document.location.reload()})
    }
  return Promise.reject(error);
});

axios.interceptors.request.use((config) => {
  config.params = {...config.params, hl: localStorage.getItem('locale') ? localStorage.getItem('locale') : 'id'}
  return config
})


const app = new Vue({
    render: h => h(App),
    router: router,
    i18n,
}).$mount('#app');


$(function() {
    var cssRule = "display:block;width:200px;border-radius: 3px 0 0 3px;padding:3px 15px;background:#108bc3;color:#FFF;font-size: 30px;font-family:Arial, Helvetica, sans-seriffont-weight: bold;";
    var cssRule2 ="display:block;border-radius: 0 3px 3px 0;padding:3px 15px;background:#fff;color:#666;font-size: 30px;font-family:Arial, Helvetica, sans-serif;";
    console.log("%cMCFLYON"+"%cSystem, Apps & Website Development", cssRule,cssRule2);
    var cssRule = "border-radius: 3px 0 0 3px;padding:3px 15px;background:#35495e;color:#fff;font-size: 12px;font-weight: bold;";
    var cssRule2 = "border-radius:0px;padding:3px 0px;background:#35495e;color:#FF5722;padding-left:0px;font-size: 12px;font-weight: bold;";
    var cssRule3 = "border-radius: 0 3px 3px 0;padding:3px 15px;background:#35495e;color:#108bc3;font-size: 12px;font-weight: bold;";
    console.log("%cThis System Development by Mcflyon Teknologi Indonesia visit"+"%c@"+"%chttps://www.mcflyon.co.id", cssRule,cssRule2,cssRule3);
    console.log("%cSIJAWARA %cv2.0 © 2020-"+(new Date()).getFullYear(), "display:block;width:200px;border-radius: 3px 0 0 3px; padding:3px 15px;background:#41b883;color:#FFF;font-size: 14px;font-family:Arial, Helvetica, sans-seriffont-weight: bold;", "display:block;width:200px;border-radius: 0 3px 3px 0; padding:3px 15px;background:#35495e;color:#FFF;font-size: 14px;font-family:Arial, Helvetica, sans-seriffont-weight: bold;")
});