<template>
  <div>
    <span v-if="hasSlot" @click="handleOauth">
      <slot name="register"></slot>
    </span>
    <button v-else id="btn-oauth-google" type="button" @click="handleOauth" class="d-block text-center bg-white border border-gray py-4 rounded text-dark w-100" style="font-size: 1.25rem">
        <img src="assets/media/svg/logos/google-icon.svg" alt="google" width="24" class="max-h-70px mr-2" />
        Google
    </button>
  </div>
</template>

<script>
import postscribe from 'postscribe';
export default {
  methods: {
    handleOauth() {
      const vm = this;
      const btn = KTUtil.getById('btn-oauth-google');
      KTUtil.btnWait(btn, "spinner spinner-center spinner-dark py-8", " ");

      const newWindow = openWindow('', vm.hasSlot ? 'Daftar' : 'Login');
      var timer = setInterval(function() { 
        if(newWindow.closed) {
          clearInterval(timer);
          KTUtil.btnRelease(btn);
        }
      }, 1000);
      fetch('oauth/google').then(res => res.json()).then(data => {
        newWindow.location.href = data.url;
      });
    },
    onMessage (e) {
      const vm = this;
      if (e.origin !== window.origin) {
        return;
      }

      if (e.data.token) {
        vm.login(e.data);
      } else if (e.data.otp && e.data.email && e.data.name && e.data.type) {
        window.location.href = '/register?email=' + e.data.email + '&otp=' + e.data.otp + '&name=' + e.data.name + '&type=' + e.data.type;
      }
    },
    login(data) {
      const vm = this;
      vm.$auth.token(null, data.token);
      vm.$http({
        url: '/auth/user',
        method: 'GET',
      }).then(res => {
        vm.$auth.user(res.data.data);
        vm.$auth.watch.authenticated = true;
        vm.$auth.watch.loaded = true;
        document.cookie = 'rememberMe=false';
        vm.$router.push((localStorage.getItem('redirect_login')) ? JSON.parse(atob(localStorage.getItem('redirect_login'))) : {name: 'home'});

        const btn = KTUtil.getById('btn-oauth-google');
        KTUtil.btnRelease(btn);

        setTimeout(function(){
          postscribe('#core', `<script src="${process.env.MIX_APP_URL}/assets/js/scripts.bundle.js"><\/script>`);
        }, 2000);
      });
    },
  },
  computed: {
    hasSlot() {
      return !!this.$slots.register;
    }
  },
  mounted() {
    window.addEventListener('message', this.onMessage, false)
  },
  beforeDestroy () {
    window.removeEventListener('message', this.onMessage)
  },
}

function openWindow (url, title, options = {}) {
  if (typeof url === 'object') {
    options = url;
    url = '';
  }
  options = { url, title, width: 600, height: 720, ...options };

  const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
  const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top;
  const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width;
  const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height;

  options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft;
  options.top = ((height / 2) - (options.height / 2)) + dualScreenTop;

  const optionsStr = Object.keys(options).reduce((acc, key) => {
    acc.push(`${key}=${options[key]}`);
    return acc;
  }, []).join(',');

  const newWindow = window.open(url, title, optionsStr);
  if (window.focus) newWindow.focus();
  return newWindow;
}
</script>

<style>

</style>