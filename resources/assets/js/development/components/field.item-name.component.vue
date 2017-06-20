<template>
    <input type="text"
           class="input is-large"
           v-bind:placeholder="placeHolders.privateName"
           v-bind:id="id"
           v-model="name"
    >


</template>
<style lang="scss">
    .item-name-component {

        .item-type {
            font-weight: bold;
        }

        input {
            /*width: 4em;*/
            /*outline: none;*/
        }

    }


</style>
<script>
    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
        props: [ 'index', 'described-id' , 'serial-number'],


        data: function () {
            return {

                placeHolders: {
                    privateName: "Enter a descriptive name for this item "

                },
            };
        },

        computed: {
            id: {
                get: function () {
                    return 'item-name-' + this.index;
                }
            },

            name: {
                get: function () {
//                    let item = this.$store.getters.getItemById( this.id );
                    let item = this.$store.getters.getItemBySerialNumber( this.serialNumber);

//                    let item = this.$store.getters.getItemByIndex( this.index );
                    if ( typeof item != 'undefined' ) {
                        return item.name;
                    }
                },

                set: function ( v ) {
                    let pl = Payload.factory( { index: this.index, updateProp: 'name', updateVal: v } );
                    this.$store.commit( mTypes.updateItem, pl );
                }
            },


        },

        methods: {}
    }

</script>
