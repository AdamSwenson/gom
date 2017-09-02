<template>
    <table class="table is-striped is-fullwidth roster-table">
        <thead>

        <tr>
            <th v-for="c in columns">
                <header-field :column="c"
                              v-on:toggle-asc-clicked="toggleSortAscending(evt)"
                              v-on:sort-roster-by="sortRosterBy(evt)"
                ></header-field>

            </th>
        </tr>

        </thead>

        <tbody>

        <student-table-row v-for="student in sortedStudents"
                           :key="student.serialNumber"
                           :student="student"
        ></student-table-row>

        </tbody>

        <tfoot>

        </tfoot>

    </table>
</template>

<style lang="scss">
    .roster-table {
        .sort-button {
        }
    }

</style>

<script>
    import studentTableRow from './student-table-row.vue';
    import headerField from './column-header-field.vue';

    export default {

        props: [ 'students' ],

        components: {
            'student-table-row': studentTableRow,
            'header-field': headerField
        },

        data: function () {
            return {
                columns: [
                    {
                        fullText: 'Last name',
                        shortText: 'Last',
                        studentProperty: 'lastName' //The name of the property on the student object this corresponds to
                    },
                    {
                        fullText: 'First name',
                        shortText: 'First',
                        studentProperty: 'firstName'
                    },
                    {
                        fullText: 'Student id',
                        shortText: 'Id',
                        studentProperty: 'studentIdentifier'
                    },
                    {
                        fullText: 'Email address',
                        shortText: 'Email',
                        studentProperty: 'email'
                    },

                ],
                defaults: {},
                icons: {
                    defaultSort: "fa fa-sort",
                    sortAsc: "fa fa-sort-amount-asc",
                    sortDesc: "fa fa-sort-amount-desc"
                },

                sortAsc: true,
                //The name of the property on the student object
                // that the list is currently sorted by
                sortedBy: 'lastName'
            }
        },

        computed: {

            selectedStudents: function () {
                return this.$parent.selectedStudents || [];
            },

            showKumi: function () {
                return this.$parent.showKumi;
            },

            sortedStudents: function () {
                var me = this;
                //sort the students by the given property
                let sorted = _.sortBy( this.students, [ function ( o ) {
                    return o[ me.sortedBy ];
                } ] );

                //they will be ascending when they initially come out
                if ( this.sortAsc ) return sorted;

                //if they need to be descending, reverse the list and return it
                return _.reverse( sorted );
            }

        },

        methods: {
            /**
             * Returns the icon which the
             * user will click to toggle sorting state
             */
            getSortIcon: function ( studentProperty ) {
                //if it isn't the selected column, show the default
                if ( studentProperty !== this.sortedBy ) return this.icons.defaultSort;

                //we are on the selected column
                //so we decide whether to show the up or down icon
                if ( this.sortAsc ) return this.icons.sortAsc;
                return this.icons.sortAsc;
            },

            toggleSortAscending: function ( shortText ) {
                window.console.log( 'student-table', 'toggleSortAscending', 156, shortText);
                //toggle sort ascending
                this.sortAsc = !this.sortAsc;
            },

            /**
             * Reorders rows based on the property passed in
             * @param
             */
            sortRosterBy: function ( shortText ) {
                window.console.log( 'student-table', 'sortRosterBy', 166, shortText);
                //because we are going to sort by a new column
                //we want it to initially be sorted ascending.
                this.sortAsc = true;
                //The user can flip the order by clicking the icon

                //retrieve the object which holds the properties of each column
                let selectedColumnObj = _.find( this.columns, function ( c ) {
                    return c.shortText === shortText;
                } );

                //set the property by which rows should be sorted
                this.sortedBy = selectedColumnObj.studentProperty;
            },

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>