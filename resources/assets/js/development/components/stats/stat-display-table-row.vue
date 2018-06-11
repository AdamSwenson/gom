<template>


    <tr class="stat-display-table-row">
        <th class="stat-label">
            <slot name="label"></slot>

        </th>
        <td class="stat-value">
            <slot name="value"></slot>
        </td>
    </tr>

</template>

<style lang="scss">
    .stat-label {
        /*font-weight: bold;*/
    }

    .stat-value {

    }
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