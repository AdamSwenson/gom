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
    import Item from '../../models/Item'

    export default {
        props: [ 'index', 'described-id' , 'serialNumber'],


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
                    return 'item-name-' + this.serialNumber;
                }
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            name: {
                get: function () {
                    if ( this.item instanceof Item ) {
                        return this.item.name;
                    }
                },

                set: function ( value ) {
                    if ( this.item instanceof Item ) {
                        let pl = Payload.factory( {
                            obj: this.item,
                            updateProp: 'name',
                            updateVal:  value
                        } );
                        this.$store.commit( mTypes.updateItem, pl );
                    }
                }
            },

        },

        methods: {}
    }

</script>
