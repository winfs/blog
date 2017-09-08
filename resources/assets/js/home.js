window.$ = window.jQuery = require('jquery');
window.swal = require('sweetalert');
window.Vue = require('vue');

import httpPlugin from 'plugins/http';

require('bootstrap-sass');
window.marked = require('marked');
window.hljs = require('./vendor/highlight.min.js');
window.toastr = require('toastr/build/toastr.min.js');

Vue.use(httpPlugin);

Vue.component('comment', require('./components/Comment.vue'));

Vue.component('parse', require('./components/Parse.vue'));

const app = new Vue({
    el: '#app'
});
