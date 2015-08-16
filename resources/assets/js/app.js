/**
 * Created by adam on 8/13/15.
 */
var Vue = require('vue');

//var gradeSlider = Vue.extend({
//    template: 'slider template here'
//});

var grades = [
    {label: 'A', name: 'A',  minScore: 0, maxScore: 100},
    {label: 'A-', name: 'Aminus', minScore: 0, maxScore: 100},
    {label: 'B+', name: 'Bplus', minScore: 0, maxScore: 100},
    {label:'B', name: 'B', minScore: 0, maxScore: 100},
    {label:'B-', name:'Bminus', minScore: 0, maxScore: 100},
    {label:'C+', name:'Cplus', minScore: 0, maxScore: 100},
    {label:'C', name:'C', minScore: 0, maxScore: 100},
    {label:'C-', name:'Cminus', minScore: 0, maxScore: 100},
    {label:'D+', name:'Dplus', minScore: 0, maxScore: 100},
    {label:'D', name:'D', minScore: 0, maxScore: 100},
    {label:'D-', name:'Dminus', minScore: 0, maxScore: 100},
    {label:'F', name:'F', minScore: 0, maxScore: 100}];

function Grade(gradeName)
{
    this.gradeName = gradeName;
    this.minScore = null;
    this.maxScore = null;
}

Grade.prototype.updateMinScore = function(newMinScore){
    if(this.minScore && this.maxScore){
        if(newMinScore <= this.maxScore)
        {
            this.minScore = newMinScore;
        }
    }else{
        //scores aren't yet set, so no need to check relation
        this.minScore = newMinScore;
    }
}






Vue.component('grade-slider', {
    //template: document.querySelector('#slider-template'),
    template: require('./components/gradeAssignmentSliderTemplate.html'),

    props: ['gradeName', 'gradeLabel', 'gradeOrder'],

    data: function(){
        return {
            gradeLabel: this.gradeLabel,
            gradeName: this.gradeName,
            gradeOrder: this.gradeOrder,
            minScore: null,
            maxScore: null,
            sliderId: this.gradeName + '_slider'
        }
    },

    methods: {
        //addGrade: function(gradeObj) {
        //    this.$set();
        //}
        updateMaxScore: function(v){
            this.maxScore = v;
        },
        updateMinScore: function(v){
            this.updateMinScore = v;
        }

    },
    ready: function(){
        var me = this;
        $('#' + me.sliderId).slider({
            range: true,
            min: 0,
            max: 100,
            values: [me.minScore, me.maxScore],
            slide: function( event, ui ) {
                me.minScore = ui.values[0];
                me.maxScore = ui.values[1];
            }
        });
    }

});

/**
 * Root vue instance. Bound to app
 */
new Vue({
   el: '#app',

    data: {
        title: 'page title',
        minScore: 0,
        maxScore: 50,
        grades : [
            {label: 'A', name: 'A', order: 0},
            {label: 'A-', name: 'Aminus', order: 1},
            {label: 'B+', name: 'Bplus', order: 2},
            {label:'B', name: 'B', order: 3},
            {label:'B-', name:'Bminus', order: 4},
            {label:'C+', name:'Cplus', order: 5},
            {label:'C', name:'C', order: 6},
            {label:'C-', name:'Cminus', order: 7},
            {label:'D+', name:'Dplus', order: 8},
            {label:'D', name:'D', order: 9},
            {label:'D-', name:'Dminus', order: 10},
            {label:'F', name:'F', order: 11}]

},

    methods: {
        updateSlider: function($event){
            window.console.log($event);
        }
    },



    filters: {
        reverse: require('./filters/reverse')
    },

    //components: {}
});

