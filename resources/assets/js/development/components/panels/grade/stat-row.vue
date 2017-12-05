<template>
    <tr>
        <th><slot name="label"></slot></th>
        <td><slot name="value"></slot></td>
    </tr>
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