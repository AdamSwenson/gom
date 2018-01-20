<template>
    <div class="import-students-control file "
         v-bind:class="styling"
    >
        <label class="file-label">

            <!--This is the native element which is hidden by css-->
            <input id="file-input"
                   class="file-input"
                   type="file"
                   name="student-file-upload"
                   v-on:change.prevent="processFile"
            >

            <!--This is the call to action, i.e., the text-->
            <span class="file-cta">
                    <span class="file-icon"><i class="fa fa-upload"></i></span>
                    <span class="file-label">{{buttonLabel}}</span>
                </span>

        </label>

    </div>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                buttonLabel: 'Choose a file to import students from',
                styling: 'is-primary is-outlined',
                events: {
                    importComplete: 'studentImportComplete',
                    importError: ''
                },

                defaults: {}
            }
        },

        computed: {},

        methods: {

            processFile: function () {
                let me = this;
                let p = new Promise( function ( resolve, reject ) {

                    let f = document.getElementById( 'file-input' );
                    let file = f.files[ 0 ];

                    //processFile gets called once
                    //as indicated by this line only printing once
                    // window.console.log( 'students-panel', 'processFile', 112, evt, f, file );

                    //but then it seems this line gets called twice....
                    //since all the messages for importStudentsFromFile
                    //display twice
                    me.$store.dispatch( 'importStudentsFromFile', file );

                    // window.console.log( 'students-panel', 'processFile', 332, 'after the dispatch has weirdly fired twice' );
                    //finally, reset the attached file
                    f.value = '';
                    resolve();
                } );

                p.then( function () {
                    me.notifyParentImportComplete();
                } );

                p.catch( function () {
                    //todo
                } );
            },

            notifyParentImportComplete: function () {
                return this.$emit( this.events.importComplete );
            }

        },

    }
</script>