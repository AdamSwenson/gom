<template>

    <div class="exam-max-score-input">
        <input-and-selector :item="exam"
                            item-prop="customMaxScore"
        >
            <div slot="label">{{label}}</div>
            <div slot="helpText">{{ helpText }}</div>

        </input-and-selector>

    </div>

</template>
<style lang="scss">
    .exam-max-score-input {

    }

</style>
<script>
    import InputAndSelector from "./input-and-selector";

    export default {
        components: { InputAndSelector },
        props: [ 'exam' ],

        data: function () {
            return {

                label: 'Custom maximum score',

                helpText: 'Enter a value here if you want the maximum possible score for the exam to be something other than the sum of all item max scores.',

                placeholders: {
                    'score': 100
                },

                defaults: {
                    score: 100,
                }
            };
        },

        computed: {},

        methods: {}
    }


</script>
