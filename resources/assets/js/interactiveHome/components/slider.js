/**
 * Created by adam on 2/3/16.
 */


var Slider = require("bootstrap-slider");

module.exports = {

    template: require('../templates/slider.template.html'),

    props: [
        'elementNumber',
        'elementName',
        'targetId' //the area to update with comments
    ],

    data: function () {
        return {
            sv: 0,
            sliderValue: 0,
            valenceCutoffs: [0, 3.25, 6.75, 10],
            valenceLabels: ["Missing", "Poor", "Fair", "Excellent"],
            valenceLabelPositions: [0, 33, 67, 100],
            sliderStep: .25,
        }
    },


    computed: {
        sliderValue: {
            set: function(val){
                this.sv = val;
                this.updateSlider(val);
            },

            get: function(){
                return this.sv;
            }
        }
    },

    methods: {
        updateSlider: function (val) {
            var index = this.$parent.chooseValence(val);
            this.$parent.updateComment(this.elementNumber, index);
            window.console.log('updateSlider');
  //          window.console.log(this.elementNumber, this.sliderValue);
        }
    },

    events: {
      'slideStop': function(v){
          window.console.log('slide stopped', v);
      }
    },

    directives: {
        slider: {
            twoWay: true,
            bind: function () {
var me = this;
                $(this.el).slider({
                    tooltip: 'show',
                    value: 0,
                    ticks: [0, 3.25, 6.75, 10],
                    ticks_labels: ["Missing", "Poor", "Fair", "Excellent"],
                    ticks_position: [0, 33, 67, 100],
                    sliderStep: .25
                });
//                    .on('slideStop', function(){
//
////                    me.$dispatch('slideStop', $(this.el).val())
//////
////                    window.console.log($(me.el).val());
////                    this.$parent.updateSlider();
//                });

                $(this.el).change(function() {
                    var value = $(this).val();
                    me.set(value);
                });
            },

            update: function(){
                //this.updateSlider();
            }
        }
    }
};