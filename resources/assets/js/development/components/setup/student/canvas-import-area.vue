<template>
    <div class="canvas-import-area">
        <div class="canvas-inputs">

            <div class="field">
                <label  class="label" for="courseId">Canvas course id</label>
                <div class="control">
                    <input type="text"
                           id="courseId"
                           placeholder=""
                           v-model="courseId"
                    />
                </div>
                <p class="help">Where to find this value....</p>
            </div>

            <div class="field">
                <label class="label" for="apiKey">Canvas api key</label>
                <div class="control">
                    <input type="text"
                           id="apiKey"
                           v-model="apiKey"
                    />
                </div>
                <p class="help">Where to find this....</p>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <a class="button is-primary" v-on:click="queryCanvas">Import</a>
                </div>
                <div class="control">
                    <a class="button is-warning" v-on:click="handleCancel">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';

    import Payload from '../../../../models/Payload';

    import Student from '../../../../models/Student';

    export default {
        name: "canvas-import-area",

        data: function () {
            return {
                //whether the input are is visible
                isVisible: false,
                //todo remove!
                courseId: 41179,
                apiKey: '1860~lPVuCKmkiXLWjridsFKMxQgeZEaEkXUccUr8YTL6M9iLTjsBjegfXvag5bvqRx9w', //'',

                errors: {
                    1: 'No course id provided'

                }
            }
        },
        computed: {
            buttonText: function () {
                if ( this.isVisible ) {
                    return 'Import';
                } else {
                    return 'Cancel';
                }
            }
        },

        methods: {
            toggleInputs: function () {
                this.isVisible = !this.isVisible;
            },

            /**
             * Retrieves a json of students from
             * the canvas api
             */
            queryCanvas: function () {
                let me = this;

                //right now just uses the provided values, does not save
                if ( this.apiKey.length === 0 || this.courseId.length === 0 ) return this.handleCancel();


                let params = { apiKey: this.apiKey, courseId: this.courseId };
                window.axios.post( 'dev/import/canvas', params )
                    .then( function ( response ) {
                        //we need to create a new kumi with the relevant course id
                        //but we wait until after there's a good response, so we don't
                        //end up with kumis that don't correspond with anything
                        me.$store.dispatch( 'createKumi' ).then( function ( kumi ) {
                            me.$store.commit( 'updateKumi', Payload.factory( {
                                obj: kumi,
                                updateProp: 'name',
                                updateVal: me.courseId
                            } ) );

                            //select it so that the students get associated with this kumi
                            me.$store.commit( 'selectKumi', Payload.factory( { obj: kumi } ) );

                            // window.console.log( 'canvas-import-area', 'response', 59, response );

                            //now we can process the response and add students to the exam
                            _.forEach( response.data, function ( r ) {
                                // window.console.log( 'canvas-import-area', 'r', 87, r);
                                let s = new Student();
                                s.studentIdentifier = r.sis_user_id;
                                let n = _.split( r.sortable_name, ',' );
                                s.lastName = n[ 0 ];
                                s.firstName = n[ 1 ];
                                me.$store.dispatch( aTypes.handleNewStudentStorageAndAssociation, s );
                            } );


                        } );

                    } );
                // window.console.log( 'canvas-import-area', 'queryCanvas', 58, route);
            },

            handleCancel: function () {
                this.$emit( 'close-area' );
            },

            handleError: function () {

            }
        }
    }
</script>

<style lang="scss" scoped>

    input{
        width: 42em;

    }
</style>