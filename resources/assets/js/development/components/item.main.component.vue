<template>

    <div class="item-main-component ">
        <div class="row">
            <!--<div class="col-md-2 col-lg-2">-->
                <div class="col-md-1 col-lg-1">
                <h5># {{ index }}</h5>
            </div>
            <!--<div class="col-md-10 col-lg-10">-->
            <div class="col-md-11 col-lg-11">
                <div class="input-group">

                    <item-name :index="index"></item-name>

                        <settings-button :index="index"></settings-button>
                </div>
            </div>
        </div>
    </div>

</template>

<style lang="scss">
    .item-main-component {
        h5 {
            text-shadow: 0 -2px 3px rgba(255, 255, 255, 1),
            0 2px 3px rgba(0, 0, 0, .8),
            0 10px 30px rgba(0, 0, 0, .5);
        }
        .indexDisplay {
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

        props: [ 'index' ],


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
