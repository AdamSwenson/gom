<template>
    <input type="text"
           class="input is-large"
           v-bind:placeholder="placeholder"
           v-bind:id="id"
           v-model.lazy="name"
           v-bind:class="styling"
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
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload'
    import Item from '../../../models/Item'

    export default {
        props: [ 'serialNumber' ],


        data: function () {
            return {
                identifiers: {
                    exam: 'exam-name',
                    item: 'item-name'
                },

                placeholders: {
                    item: "Give this item a name",
                    exam: "Give this exam a name"
                },
            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },

            depth: function () {
                return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            },


            height: function () {
                return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            },

            placeholder: function () {
                if ( this.isExam ) {
                    return this.placeholders.exam;
                }
                return this.placeholders.item;
            },
            parentSerialNumber: function () {
                return this.node.parent;
            },

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * The input's css id
             */
            id: function () {
                if ( this.isExam ) return this.identifier;

                return this.identifier + "-" + this.height + '-' + this.depth;
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
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
                            updateVal: value
                        } );
                        this.$store.commit( mTypes.updateItem, pl );
                    }
                }
            },

        },

        methods: {}
    }

</script>
