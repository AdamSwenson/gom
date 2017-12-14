<template>
    <p class="control has-icons-left">
        <input class="input is-small" type="text"
               placeholder="search"
               v-on:focus="initialize"
               v-on:change="handleStudentNameSearch"
        >
        <span class="icon is-small is-left">
        <i class="fa fa-search"></i>
      </span>
    </p>

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

        computed: {
            activeStudent: {
                get: function () {
                    return this.$store.getters[ gTypes.getActiveStudent ];
                },
                set: function ( student ) {
                    this.$store.dispatch( aTypes.setStudentAsActive, student );
                }
        },

        /** studentNames supplies name data for the search box (typeahead) */
        studentNames: function () {
            return [];
        },

        /** Student identifier data for the ID search box (typeahead) */
        studentIdents: function () {
            return []
        },

        /** Total number of students */
        numStudents: function () {
            return !_.isUndefined( this.studentNames ) ? this.studentNames.length : null;

        },

    }
    ,

    methods: {
        //todo
        initialize: function () {
            // //only do this once if the list is empty
            // // should this also check idents? probably not because those are optional
            // if ( this.studentNames.length > 0 ) return;
            // var me = this;
            // let $studentNames = $( '[id^="studentName"]' );
            // $studentNames.each( function () {
            //     me.studentNames.push( $( this ).text() );
            // } );
            //
            // //Calculate the number of students and store
            // this.numStudents = $studentNames.length;
            //
            // //Load the student id numbers
            // let $studentIdents = $( '[id^="studentIdentifier"]' );
            // $studentIdents.each( function () {
            //     me.studentIdents.push( $( this ).text() );
            // } );
            //
            // window.console.log( 'search box data initialized', this );
        }
    ,

        /**
         * todo
         * grab the name of the student, and perform a click on the appropriate row in the student roster
         */
        handleStudentNameSearch: function () {
            // this.initialize();
            // var nameToFind = $( '#activeStudentName' ).val().replace( /\s+/g, ' ' );
            // var i = this.studentNames.indexOf( nameToFind );
            // window.console.log( 'handlingNameSearch', nameToFind, i );
            // //not sure if this needs to be added
            // //$( "#activeStudentName" ).blur();
            // if ( i >= 0 ) {
            //     window.console.log( $( '#studentListItem' + i ) );
            //     $( '#studentListItem' + i ).trigger( 'click' );
            // }
        }
    ,

        /**
         * todo
         * do the same with ID search
         */
        handleStudentIdentifierSearch: function () {
            // window.console.log( 'handlingIdSearch' );
            // this.initialize();
            // var idToFind = $( '#activeStudentIdentifier' ).val();
            // var i = this.studentIdents.indexOf( idToFind );
            // //    window.console.log('handlingIdSearch', i);
            // $( "#activeStudentIdentifier" ).blur();
            // if ( i >= 0 ) {
            //     $( '#studentListItem' + i ).trigger( 'click' );
            // }
        }
    ,


    }
    ,

    directives: {
    }
    ,

    events: {
    }
    ,

    mounted: function () {},

    ready: function () {
        //
        // var me = this;
        // var nameBox = document.getElementById( 'activeStudentName' );
        // var ta1 = Typeahead( nameBox, {
        //     source: me.studentNames
        // } );
        //
        // var idBox = document.getElementById( 'activeStudentIdentifier' );
        // var ta1 = Typeahead( idBox, {
        //     source: me.studentIdents
        // } );
        // window.console.log( 'currentStudentArea.component ready' );

//         $( '#activeStudentName' ).typeahead( {
//     source: SearchBox.studentNames
// } );

// $( '#activeStudentIdentifier' ).typeahead( {
//     source: SearchBox.studentIdents
// } );
//
// $( "#activeStudentName" ).on( 'change', function () {
//     SearchBox.handleStudentNameSearch();
// } );
//
// $( "#activeStudentIdentifier" ).on( 'change', function () {
//     SearchBox.handleStudentIdentifierSearch();
// } );
    }
    }
</script>