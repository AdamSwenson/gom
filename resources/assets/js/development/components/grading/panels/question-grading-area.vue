<template>
    <div class="tile is-child">
        <item-input :item="item"
                    :level="level"
        ></item-input>
    </div>


</template>

<style lang="scss">

</style>

<script>

    import ItemInput from '../inputs/item-input.vue';

    export default {
        props: [ 'item', 'level' ],
        name: 'question-grading-area',
        components: {
            ItemInput
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        asyncComputed: {},

        computed: {


        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>