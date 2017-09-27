<template>

    <a class="header-field"
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
    .header-field {

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

//
//            sortIcon: function () {
//                //if it isn't the selected column, show the default
//                if ( this.studentProperty !== this.$parent.sortedBy ) return this.icons.defaultSort;
//
//                //we are on the selected column
//                //so we decide whether to show the up or down icon
//                if ( this.sortAsc ) return this.icons.sortAsc;
//                return this.icons.sortDesc;
//            },

            studentProperty: function () {
                return this.column.studentProperty;
            },
        },

        methods: {
            sortRosterBy: function () {
                window.console.log( 'column-header-field', 'sortRosterBy', 80, this.column.shortText );
                this.$emit( 'sort-roster-by', this.column.shortText );
            },

            toggleSortAscending: function () {
                //don't react to clicks unless the column is selected and an icon is displayed
                if ( this.studentProperty !== this.$parent.sortedBy ) return true;

                window.console.log( 'column-header-field', 'toggleSortAscending', 85, this.column.shortText );
                this.sortAsc = !this.sortAsc;
                this.$emit( 'toggle-asc-clicked', this.column.shortText );
            }
        }
    }
</script>