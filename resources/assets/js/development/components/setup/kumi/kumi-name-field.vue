<template>
        <input type="text"
               class="input kumi-name-field"
               v-bind:id="id"
               v-bind:class="styling"
               v-model="name"/>

</template>

<style lang="scss">
    .kumi-name-field {
        /* todo Add max width and require it to adjust under that*/

        .borderless {
            /*border: none;*/
        }

    }
</style>

<script>
    import Payload from '../../../../models/Payload'
    import Kumi from '../../../../models/Kumi'
    import * as mTypes from '../../../../store/mutation-types';
    import * as aTypes from '../../../../store/action-types';
    import * as gTypes from '../../../../store/getter-types';

    //todo Adjust styling so that box of input is not visible except when selected
    export default{

        props: [ 'kumi' ],

        components: {},

        data: function () {
            return {
//                isSelected: false,
                identifier: 'kumi-name-field',
                inputHighlightClass : 'is-info',
                defaults: {}
            }
        },

        computed: {

            id: function () {
                return this.kumi ? this.identifier + '-' + this.serialNumber : '';
            },

            exam : function (  ) {
              return this.$store.getters[gTypes.getActiveExam];
            },

            examKumis : function (  ) {
                let examKumis = this.$store.getters[ gTypes.getKumisForExam ]( this.exam );
                if ( _.isUndefined( examKumis ) || _.isNull( examKumis ) ) return [];
                return examKumis;
            },

            isAssociatedWithActiveExam : function (  ) {
                return this.examKumis.indexOf(this.kumi) > -1;
            },

            name: {
                get: function () {
                    return this.kumi ? this.kumi.name : '';
                },
                set: function ( v ) {
                    // window.console.log( 'kumi-name-field', 'updateKumiName', 149, this.kumi, v );
                    this.$store.commit( 'updateKumi', Payload.factory( {
                        obj: this.kumi,
                        updateProp: 'name',
                        updateVal: v
                    } ) )
                }
            },

            styling: function () {
                return this.isAssociatedWithActiveExam ? this.inputHighlightClass : '';
            },

        },

        methods: {
        }
    }
</script>