<template>
    <input v-bind:id="sliderId"
           type="number"
           class="score-slider slider"
           v-bind:min="minScore"
           v-bind:max="maxScore"
           v-model="score"
    >

</template>

<style lang="scss">

</style>


<script>

    var jQuery = require( 'jquery' );
    window.jQuery = jQuery;
    require( 'bootstrap' );
    // var Slider = require("bootstrap-slider");
    var Slider = require( "../../../../libraries/bootstrap-slider-modified.js" );

    import PayloadScore from '../../../../models/PayloadScore';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    import { sliderSettings, makeCutoffsFromMaxScore } from "../../../../store/modules/scores/commentHelpers";

    import scoreInputMixin from './scoreInputMixin';

    export default {
        mixins: [
            scoreInputMixin
        ],

        props: [ 'item' ],

        components: {},

        data: function () {
            return {
                minScore : 0,

                numberLabels: sliderSettings.valenceLabels.length,

                //This holds the slider object once it is created
                slider: false,

                defaults: {}
            }
        },
        watch: {
            score : function ( newVal ) {
                if(this.slider) this.slider.setValue(newVal);

            },
            valenceCutoffs: function ( newVal ) {
                var me = this;
                //
                // if (newVal.length === this.numberLabels ){
                //     window.console.log( 'score-slider', 'valenceCutoffs', 51, newVal);
                //     this.$nextTick( function () {
                //         window.console.log( 'score-slider', 'nt', 53, );
                //         this.createSlider();
                //     } );

                // }
            }
        },

        computed: {
            //maxScore , score, and exam are defined in the mixin

            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : ''
            },

            valenceCutoffs: function () {
                if ( _.isUndefined( this.item ) || _.isUndefined( this.item.maxScore ) ) return [];

                return makeCutoffsFromMaxScore( this.item.maxScore, this.numberLabels );
            },

            settings: function () {
                return {
                    tooltip: 'show',
                    step: sliderSettings.sliderStep,
                    ticks: this.valenceCutoffs,
                    ticks_labels: sliderSettings.valenceLabels,
                    ticks_position: sliderSettings.valenceLabels
                    // id: Counter()
                }
            },

            /**
             * Returns the string id of the slider element
             * @returns {string}
             */
            sliderId: function () {
                if ( this.item ) {
                    return "slider" + this.item.serialNumber;
                }
            },

        },

        methods: {
            // isReady defined in mixin

            /**
             * Called when an element slider stops movement. Updates element
             * score and text (if necessary), then saves score, text and time
             * @param slideEvt
             * @param data
             * @param Roster
             * @param callback
             */
            handleElementSliderStopEvent: function ( slideEvt, callback ) {
                // window.console.log( 'score-slider', 'handleElementSliderStopEvent', 114, slideEvt );
                //store the new element score in the data object
                this.score = slideEvt.value;

                if ( typeof callback != 'undefined' ) {
                    return callback();
                }

            },

            setSliderScore: function ( score ) {
                this.slider.setValue( score, {triggerSlideEvent : false} );
                // this.slider.refresh();
            },

            createSlider: function () {
                let me = this;

                //todo fix async loading of slider and remove this workaround
                setTimeout( function () {
                    me.slider = new Slider( me.$el, me.settings );
                    me.setSliderScore( this.score );

                    // window.console.log( 'score-slider', 'createSlider', 193, mySlider.getValue() );

                    /* ----------------- slider listeners --------------- */
                    /* When an element slider stops movement,
                     update element score and text (if necessary),
                     then save score, text and time
                     *  */
                    jQuery( me.$el ).on( 'slideStop', function ( slideEvt ) {
                        me.handleElementSliderStopEvent( slideEvt );
                    } );

                }, 2000 );
            },
        },

        directives: {},

        events: {},

        mounted: function () {
            let me = this;
            me.$nextTick( function () {
                me.createSlider();
            } );

        }
    }
</script>