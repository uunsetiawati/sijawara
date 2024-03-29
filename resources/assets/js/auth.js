import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'
/**
 * Authentication configuration, some of the options can be override in method calls
 */
const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'authToken',
    tokenStore: ['localStorage'],

    loginData: {
        url: 'auth/login', 
        method: 'POST', 
        redirect: {name: 'home'}, 
        fetchUser: true
    },
    logoutData: {
        url: 'auth/logout', 
        method: 'POST', 
        redirect: {name: 'login'}, 
        makeRequest: false
    },
    fetchData: {
        url: 'auth/user', 
        method: 'GET', 
        enabled: true
    },
    refreshData: {
        url: 'auth/refresh', 
        method: 'GET', 
        enabled: true, 
        interval: 30,
    }
}
export default config