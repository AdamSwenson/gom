<template>
    <!-- Used by "edit_question" to hold fields and buttons for an individual question -->
    <div class="item-settings-detail-component">
        <div class="row">
            <div class="col-md-6">

                <div class="question-num-area input-group">

                    <span class="input-group-addon">Question #</span>
                    <input style="width:6em;"
                           type="number"
                           min="0"
                           title="order of the question on the exam"
                           class="form-control input"
                           aria-describedby="basic-addon"
                           v-model="questionNumber"/>

                </div>
            </div>

            <div class="col-md-6">
                <div class="max-score-area" style="text-align: left">
                    <!-- max grade -->
                    <div class="input-group">
                        <span class="input-group-addon">Max Score</span>
                        <input style="width:6em;"
                               type="number"
                               min="0"
                               title="maximum score for this question"
                               class="form-control input"
                               aria-describedby="basic-addon"
                               v-model="maxScore"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="question-text-area col-md-12">
                <div class="form-group">
                            <textarea class="question-text form-control"
                                      rows="3"
                                      placeholder="Enter the full question text (optional)"
                                      v-model="questionText"></textarea>
                </div>
            </div>
        </div>

    </div>
</template>
<style>

</style>
<script>
    /**
     * This is the settings component which contains
     * the more lengthy item text (like the prompt question)
     * as well as other settings, depending on which role it
     * is playing.
     *
     * todo Add an 'other uses of this quetion' area
     * Created by adam on 2/19/17.
     */

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
        props: [ 'index', 'id' ],

        data: function () {
            return {
                placeholders: {
                    questionName: "Enter a brief description of the question or task, e.g. &quot;Causes of the Civil War&quot;",
                    questionText: "Enter the full question text (optional)"
                },
            };
        },

        computed: {

            questionText: {
                get: function () {
                    return this.getter( 'text' );

                },

                set: function ( v ) {
                    this.setter( 'text', v );
                }
            },

            questionNumber: {
                get: function () {

                    return this.getter( 'number' );
                },

                set: function ( v ) {
                    this.setter( 'number', v );
                    // let pl = Payload.factory( {index: this.index, updateProp: 'number', updateVal: v} );
                    // this.$store.commit( mTypes.updateItem, pl );
                }

            },
            maxScore: {
                get: function () {
                    return this.getter( 'maxScore' );
                },

                set: function ( v ) {
                    this.setter( 'maxScore', v )
                }

            },
        },

        methods: {
            getter: function ( name ) {
                let item = this.$store.getters.getItemById( this.id );
                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item != 'undefined' ) {
                    return item[ name ]
                }
            },

            setter: function ( name, value ) {
                let pl = Payload.factory( {index: this.index, updateProp: name, updateVal: value} );
                this.$store.commit( mTypes.updateItem, pl );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        },
    };


</script>
