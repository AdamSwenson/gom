<template>


    <student-row v-for="student in students"
                 :key="student.serialNumber"
                 :serialNumber="student.serialNumber"
    ></student-row>


</template>

<style lang="scss">

</style>

<script>
    export default {

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