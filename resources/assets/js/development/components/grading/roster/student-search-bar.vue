<template>

    <p class="control has-icons-left">

        <input
                type="text"
                class="input is-small typeahead"
                placeholder="search"
                v-bind:id="boxId"
                v-model="toFind"
        >
        <span class="icon is-small is-left">
        <i class="fa fa-search"></i>
      </span>
    </p>

</template>

<style lang="scss">

</style>

<script>
    var $ = require( 'jquery' );
    window.$ = $;
    var jQuery = $;
    window.jQuery = jQuery;

    require( 'bootstrap' );
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';


    // var typeahead = require( '../../../../libraries/typeahead.bundle.js' );
    // var typeahead = require( '../../../../libraries/bootstrap3-typeahead.min.js' );
    require( '../../../../libraries/typeahead-0.11.1.js' );
    // var Bloodhound = require('../../../../libraries/bloodhound-0.11.1.js');

    // import {Bloodhound, typeahead} from  '../../../../libraries/typeahead-0.11.1.js';


    export default {

        props: [],

        components: {},

        data: function () {
            return {
                searchVal: '',

                boxId: 'student-search-box',
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


            activeStudent: {
                get: function () {
                    return this.$store.getters[ nggTypes.getActiveStudent ];
                },
                set: function ( student ) {
                    this.$store.dispatch( ngaTypes.setStudentAsActive, student );
                }
            },

            toFind: {
                get: function () {
                    return this.searchVal;
                },
                set: function ( searchText ) {
                    //even though the model is bound to the
                    //text box value, we can't just set the student
                    //with every change. That's because the typeahead
                    //dialog will fill the field with invalid names
                    //while substrings are searched. Thus, we will
                    //use a method to check if the text is valid
                    //and let it handle dispatching the action.
                    // That is the responsibility of an event listener


                    this.searchVal = searchText;

                    // this.$store.dispatch( ngaTypes.setStudentAsActive, student );
                }
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

            /** Total number of students */
            numStudents: function () {
                return !_.isUndefined( this.students ) ? this.students.length : null;
            },

        },

        methods: {

            handleSearch:function(query){
              let q = _.toInteger(query);
              if(q === 0){
                  this.handleStudentNameSearch(query);
              }
              else{
                  this.handleStudentIdentifierSearch(q);
              }
            },

            /**
             * Check whether the name value corresponds to a student,
             * if so, set the active student.
             *
             */
            handleStudentNameSearch: function ( nameSearched ) {
                window.console.log( 'student-search-bar', 'handleStudentNameSearch', 142, _.toInteger(nameSearched));

                var nameToFind = nameSearched.replace( /\s+/g, ' ' );
                var i = this.studentNames.indexOf( nameToFind );
                window.console.log( 'handlingNameSearch', nameToFind, i );
                if ( i >= 0 ) {
                    // window.console.log( $( '#studentListItem' + i ) );
                    this.handleStudentSelection(this.students[ i ]);
                }
                return false;
            },

            /**
             * When the search has returned an object,
             * sets it as active and clears the search box.
             * This is shared by the name and id searches
             */
            handleStudentSelection : function ( student ) {
                this.activeStudent = student;
                this.searchVal = '';
            },

            /**
             * todo
             * do the same with ID search
             */
            handleStudentIdentifierSearch: function (idToFind) {
                var i = this.studentIdents.indexOf( idToFind );
                if ( i >= 0 ) {
                    this.handleStudentSelection(this.students[ i ]);
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
            nameMatcher: function ( query, syncResults, asyncResults ) {
                // window.console.log( 'student-search-bar', 'nameMatcher', 183, query, _.isNumber(query));
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substringRegex = new RegExp( query, 'i' );

                let pool = _.concat(this.studentNames , this.studentIdents);
                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                _.forEach(pool , function ( n ) {
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
                let options = {
                    hint: true,
                    highlight: true,
                    minLength: 1
                };

                let dataset = {
                    name: 'student-names',
                    source: this.nameMatcher
                };

                jQuery( '#' + me.boxId )
                    .typeahead( options, dataset )
                    .bind( 'typeahead:select', function ( ev, suggestion ) {
                        console.log( 'Selection: ' + suggestion );
                        me.handleSearch( suggestion );
                    } );
            } );
        },

    }
</script>