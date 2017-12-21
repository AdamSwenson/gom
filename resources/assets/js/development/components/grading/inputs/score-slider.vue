<template>
    <input v-bind:id="sliderId"
           type="number"
           class="slider"
           min="0"
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
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    import { sliderSettings, makeCutoffsFromMaxScore } from "../../../../store/modules/scores/commentHelpers";

    export default {

        props: [ 'item' ],

        components: {},

        data: function () {
            return {
                slider: false,

                numberLabels: sliderSettings.valenceLabels.length,

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
            maxScore: function () {
                return !_.isUndefined( this.item ) ? this.item.maxScore : sliderSettings.max;
            },

            score: {
                get: function () {
                    let me = this;

                    if ( !this.isReady() ) return '';
                    // let qs = this.$store.getters.getItemScoreObject( this.item.id, this.student.id );

                    let qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: me.item,
                        student: me.student
                    } );

                    if ( !_.isUndefined( qs ) && !_.isNull( qs ) ) {
                        // if(me.slider) me.slider.setValue(qs.score);
                        return qs.score;
                    }

                    let p = this.$store.dispatch( 'initializeItemScore',
                        { exam: this.exam, item: this.item, student: this.student } );

                    return p.then( function () {
                        qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                            item: me.item,
                            student: me.student
                        } );
                        // window.console.log( 'score-slider', 'get', 79, qs );

                        // if(me.slider) me.slider.setValue(qs.score);
                        return qs.score;
                    } );

                },

                /**
                 * Update the score in the shared data object and send
                 * a request for someone else to record it to the server.
                 *
                 * Note that we use the 'lazy' parameter in the template so that
                 * this only syncs once the change event has fired. That prevents
                 * us from sending two different requests for a two digit score.
                 *
                 * @param score
                 */
                set: function ( score ) {
                    let pl = {
                        exam: this.exam,
                        item: this.item,
                        student: this.student,
                        score: score
                    };
                    this.$store.dispatch( ngaTypes.recordItemScore, pl );
                }
            },

            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : ''
            },

            valenceCutoffs: function () {
                if ( _.isUndefined( this.item ) || _.isUndefined( this.item.maxScore ) ) return [];
                //sliderSettings.valenceCutoffs;

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

            exam: function () {
                return this.$store.getters[ nggTypes.getActiveExam ];
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
            isReady: function () {
                if ( _.isUndefined( this.item ) || _.isNull( this.item ) ) return false;
                if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return false;
                return true;
            },

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