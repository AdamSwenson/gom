<template>

    <div class="item-main-component input-group input-group-lg">

        <span class="input-group-addon">
            <item-number
                    :index="index"
                    :id="id"
            ></item-number>
        </span>

        <item-name :index="index" :id="id"></item-name>

        <span class="input-group-btn">
            <settings-button
                    :index="index"
                    :id="id"
            ></settings-button>

            <public-indicator
                    :index="index"
                    :id="id"
            >
            </public-indicator>
        </span>
    </div>
</template>

<style lang="scss">
    .itemName {
        margin-bottom: 0;
        margin-top: 0;
    }

</style>

<script>

    import Item from '../../models/Item'
    import Payload from '../../models/Payload'

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

        props: [ 'index', 'id' ],


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
                    item: new Item(),
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

            name: {
                get: function () {
//                    let item = this.$store.getters.getItemById( this.id );
                    let item = this.$store.getters.getItemByIndex( this.index );
                    if ( typeof item != 'undefined' ) {
                        return item.name;
                    }
                },

                set: function ( v ) {
                    let pl = Payload.factory( {id: this.id, index: this.index, updateProp: 'name', updateVal: v} );
                    this.$store.commit( mTypes.updateItem, pl );
                }
            },

            public: function () {
//                let item = this.$store.getters.getItemById( this.id );
                let item = this.$store.getters.getItemByIndex( this.index );

                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item != 'undefined' ) {
                    return item.isPublic();
                }
            },
        },

        methods: {

            isPublic: function () {
                return this.public;
            },

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
