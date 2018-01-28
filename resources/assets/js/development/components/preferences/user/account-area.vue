<template>
<div class="box account-area">

    <h4 class="title is-4">account</h4>

    <preference-input
            :field-name="userNameShownToStudents"
        :type="userNameVisibility.type"
        :value="userNameShownToStudents"
        :available="userNameVisibility.available"
        v-on:valuechange="handleValueChange"
    >

        <span slot="labelText">{{userNameVisibility.label}}</span>
        <span slot="helpText">{{userNameVisibility.help}}</span>
    </preference-input>

    <preference-input
            :field-name="emailSignature.name"
            :type="emailSignature.type"
            :value="userEmailSignature"
            :available="emailSignature.available"
            v-on:valuechange="handleValueChange"
    >
        <span slot="labelText">{{emailSignature.label}}</span>
        <span slot="helpText">{{emailSignature.help}}</span>
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
                updateMutationName :  ngmTypes.updateUserPreference,

                userNameVisibility : {
                    name: 'userNameShownToStudents',
                    available: true,
                    type: 'text',
                    label : 'User name students see',
                    help: "When your students are notified and receive feedback what name do you want them to see. If you prefer to be called by your title or just your first name, enter it here"
                },

                emailSignature : {
                    name: 'userEmailSignature',
                    available: true,
                    type: 'text',
                    label : 'Email signature to students ',
                    help: "How you want your emails to students signed."

                },

            defaults: {}
            }
        },

        computed: {
            userNameShownToStudents : function (  ) {
                return this.$store.getters[nggTypes.getUserPreference]('userNameShownToStudents');
            },

            userEmailSignature : function (  ) {
                return this.$store.getters[nggTypes.getUserPreference]('userEmailSignature');
            }

        },

        methods: {
        //     handleValueChange: function ( obj ) {
        //         let fieldName = obj.fieldName;
        //         let newVal = obj.value;
        //         let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
        //         this.$store.commit( ngmTypes.updateUserPreference, pl );
        // },
        //
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>