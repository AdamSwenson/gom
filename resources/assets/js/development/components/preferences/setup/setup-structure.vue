<template>
    <div class="box connections-area">


        <h4 class="title is-4">Setup structure preferences</h4>

      <p>  </p>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferenceInput from "../preference-input";
    import Payload from '../../../../models/Payload';

    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import inputMixin from '../preferencesInput.mixin';
    export default {
        mixins: [inputMixin],

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>