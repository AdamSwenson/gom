<template>
    <p class="control  kumi-name-field">
        <input type="text"
               class="input "
               v-bind:id="id"
               v-bind:class="styling"
               v-on:select="handleSelect"
               v-model="name"
        />
    </p>
</template>

<style lang="scss">
    .kumi-name-field {
        /* todo Add max width and require it to adjust under that*/

        .borderless {
            border: none;
        }

    }
</style>

<script>
    import Payload from '../../../models/Payload'
    import Kumi from '../../../models/Kumi'
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';

    //todo Adjust styling so that box of input is not visible except when selected
    export default{

        props: [ 'serialNumber' ],

        components: {},

        data: function () {
            return {
//                isSelected: false,
                identifier: 'kumi-name-field',
                defaults: {}
            }
        },

        asyncComputed: {
            kumi: function () {
                return this.$store.getters.getKumiBySerialNumber( this.serialNumber );
            },

        },

        computed: {
            isSelected: function () {
                if ( _.isUndefined( this.kumi ) ) return false;

                return this.kumi === this.$store.getters.getSelectedKumi
            },

            styling: function () {
                //show vs hide input box
                if ( !this.isSelected ) {
//                    return 'borderless';
                }
            },

            id: function () {
                return this.kumi ? this.identifier + '-' + this.serialNumber : '';
            },
            name: {
                get: function () {
                    return this.kumi ? this.kumi.name : '';
                }
                ,
                set: function ( v ) {
                    window.console.log( 'kumi-name-field', 'updateKumiName', 149, this.kumi, v );
                    this.$store.commit( 'updateKumi', Payload.factory( {
                        obj: this.kumi,
                        updateProp: 'name',
                        updateVal: v
                    } ) )
                }
            }
        },

        methods: {
            handleSelect: function () {
                this.$store.commit( 'updateSelectedKumi',
                    Payload.factory( { obj: this.kumi } )
                );
//                this.isSelected = ! this.isSelected;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>