import Vue from 'vue';
import './init-components';

window.VueBus = new Vue();

const app = new Vue({
	el: '.section-table'
});