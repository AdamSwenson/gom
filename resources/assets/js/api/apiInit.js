/**
 * Created by adam on 4/2/17.
 */
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'


axios.defaults.baseURL = routeRoot;
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, axios );

export default function (  ) {

}