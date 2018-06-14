<!--<template>-->
    <!--<div class="kumi-panel">-->
        <!--<h4>Create or edit a class section, course, or other group of students</h4>-->
        <!--<div class="tile">-->
            <!--<p class="control">-->
                <!--Selector with existing Kumi here-->
            <!--</p>-->

            <!--<a v-for="kumi in kumis" v-on:click="handleKumiSelection(kumi.serialNumber)">-->
                <!--<kumi-name :serialNumber="kumi.serialNumber"></kumi-name>-->
            <!--</a>-->

        <!--</div>-->
        <!--<div class="tile">-->
            <!--<h4>New</h4>-->
            <!--<p class="control">-->
                <!--<input type="text" class="input" v-model="name"/>-->
            <!--</p>-->

            <!--<p class="control">-->
                <!--<input type="text" class="input" v-model="year"/>-->
            <!--</p>-->
        <!--</div>-->

        <!--<div class="tile">-->
            <!--<h4>Students</h4>-->
        <!--</div>-->

        <!--<div class="tile">-->
            <!--<h4>Exams and assignments</h4>-->
        <!--</div>-->


    <!--</div>-->

<!--</template>-->
<!--<style>-->
<!--</style>-->
<!--<script>-->

    <!--export default {-->

        <!--props: [],-->

        <!--data: function () {-->
            <!--return {-->
                <!--serialNumber: _.toInteger( this.$route.params.serialNumber ),-->
            <!--};-->
        <!--},-->

        <!--asyncComputed: {-->
            <!--kumi: function () {-->
                <!--return this.$store.getters.getKumiBySerialNumber(this.serialNumber);-->
            <!--},-->
            <!--name: function () {-->
                <!--return this.kumi ? this.kumi.name : '';-->
            <!--},-->
            <!--year: function () {-->
                <!--return ''; //this.kumi.year;-->
            <!--}-->
        <!--},-->

        <!--methods: {},-->

        <!--directives: {},-->

        <!--events: {},-->

        <!--ready: function () {-->
        <!--}-->

    <!--};-->

<!--</script>-->