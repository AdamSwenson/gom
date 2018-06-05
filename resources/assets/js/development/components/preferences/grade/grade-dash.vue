<template>
    <div class="grade-dash box connections-area">

        <h4 class="title is-4"> Grading dashboard settings</h4>
        <br>

        <div class="box">

            <preference-toggle
                    :available="timerVisibility.available"
                    :selected="showTimer"
                    v-on:toggled="handleToggle('showTimer')"
            >
                <span slot="labelText"> {{ timerVisibility.label }} </span>
                <span slot="helpText">{{ timerVisibility.help }} </span>

            </preference-toggle>


        </div>
        </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferenceToggle from "../preference-toggle";
    import Payload from '../../../../models/Payload';

    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';

    import inputMixin from '../preferencesInput.mixin';
    export default {
        mixins: [inputMixin],

        props: [],

        components: { PreferenceToggle },

        data: function () {
            return {

                updateMutationName : ngmTypes.updateGradingPreference,

            timerVisibility : {
                available: false,
                label : "Show grading time dashboard ",
                help : "Show how much time you've spent grading this assignment and how long it is expected to take."
            },
                defaults: {}
            }
        },

        computed: {

            showTimer : function (  ) {
                return this.$store.getters[nggTypes.getGradingPreference]('showTimer');
            }
        },

        methods: {
            // handleToggle: function ( fieldName ) {
            //     let newVal = !this[ fieldName ];
            //     let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
            //     this.$store.commit( ngmTypes.updateGradingPreference, pl );
            // }

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>