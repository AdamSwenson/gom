/**
 * Created by ars62917 on 2/22/16.
 */

module.exports = {

    template: require('../templates/element-distribution-charts-buttons.template.html'),

    props: [
        'element-key',
        'element-name'
    ],

    data: function () {
    },

    computed: {

    },

    methods: {
        showElementHistogram: function(){
            this.$dispatch('element-histogram-draw', {'elementKey': this.elementKey, 'elementName': this.elementName});
        },
        showElementBoxplot: function() {
            this.$dispatch('element-boxplot-draw', {'elementKey': this.elementKey, 'elementName': this.elementName});
        }
    },

}