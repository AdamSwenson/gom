<template>
    <div class="item-name-component input-group input-group-lg">

        <span class="input-group-addon" id="basic-addon1">{{index}}{{ displayType }} Name</span>

        <input type="text"
               class="itemName form-control"
               aria-describedby="basic-addon1"
               v-bind:placeholder="placeHolders.privateName"
               v-model="name"
        >

        <div class="input-group-btn">
            <settings-button></settings-button>
            <public-indicator></public-indicator>
        </div>

    </div>
</template>

<style>

</style>
<script>

    import Item from '../../models/Item'
    import Payload from '../../models/Payload'

    import * as mTypes from '../../store/mutation-types'
    import settingsButton from './buttons.item.settings.component.vue'
    import publicIndicator from './buttons.public-control.component.vue'
    //
    export default{

        components : {
            'settings-button': settingsButton,
//            'valence-button': valenceButton,
//            'delete-item-button': deleteButton,
            'public-indicator': publicIndicator,

        },
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
                    let item = this.$store.getters.getItemById( this.id );
                    // let item = this.$store.getters.getItemByIndex( this.index );
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
                let item = this.$store.getters.getItemById( this.id );
                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item != 'undefined' ) {
                    return item.isPublic();
                }
            },
        },

        methods: {
            /**
             * Requests that the item properties area
             * be displayed
             */
            openItemSettings: function () {
                console.log( 'itemName', 'CALLED', 'openItemSettings' );
                this.$dipatch( 'display-settings' );
            },

            isPublic: function () {
                return this.public;
            }
        },

        directives: {},

        events: {
            'toggle-public': function () {
                let item = this.$store.getters.getItemById( this.id );
                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item!= 'undefined' ) {
                    return item.togglePublic();
                }
            }
        },

        mounted: function () {
        },
    };
</script>
