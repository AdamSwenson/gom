<template>
    <div id="public-name-input">

        <input-and-selector :item="exam"
                            item-prop="publicName"
        >
            <div slot="label">{{label}}</div>
            <div slot="helpText">{{ helpText }}</div>

        </input-and-selector>

    </div>


</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload'

    import InputAndSelector from "./input-and-selector.vue";

    export default {

        props: [
            'exam',
        ],

        components: { InputAndSelector },

        data: function () {
            return {
                helpText: "If you would like students to see a different name, enter it here",
                label: 'Public name',
            }
        },

        computed: {

        },

        methods: {
            handleValueChange: function ( v ) {
                // window.console.log( 'year-input', 'handleValueChange', 76, v );
                // this.$store.commit( mTypes.updateItem, Payload.factory( {
                //     index: 0,
                //     updateProp: 'year',
                //     updateVal: v
                // } ) );

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>