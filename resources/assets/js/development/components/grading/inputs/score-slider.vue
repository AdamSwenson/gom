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
                minScore: 0,

                numberLabels: sliderSettings.valenceLabels.length,

                //This holds the slider object once it is created
                slider: false,

                defaults: {}
            }
        },

        asyncComputed: {
            /**
             * This is a secondary representation of the score
             * for the slider. However, it only exists as a workaround
             * for strange behavior that arises when createSlider gets called
             * before the scores have finished loading.
             */
            sliderScore: {
                get() {
                    let me = this;

                    if ( !this.isReady() ) return '';

                    //First we try getting an existing score object
                    let qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: me.item,
                        student: me.student
                    } );

                    if ( !_.isUndefined( qs ) && !_.isNull( qs ) ) {
                        if ( !me.slider ) {
                            //if the slider doesn't exist yet, we make it
                            me.createSlider( qs.score );
                        }

                        return qs.score;
                    }

                    //No score object currently exists, so we create one
                    let p = this.$store.dispatch( 'initializeItemScore',
                        { exam: this.exam, item: this.item, student: this.student } );

                    //And then return the newly created store object
                    return p.then( function () {
                        qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                            item: me.item,
                            student: me.student
                        } );

                        //Now we can create the slider, if we did it before,
                        //things would not go well (See GOM-344)
                        if ( !me.slider ) {
                            me.createSlider( qs.score );
                        }
                        return qs.score;
                    } );
                }
            },

        },

        watch: {
            /**
             * Updates the position of the slider if the score changes
             * through external means.
             *
             * NB, this is the real value of the item score.
             * It is not watching the sliderScore --that's just a
             * separate property that helps prevent the problems that arise
             * if the slider is created before we have a value from the server.
             */
            score: function ( newVal ) {
                if ( this.slider ) this.setSliderScore( newVal  );
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
                // this.score = slideEvt.value;

                let pl = {
                    exam: this.exam,
                    item: this.item,
                    student: this.student,
                    score: slideEvt.value
                };
                this.$store.dispatch( ngaTypes.recordItemScore, pl );

                if ( typeof callback != 'undefined' ) {
                    return callback();
                }

            },

            setSliderScore: function ( score ) {
                this.slider.setValue( score, { triggerSlideEvent: false } );
                // this.slider.refresh();
            },

            createSlider: function ( initialScore  ) {
                //only create it if it doesn't already exist
                if ( this.slider ) return true;

                let me = this;

                me.slider = new Slider( me.$el, me.settings );
                me.setSliderScore( initialScore );

                /* ----------------- slider listeners --------------- */
                /* When an element slider stops movement,
             update element score and text (if necessary),
             then save score, text and time
             *  */
                jQuery( me.$el ).on( 'slideStop', function ( slideEvt ) {
                    me.handleElementSliderStopEvent( slideEvt );
                } );

                // }, 2000 );
            },
        },

        directives: {},

        events: {},

        mounted: function () {
            let me = this;
            me.$nextTick( function () {
                // me.createSlider()
            } );

        }
    }
</script>