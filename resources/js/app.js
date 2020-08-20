/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';

// import Element from 'element-ui';
// import locale from 'element-ui/lib/locale/lang/es'

// Vue.use(ElementUI, { locale })
// Vue.use(Element, { size: 'small', zIndex: 3000 });
// Vue.use(ElementUI);
import Vue from 'vue'
import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/antd.css';
import ImgInputer from 'vue-img-inputer'
import 'vue-img-inputer/dist/index.css'
import VueEasyLightbox from 'vue-easy-lightbox'
import Vuetify from 'vuetify'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/es'
// import 'element-ui/lib/theme-chalk/index.css';
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);
Vue.use(ElementUI, { locale })
Vue.component('VueEasyLightbox', VueEasyLightbox)
Vue.component('ImgInputer', ImgInputer)
Vue.use(Antd)
Vue.use(Vuetify)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
Vue.component('miembro-component', require('./components/MiembroComponent.vue').default);
Vue.component('grupo-component', require('./components/GrupoComponent.vue').default);   
Vue.component('ministerio-component', require('./components/MinisterioComponent.vue').default);   
Vue.component('visitante-component', require('./components/VisitanteComponent.vue').default);    
Vue.component('usuarios-component', require('./components/UsuariosComponent.vue').default);    
// Registra una directiva personalizada global llamada `v-focus`

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu:0
        
    },
    
});
