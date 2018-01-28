<template>
    <div class="box setup-labels">

        <h4 class="title is-4">Setup label preferences</h4>
        <br>

        <preference-input
                :field-name="overallName.name"
                :type="overallName.type"
                :value="defaultOverallName"
                :available="overallName.available"
                v-on:valuechange="handleValueChange"
        >
            <span slot="labelText">{{overallName.label}}</span>
            <span slot="helpText">{{overallName.help}}</span>
        </preference-input>

        <preference-input
                :field-name="defaultMax.name"
                :type="defaultMax.type"
                :value="defaultMaxScore"
                :available="defaultMax.available"
                v-on:valuechange="handleValueChange"
        >
            <span slot="labelText">{{defaultMax.label}}</span>
            <span slot="helpText">{{defaultMax.help}}</span>
        </preference-input>

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

        components: { PreferenceInput },

        data: function () {
            return {
                updateMutationName : ngmTypes.updateSetupPreference,
                defaultMax: {
                    name: 'defaultMaxScore',
                    available: true,
                    type: 'number',
                    label: 'The default maximum score for each item',
                    help: "The maximum possible score on the exam is the sum of the maximum scores for each item. This is the default score for each item."
                },

                overallName: {
                    name: 'defaultOverallName',
                    available: true,
                    type: 'text',
                    label: 'What to call the thing you grade',
                    help: "'Exam', 'Paper', 'Quiz', 'Torture session', whatever you want to call it."
                },
                defaults: {}
            }
        },

        computed: {
            defaultOverallName: function () {
                return this.$store.getters[ nggTypes.getSetupPreference ]( 'defaultOverallName' );
            },

            defaultMaxScore: function () {
               return  this.$store.getters[ nggTypes.getSetupPreference ]( 'defaultMaxScore' );
            }
        },

        methods: {
            // handleValueChange: function ( obj ) {
            //     let fieldName = obj.fieldName;
            //     let newVal = obj.value;
            //     let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
            //     this.$store.commit( ngmTypes.updateSetupPreference, pl );
            // }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>