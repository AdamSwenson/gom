<template>
    <div id="student-table-component">
        <div id="student-table-area"
             class="panel-block"
        >
            <table class="table is-striped is-narrow is-fullwidth roster-table">
                <thead>

                <tr>
                    <th>
                        <a v-on:click="toggleSortAscending">
                            <span class="icon is-small">
                                <i v-bind:class="sortIcon" aria-hidden="true"></i>
                            </span>
                            <span class="sr-only" v-if="sortAsc">Sorted in ascending order. Clicking here toggles between ascending and descending sort</span>

                            <span class="sr-only" v-else>Sorted in descending order. Clicking here toggles between ascending and descending sort</span>
                        </a>
                    </th>

                    <th v-for="c in columns">
                        <header-field :column="c"
                                      :sortedBy="sortedBy"
                                      v-on:toggle-asc-clicked="toggleSortAscending"
                                      v-on:sort-roster-by="sortRosterBy"
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


            </table>
        </div>

    </div>

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
    //    import autoCloseModal from '../../helpers/auto-closing-modal.vue';
    import Payload from '../../../../models/Payload';

    export default {

        props: [ 'students' ],

        components: {
//            'auto-close-modal': autoCloseModal,
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

                messages: {
                    noRowsSelected: "Please select at least one row by clicking outside of the input areas."
                },

                icons: {
                    defaultSort: "fa fa-sort",
                    sortAsc: "fa fa-sort-amount-asc",
                    sortDesc: "fa fa-sort-amount-desc"
                },

                isErrorModalVisible: false,
//                selectedStudents: [],
                sortAsc: true,
                //The name of the property on the student object
                // that the list is currently sorted by
                sortedBy: 'lastName'
            }
        },

        computed: {
            selectedStudents: function () {
                return this.$store.getters.getSelectedStudents;
            },

            /**
             * Whether to display the move and delete buttons
             */
            isOpsButtonsAreaVisible: function () {
                return this.selectedStudents.length > 0;
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
            },


            sortIcon: function () {
                //if it isn't the selected column, show the default
           //     if ( this.studentProperty !== this.sortedBy ) return this.icons.defaultSort;

                //we are on the selected column
                //so we decide whether to show the up or down icon
                if ( this.sortAsc ) return this.icons.sortAsc;
                return this.icons.sortDesc;
            },

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
                return this.icons.sortDesc;
            },


            // handleRowSelectionEvent: function ( { obj, isSelected } ) {
            //     window.console.log( 'student-table', 'handleRowSelectionEvent', 136, obj, isSelected );
            //     if ( isSelected ) {
            //         //The row is newly selected
            //         //Add the student to selectedStudents
            //         this.$store.commit( 'selectStudent', Payload.factory( { obj: obj, mutateSilently: true } ) );
            //     }
            //     else {
            //         //it was already selected, so remove it
            //         this.$store.commit( 'deselectStudent', Payload.factory( { obj: obj, mutateSilently: true } ) );
            //     }
            // },


            toggleSortAscending: function ( shortText ) {
                window.console.log( 'student-table', 'toggleSortAscending', 156, shortText );
                //toggle sort ascending
                this.sortAsc = !this.sortAsc;
            },

            /**
             * Reorders rows based on the property passed in
             * @param
             */
            sortRosterBy: function ( shortText ) {
                window.console.log( 'student-table', 'sortRosterBy', 166, shortText );
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
    }
</script>