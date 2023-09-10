import Vue from 'vue';
import Vuex from 'vuex';
import house from './house/house';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        house
    },
});
