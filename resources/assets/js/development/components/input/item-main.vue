<template>

    <div class="item-main field has-addons">

        <p v-if="isItem" class="control">
            <input type="text"
                   class="input indexDisplay is-large"
                   v-model="displayIndex" readonly>
        </p>

        <p class="control is-expanded">
            <item-name :index="index" :serial-number="serialNumber"></item-name>
        </p>

        <p class="control">
            <settings-button :index="index" :serial-number="serialNumber" :is-exam="isExam"></settings-button>
        </p>
        <p class="control">
            <children-display-control :serial-number="serialNumber" :is-exam="isExam"></children-display-control>
        </p>
    </div>
</template>

<style lang="scss">
    .item-main{
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

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as aTypes from '../../../store/action-types'
    import * as mTypes from '../../../store/mutation-types'

    export default{

        props: [ 'index', 'serialNumber' , 'isExam'],

        data: function () {
            return {

                placeHolders: {
                    privateName: "Enter a descriptive name for this item"
                },

                types: [ 'Question', 'Element' ],

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
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isItem: function(){
              return ! this.isExam;
            },

            position : function(){
                return this.$store.getters.getDepthOfNode(this.serialNumber) + 1;

            },

            displayIndex: function () {
                if(this.isExam) return 'Exam';
                let idx = this.position + 1;
                let parentIdx = this.$parent.displayIndex;
                if(parentIdx) return `${parentIdx} - ${idx}`;
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
//

        },

        methods: {},

        directives: {},

        events: {
            'toggle-public': function () {

            }
        },

        mounted: function () {
        },
    };
</script>
