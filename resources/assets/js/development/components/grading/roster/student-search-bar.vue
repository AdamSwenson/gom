<template>

    <p class="control has-icons-left search-bar-area">

        <input
                type="text"
                class="input is-small typeahead"
                placeholder="search"
                v-bind:id="boxId"
                v-model="searchVal"
        >
        <span class="icon is-left small">
            <i class="fa fa-search"></i>
        </span>
    </p>

</template>

<style lang="scss">
    .twitter-typeahead {
        width: 100%;
    }

    .Typeahead-input{
        /*background: transparent;*/
    }


    .Typeahead-menu {
        background: whitesmoke;
        opacity: 1;
    }

    .Typeahead-suggestion {
        background: whitesmoke;
    }
</style>

<script>

    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    //Import typeahead which depends on jquery
    var jQuery = require( 'jquery' );
    require( '../../../../libraries/typeahead-0.11.1.js' );

    export default {

        props: [],

        components: {},

        data: function () {
            return {
                searchVal: '',

                boxId: 'student-search-box',

                templates: {
                    suggestion: ( v ) => {
                    }
                },

                options: {
                    hint: true,
                    highlight: true,
                    minLength: 1,

                    classNames: {
                        menu: 'Typeahead-menu',
                        input: 'Typeahead-input',
                        hint: 'Typeahead-hint',
                        selectable: 'Typeahead-selectable',
                        suggestion: 'Typeahead-suggestion'
                    }

                },

                defaults: {}
            }
        },

        asyncComputed: {},

        computed: {

            /**
             * Returns a list of student objects,
             * sorted by whatever criteria is selected
             * in the store
             */
            students: function () {
                let s = this.$store.getters[ 'getSortedStudents' ];
                return (!_.isUndefined( s )) ? s : [];
            },


            /** Student identifier data for the ID search box (typeahead) */
            studentIdents: function () {
                let n = [];
                if ( _.isUndefined( this.students ) ) return n;
                if ( this.students.length === 0 ) return n;
                _.forEach( this.students, function ( student ) {
                    n.push( student.studentIdentifier );
                } );
                return n;
            },

            /** studentNames supplies name data for the search box (typeahead) */
            studentNames: function () {
                let n = [];
                if ( _.isUndefined( this.students ) ) return n;
                if ( this.students.length === 0 ) return n;
                _.forEach( this.students, function ( student ) {
                    n.push( student.nameFirstLast );
                } );
                return n;
            },

        },

        methods: {

            /**
             * Since the typeahead suggestion may
             * return either a student name or student identifier,
             * this determines which has been selected and calls
             * the relevant method to validate the suggestion and
             * dispatch the relevant actions.
             * WARNING: THIS WILL LIKELY BREAK IF A STUDENT HAS AN IDENTIFIER OF 0
             */
            handleSearchResult: function ( query ) {
                //The query returned by typeahead will always
                //be a string. Thus to test whether we have a student id
                //or student name, we start by casting it to an integer.
                let q = _.toInteger( query );

                if ( q === 0 ) {
                    //The _.toInteger method will return 0 if a name was
                    //given to it. Thus we know that the suggestion was a name.
                    //WARNING: THIS WILL LIKELY BREAK IF A STUDENT HAS AN IDENTIFIER OF 0
                    this.handleStudentNameSearchResult( query );
                }
                else {
                    //If q is not 0, it is an identifier.
                    this.handleStudentIdentifierSearchResult( q );
                }
            },

            /**
             * Validates the selected suggested student name and retrieves
             * the corresponding student. Then passes the student to the appropriate
             * handler to be set as the active student.
             */
            handleStudentNameSearchResult: function ( result ) {
                var nameToFind = result.replace( /\s+/g, ' ' );
                var i = this.studentNames.indexOf( nameToFind );

                 if ( i >= 0 ) {
                    this.handleStudentSelection( this.students[ i ] );
                }
                return false;
            },

            /**
             * Handles the successful selection of a suggestion.
             * Takes the student object retrieved and sets it as active
             * and clears the search box.
             *
             * This is shared by the name and id searches.
             *
             * Any other actions which need to be handled on successful
             * searches should be added here.
             */
            handleStudentSelection: function ( student ) {
                this.$store.dispatch( ngaTypes.setStudentAsActive, student );
                this.searchVal = '';
            },

            /**
             * Validates the selected suggested student id and retrieves
             * the corresponding student. Then passes the student to the appropriate
             * handler to be set as the active student.
             */
            handleStudentIdentifierSearchResult: function (result ) {
                var i = this.studentIdents.indexOf( result );
                if ( i >= 0 ) {
                    this.handleStudentSelection( this.students[ i ] );
                }
                return false;
            },

            /**
             * Tries matching the substring in the search query
             * against student names. It calls syncResults (used by
             * typeahead) with a list of possible matching names.
             * @param query
             * @param syncResults
             * @param asyncResults
             */
            substringMatcher: function ( query, syncResults, asyncResults ) {
                // window.console.log( 'student-search-bar', 'nameMatcher', 183, query, _.isNumber(query));
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substringRegex = new RegExp( query, 'i' );

                let pool = _.concat( this.studentNames, this.studentIdents );
                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                _.forEach( pool, function ( n ) {
                    if ( substringRegex.test( n ) ) {
                        matches.push( n );
                    }
                } );

                syncResults( matches );
            }

        },


        mounted: function () {
            var me = this;
            this.$nextTick( function () {

                //This includes both student names and identifiers
                //The method called on selection will sort out which type
                //was selected
                let dataset = {
                    name: 'students',
                    source: this.substringMatcher,
                };

                //Initialize and bind the typeahead to the input box
                jQuery( '#' + me.boxId )
                    .typeahead( me.options, dataset )
                    .bind( 'typeahead:select', function ( ev, suggestion ) {
                        // console.log( 'Selection: ' + suggestion );
                        me.handleSearchResult( suggestion );
                    } );
            } );
        },

    }
</script>