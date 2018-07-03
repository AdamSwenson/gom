µ<template>

    <div class="item-main field has-addons">

        <p v-if="isItem" class="control">
            <input type="text"
                   class="input indexDisplay is-large"
                   v-model="displayIndex" readonly>
        </p>

        <p class="control is-expanded">
            <item-name
                    :serial-number="serialNumber"
            ></item-name>
        </p>

        <p class="control">
            <settings-button
                    :serial-number="serialNumber"
                    :is-exam="isExam"
            ></settings-button>
        </p>

        <p class="control">
            <children-display-control
                    :serial-number="serialNumber"
                    :is-exam="isExam">
            </children-display-control>
        </p>
    </div>
</template>

<style lang="scss">
    .item-main {
        h5 {
            text-shadow: 0 -2px 3px rgba(255, 255, 255, 1),
            0 2px 3px rgba(0, 0, 0, .8),
            0 10px 30px rgba(0, 0, 0, .5);
        }
        .indexDisplay {
            width: 2em;
            text-shadow: 0 -2px 3px rgba(255, 255, 255, 1),
            0 2px 3px rgba(0, 0, 0, .8),
            0 10px 30px rgba(0, 0, 0, .5);
        }
        /*.itemName {*/
        /*margin-bottom: 0;*/
        /*margin-top: 0;*/
        /*}*/
    }
</style>

<script>

    import ChildrenDisplayControl from '../input/children-display-control.vue'
    // Vue.component( 'children-display-control', childrenDisplayButton )


    import ItemName from '../input/item-name-input.vue'
    // Vue.component( 'item-name', itemName );

    import SettingsButton from '../input/settings-display-control.vue'
    // Vue.component( 'settings-button', settingsButton );


    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as aTypes from '../../../store/action-types'
    import * as mTypes from '../../../store/mutation-types'

    import mixin from './item-buttons.mixin';
    export default {
        mixins :[ mixin],

        components: { ChildrenDisplayControl, ItemName, SettingsButton },
        props: [ 'item' ],

        data: function () {
            return {
                identifiers: {
                    exam: 'exam-main',
                    item: 'item-main'
                },

                placeHolders: {},

                display: {
                    type: {
                        question: 'Q',
                        element: 'E'
                    }
                },

                defaults: {
                    type: '-'
                },
            };
        },

        computed: {

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            position: function () {
                return this.$store.getters.getDepthOfNode( this.serialNumber ) + 1;
            },

            displayIndex: function () {
                if ( this.isExam ) return 'Exam';
                let idx = this.position + 1;
                // let parentIdx = this.$parent.displayIndex;
                // if ( parentIdx ) return `${parentIdx} - ${idx}`;
                return idx;

//                return this.$store.getters.getDepthOfNode(this.serialNumber) + 1;

                //take the depth and make a string like
                // 2.4.5
            },

            /**
             * For questions, this will be the question number
             * For elements it will be the subtask number.
             * todo This should be displayed on the left of the area and update as the item is moved.
             * todo It could also be hidable....
             */
            displayOrder: {
                get: function () {
                    //if question, return q number
                    //if element, return order
                },
                set: function ( v ) {
                }
            },

        },

    };
</script>
