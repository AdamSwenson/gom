<template>

    <a class="column-header-field"
       v-on:click="sortRosterBy"
       v-bind:class="styling"
    >
        <abbr v-bind:title="longText">
            {{shortText}}
        </abbr>
        <span class="sr-only" v-if="isActive">Table is sorted by this column</span>
    </a>

</template>

<style lang="scss">
    .column-header-field {

    }
</style>

<script>
    /**
     * This exists so that the sorted icon can be
     * flipped automatically
     */
    export default {

        props: [ 'column', 'sortedBy' ],

        data: function () {
            return {
                events: {
                    sortEvent : 'sort-roster-by',
                    toggleEvent: 'toggle-asc-clicked'
                },
                icons: {
                    defaultSort: "",
//                    defaultSort: "fa fa-sort",
                    sortAsc: "fa fa-sort-amount-asc",
                    sortDesc: "fa fa-sort-amount-desc"
                },
                styles: {
                    default: "",
                    selected: "has-text-info"
                },
                sortAsc: true,

                defaults: {}
            }
        },

        computed: {
            /**
             * Whether this column is presently selected
             * @returns {boolean}
             */
            isActive: function () {
                return this.sortedBy === this.column.studentProperty;
            },

            longText: function () {
                return this.column.longText;
            },

            shortText: function () {
                return this.column.shortText;
            },

            styling: function () {
                if ( this.isActive ) return this.styles.selected;
                return this.styles.default;
            },

            studentProperty: function () {
                return this.column.studentProperty;
            },
        },

        methods: {
            sortRosterBy: function () {
                window.console.log( 'column-header-field', 'sortRosterBy', 80, this.column.shortText );
                this.$emit( this.events.sortEvent, this.column.shortText );
            },

            toggleSortAscending: function () {
                //don't react to clicks unless the column is selected and an icon is displayed
                // if ( this.studentProperty !== this.$parent.sortedBy ) return true;

                if ( this.studentProperty !== this.sortedBy ) return true;

                window.console.log( 'column-header-field', 'toggleSortAscending', 85, this.column.shortText );
                this.sortAsc = !this.sortAsc;
                this.$emit( this.events.toggleEvent, this.column.shortText );
            }
        }
    }
</script>