/**
 * Created by adam on 1/9/17.
 */
//var $ = require('jquery');
//window.$ = $;
// let crumbLink = require('./components/crumbLink');

module.exports = {

    template: require('../templates/breadcrumbs.template.html'),

    props: [
        'route-root',
        'active-index',
        'group'
    ],


    data: function () {
        return {

            //Dictionary of links by group
            linkMap: {
                'main': [
                    {
                        label: 'Setup', target: '/setup'
                    },
                    {
                        label: 'Grade', target: '/grade'
                    },
                    {
                        label: 'Report', target: '/report'
                    }],

                'setup': [
                    {
                        label: 'Exam', target: '/setup/exam'
                    },
                    {
                        label: 'Questions', target: '/setup/questions'
                    },
                    {
                        label: 'Elements', target: '/setup/elements'
                    },
                    {
                        label: 'Students', target: '/setup/students'
                    }]
            }
        };
    },

    computed: {
        links:function(){
            return this.linkMap[this.group];
        }
    },

    methods: {
        //   load: (group, position) =>{
        //       return this.links[group][position];
        //   },
        //
        //   setActive: (group, position) =>{
        //   //set all other active values to empty first
        //
        //       //update to be active
        //       let a = this.load(group, position);
        //       a.active = 'active';
        //   },
        //
        //   /**
        //    * Returns the text to display as a label for the link
        //    * @param group
        //    * @param position
        //    * @returns {*}
        //    */
        // getLabel: (group, position) => {
        //     let a = this.load(group,position);
        //     return a.label;
        // },
        //
        //   /**
        //    * Returns the url which the link should reference
        //    * @param group
        //    * @param position
        //    * @returns {*}
        //    */
        //   getTarget: (group, position) => {
        //       let a = this.load(group, position);
        //       return a.target;
        //   }
    },

    directives: {},

    events: {},

    ready: function () {
    },
};

// const v = new Vue({
//     components: {
//         'breadcrumbs' :
//     }}
// )