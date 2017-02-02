/**
 * Created by adam on 1/9/17.
 */

module.exports = {

    template: require('../templates/breadcrumbs.template.html'),

    props: [
        //The base url to add to all the links
        'route-root',

        //The index of the page we are currently on.
        //This will be used to highlight the current link
        //with an active class
        'active-index',

        //Either: 'main' or 'setup'
        'group'
    ],


    data: function () {
        return {
            //Dictionary of links by group
            linkMap: {
                'main': [
                    {
                        label: 'Setup', target: this.routeRoot + '/exam'
                    },
                    {
                        label: 'Grade', target: this.routeRoot + '/grade'
                    },
                    {
                        label: 'Report', target: this.routeRoot + '/report'
                    }],

                'setup': [
                    {
                        label: 'Exam', target: this.routeRoot + '/setup/exam'
                    },
                    {
                        label: 'Questions', target: this.routeRoot + '/setup/questions'
                    },
                    {
                        label: 'Elements', target: this.routeRoot + '/setup/elements'
                    },
                    {
                        label: 'Students', target: this.routeRoot + '/setup/students'
                    }
                ]
            }
        };
    },

    computed: {
        links: function () {
            return this.linkMap[this.group];
        },

        //The valid values of 'group' for the prop
        groups: function () {
            this.linkMap.keys()
        },


    },

    methods: {

        isActive: function($index) {
            return this.activeIndex == $index ? 'active' : '';
        },

        //Returns the link body
        getLink:function($index){
            if(this.activeIndex == $index){
                return this.label;
            }
            return `<a href="${this.target}">${this.label}</a>`;
            }


        },

    directives: {},

    events: {},

    ready: function () {
    },
};