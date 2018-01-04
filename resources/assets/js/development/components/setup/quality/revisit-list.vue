<template>
    <div class="revisit-list ">
        <p class="subtitle">Exams to revisit</p>
        <ul id="revisitList" class="list-group">
            <li v-for="studentId in toRevisit">
                {{ studentId }}
            </li>
        </ul>

        <p>(Make sure you copy this list and paste it into a document; it won't be saved after you leave this
            page)</p>
    </div>


</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ['toRevisit'],

        components: {},

        data: function () {
            return {

                defaults: {}
            }
        },

        computed: {
            revisitList: function () {
                if(_.isUndefined(this.toRevisit)) return [];
                return this.toRevisit;
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>