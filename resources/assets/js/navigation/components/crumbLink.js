/**
 * Created by adam on 1/9/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: `<li class="{{linkClass}}" > <a href="{{target}}">{{label}}</a></li>`,

    props: [
        //The index of the current page
        'active-index',
        //The index of the item being iterated
        'my-index',
        //The link text
        'label',
        //The route
        'target'
    ],

    data: function () {
        return {};
    },

    computed: {
        linkClass: function(){
            if (this.activeIndex == this.myIndex) {
                return 'active';
            }
            return '';
        }
    },

    methods: {},

    directives: {},

    events: {},

    ready: function () {
    },
};