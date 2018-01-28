<template>
    <input type="text"
           class="input kumi-name-field"
           v-bind:id="id"
           v-bind:class="styling"
           v-model="name"
           v-bind:autofocus="autofocus"
    >

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

    export default {

        props: [ 'kumi' ],

        data: function () {
            return {
                identifier: 'kumi-name-field',
                inputHighlightClass: 'is-info',
                defaults: {}
            }
        },

        computed: {

            id: function () {
                return this.kumi ? this.identifier + '-' + this.kumi.serialNumber : '';
            },

            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },

            isAssociatedWithActiveExam: function () {
                return this.$store.getters.areKumiAndExamAssociated( { kumi: this.kumi, exam: this.exam } );
            },

            autofocus: function () {
                if ( _.isUndefined( this.kumi ) || _.isNull( this.kumi ) ) return false;
                return this.kumi.isNew();
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

        methods: {}
    }
</script>