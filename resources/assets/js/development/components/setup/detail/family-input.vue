<template>
    <div class="family-input">

        <input-and-selector :item="exam"
                            item-prop="family"
                            :options="families"
        >
            <!--<div slot="label">{{label}}</div>-->
            <div slot="disabledOption">{{ disabledOption }}</div>
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
                disabledOption: 'Type',
                helpText: "If you'd like to call this something other than an exam, enter it here",
                label: 'Type',

                families: [ 'exam', 'assignment', 'paper', 'quiz' ]
            }
        },

        computed: {


        },

        methods: {
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>

