<template>

    <div class="item-main-component">
        <div class="input-group">
            <div class="input-group-addon"
                 id="basic-addon2"
            ># {{ index }}
                <!--<div class="input-group-addon" id="itemnum">-->
                <!--<item-number :index="index"></item-number>-->
            </div>

            <item-name :index="index"></item-name>

            <div class="input-group-btn">
                <settings-button :index="index"></settings-button>

                <public-indicator :index="index"></public-indicator>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    /*.itemName {*/
    /*margin-bottom: 0;*/
    /*margin-top: 0;*/
    /*}*/

</style>

<script>

    import Item from '../../models/Item'
    import Payload from '../../models/Payload'
    import * as aTypes from '../../store/action-types'
    import * as mTypes from '../../store/mutation-types'
    //    import settingsButton from './buttons.settings-control.component.vue'
    //    import publicIndicator from './buttons.public-control.component.vue'
    //    //
    export default{
//
//        components : {
//            'settings-button': settingsButton,
////            'valence-button': valenceButton,
////            'delete-item-button': deleteButton,
//            'public-indicator': publicIndicator,
//        },

        props: [ 'index'],


        data: function () {
            return {

                placeHolders: {
                    privateName: "Enter a descriptive name for this item (e.g., Cat petting amount )"
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
//            name: {
//                get: function () {
////                    let item = this.$store.getters.getItemById( this.id );
//                    let item = this.$store.getters.getItemByIndex(this.index);
//                    if ( typeof item !== 'undefined' ) {
//                        return item.name;
//                    }
//                },
//
//                set: function ( v ) {
//                    let pl = Payload.factory({ index: this.index, updateProp: 'name', updateVal: v});
//                    this.$store.commit(mTypes.updateItem, pl);
//                }
//            },

        },

        methods: {

        },

        directives: {},

        events: {
            'toggle-public': function () {

            }
        },

        mounted: function () {
        },
    };
</script>
