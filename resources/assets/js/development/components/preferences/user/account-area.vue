<template>
<div class="box account-area">

    <h4 class="title is-4">account</h4>

    ll



    ll
</div>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {
            preferences : function (  ) {
                return this.$store.getters.getUserPreferences;
            },

            userNameShownToStudents : function (  ) {

            },

            userEmailSignature : function (  ) {

            }
        },

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