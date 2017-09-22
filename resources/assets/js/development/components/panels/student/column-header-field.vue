<template>
    <div class="header-field columns">

        <div class="column has-text-left">
            <a v-on:click="sortRosterBy">
                <abbr v-bind:title="longText">
                    {{shortText}}
                </abbr>
            </a>
        </div>

        <div class="column has-text-right">
            <a v-on:click="toggleSortAscending">
                <span class="icon is-small">
                    <i v-bind:class="sortIcon"
                       aria-hidden="true"
                    ></i>
                </span>
            </a>
        </div>

    </div>

</template>

<style lang="scss">
.header-field{

}
</style>

<script>
    /**
     * This exists so that the sorted icon can be
     * flipped automatically
     */
    export default {

        props: [ 'column' ],

        data: function () {
            return {
                icons: {
                    defaultSort: "",
//                    defaultSort: "fa fa-sort",
                    sortAsc: "fa fa-sort-amount-asc",
                    sortDesc: "fa fa-sort-amount-desc"
                },
                sortAsc: true,

                defaults: {}
            }
        },

        computed: {
            longText: function () {
                return this.column.longText;
            },

            shortText: function () {
                return this.column.shortText;
            },

            sortIcon: function () {
                //if it isn't the selected column, show the default
                if ( this.studentProperty !== this.$parent.sortedBy ) return this.icons.defaultSort;

                //we are on the selected column
                //so we decide whether to show the up or down icon
                if ( this.sortAsc ) return this.icons.sortAsc;
                return this.icons.sortDesc;
            },

            studentProperty: function () {
                return this.column.studentProperty;
            },
        },

        methods: {
            sortRosterBy: function () {
                window.console.log( 'column-header-field', 'sortRosterBy', 80, this.column.shortText);
                this.$emit( 'sort-roster-by', this.column.shortText );
            },

            toggleSortAscending: function () {
                //don't react to clicks unless the column is selected and an icon is displayed
                if ( this.studentProperty !== this.$parent.sortedBy ) return true;

                window.console.log( 'column-header-field', 'toggleSortAscending', 85, this.column.shortText);
                this.sortAsc = !this.sortAsc;
                this.$emit( 'toggle-asc-clicked', this.column.shortText );
            }
        }
    }
</script>