<template>
    <!-- Used by "edit_question" to hold fields and buttons for an individual question -->
    <div class="item-settings-detail-component">

        <max-score
                :serial-number="serialNumber"
        ></max-score>

        <div class="question-text-area field ">
            <label class="label ">{{ labels.questionText }}</label>

            <p class="control">
                        <textarea v-bind:id="itemTextId"
                                  class="question-text textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.questionText"
                                  v-model="text">
                        </textarea>
            </p>
        </div>

        <tag-display :serial-number="serialNumber" :object-type="'item'"></tag-display>


    </div>

</template>

<style lang="scss">

    .item-settings-detail-component {

    }

    .question-text-area {
        label {
            text-align: left;
        }
    }
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

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import Item from '../../../models/Item'

   // import { loadTagsForItemRequest } from '../../../api/requests/tagRequests';
    import { loadAllUserTagsRequest, loadTagsForItemRequest } from '../../../api/requests/tagRequests';

//    import tagMenu from '../menus/tags-menu.vue';


    export default {
        components :{
//          'tag-menu' : tagMenu
        },

        data: function () {
            return {
                serialNumber: _.toInteger(this.$route.params.serialNumber),
//                active: this.serialNumber,

                showTagMenu: false,

                labels: {
                   questionText: 'Long name or full text'
                },

                placeholders: {
                    questionName: `Enter a brief description of the question or task, e.g. &quot; { $this.questionNameExample }&quot;`,
                    questionText: "Enter the full text or other longer description"
                },
            };
        },

        computed: {
            questionNameExample: function(){
               return "I am the example for the question name";
            },


            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            text: {
                get: function () {
                    if ( this.item instanceof Item ) {
                        return this.item.text;
                    }
                },

                set: function ( value ) {
                    if ( this.item instanceof Item ) {
                        let pl = Payload.factory( {
                            obj: this.item,
                            updateProp: 'text',
                            updateVal:  value
                        } );
                        this.$store.commit( mTypes.updateItem, pl );
                    }
                }
            },

            itemTextId: function () {
                return 'item-text-' + this.serialNumber;
            },

            isDetailTabActive: function () {},


        },


        directives: {},

        events: {},

        created: function () {

//            loadTagsForItemRequest(this.$store, this.item);
        },
    };


</script>
