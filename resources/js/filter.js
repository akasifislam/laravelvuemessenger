import Vue from "vue"
import moment from "moment";


Vue.filter('timeformat', function(arg) {
   return moment(arg).format('MMMM Do YYYY, h:mm:ss a')
});

