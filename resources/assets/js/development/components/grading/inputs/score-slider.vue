<template>
    <input v-bind:id="sliderId"
           type="number"
           class="score-slider slider"
           v-bind:min="minScore"
           v-bind:max="maxScore"
    >

</template>

<style lang="scss">
    @import "../../../../../sass/libraries/bootstrap-slider";

    .slider.slider-horizontal {
        /*width: 430px;*/
        width: 100%;
        /*margin-right: 35px;*/
    }
    .slider.slider-tick-label{
        /*width: 100px;*/
    }
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
            isParentReady: function () {
                let me = this;
                let isParentReady = this.$store.getters.isReadyToRock;
                if ( isParentReady && this.isReady() ) {
                    // window.console.log( 'score-slider', 'isParentReady', 60, 'REady!' );
                    let p = this.$store.dispatch( 'initializeItemScore',
                        { exam: this.exam, item: this.item, student: this.student } );
                    p.then( function () {
                        //Now we can create the slider, if we did it before,
                        //things would not go well (See GOM-344)
                        if ( !me.slider ) {
                            me.createSlider();
                        }
                        return true;
                    } );
                }
            },


            /**
             * We can't use the score property defined in the mixin since the
             * data the slider needs will be loaded asynchronously.
             * Thus this loads the score data async.
             * We watch the regular computed data in case another process (synchronously)
             * updates the score and we need to correspondingly move the slider
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
                        return qs.score;
                    }

                    //No score object currently exists, so we create one
                    let p = this.$store.dispatch( 'initializeItemScore', {
                        exam: this.exam, item: this.item, student: this.student
                    } );

                    //And then return the newly created store object
                    return p.then( function () {
                        qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                            item: me.item,
                            student: me.student
                        } );

                        return qs.score;
                    } );
                }
            },

        },

        watch: {
            /**
             * Updates the position of the slider if the score (synchronously) changes
             * through external means.
             */
            score: function ( newVal ) {
                if ( this.slider ) this.setSliderScore( newVal );
            },

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
             * Called when an element slider stops movement.
             * Dispatches action to update item score and text (if necessary) and
             * save to server
             *
             * @param slideEvt
             * @param data
             * @param Roster
             * @param callback
             */
            handleElementSliderStopEvent: function ( slideEvt, callback ) {
                // window.console.log( 'score-slider', 'handleElementSliderStopEvent', 114, slideEvt );
                //store the new element score in the data object
                let score = Number( slideEvt.value );

                let pl = {
                    exam: this.exam,
                    item: this.item,
                    student: this.student,
                    score: score
                };
                this.$store.dispatch( ngaTypes.recordItemScore, pl );

                if ( ! _.isUndefined(callback) ) {
                    return callback();
                }
            },

            /**
             * Programmatically set the value of the slider. This does
             * not trigger the update action.
             * Thus this should be used for moving the slider around
             * behind the server's back.
             */
            setSliderScore: function ( score ) {
                this.slider.setValue( score, { triggerSlideEvent: false } );
                // this.slider.refresh();
            },

            createSlider: function () {
                //only create it if it doesn't already exist
                if ( this.slider ) return true;

                let initialScore;
                let me = this;

                //Set the pre-existing score, if it exists
                if ( !_.isUndefined( this.sliderScore ) && !_.isNull( this.sliderScore ) ) {
                    initialScore = this.sliderScore;
                }
                else {
                    //Or, for the times I feel like it should be in the middle initially
                    // let initialScore = this.maxScore / 2;
                    initialScore = 0;
                }

                //Create the slider control
                me.slider = new Slider( me.$el, me.settings );

                //NB, this does not set the value in the store. It only sets the
                //initial state of the control
                me.setSliderScore( initialScore );

                /* When an element slider stops movement,
                   update element score and text (if necessary),
                   then save score, text and time
                */
                jQuery( me.$el ).on( 'slideStop', function ( slideEvt ) {
                    me.handleElementSliderStopEvent( slideEvt );
                } );

            },
        },

        directives: {},

        events: {},

        mounted: function () {
            let me = this;
            // me.$nextTick( function () {


        }
    }
</script>