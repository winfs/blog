window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');

require('bootstrap-sass');
window.marked = require('marked');
window.hljs = require('./vendor/highlight.min.js');

Vue.component('parse', require('./components/Parse.vue'));

const app = new Vue({
    el: '#app'
});
