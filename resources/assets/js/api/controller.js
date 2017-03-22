/**
 * Created by adam on 3/20/17.
 */
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'


axios.defaults.baseURL = routeRoot;
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, axios )

export default {
    _connection: null,

    // _api: function () {
    //     //if the connection has not already been created
    //     //create it
    //     if ( this._connection == null ) {
    //         this._connection = axios.create( {
    //             baseURL: 'https://some-domain.com/_api/',
    //             timeout: 1000,
    //             headers: {'X-Custom-Header': 'foobar'}
    //         } );
    //
    //         return this._connection;
    //     }
    //
    // },
    data: function () {
        return {
            routeBase: {
                item: "items",
                exam: 'exams'
            }
        }
    },

    methods: {
        /**
         * Utility for creating most of the route to the _api
         * @param type
         * @returns {*}
         */
        makeRoute: ( type ) => {
            if ( this.routeRoot ) {
                return this.routeRoot + this.routeBase[ type ];
            }

        },

        _errorHandling: (error) => {
            if (error.response) {
                // The request was made, but the server responded with a status code
                // that falls out of the range of 2xx
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            console.log(error.config);
        },

        /**
         * Asks the server to create the given model
         * @param IModel
         */
        createModel: ( Model ) => {
            let api = this.makeRoute( Model.className) + '/create';

            this.axios
                .get( api )
                .then( ( response ) => {
                    console.log( response.data )
                    //return Item with the new id or other data loaded
                    if ( typeof response.data.id != 'undefined' ) {
                        Model.id = response.data.id;
                    }
                    return Model;
                } )
                .catch( function ( error ) {
                    this._errorHandling(error);
                } );
        },


        /**
         * Asks the server to get the given model
         * @param IModel
         */
        readModel: ( Model ) => {
            let api = this.makeRoute( Model.className) + '/' + Model.id;

            this.axios
                .get( api )
                .then( ( response ) => {

                    console.log( response.data )
                    //return Item with the new id or other data loaded
                    if ( typeof response.data.id != 'undefined' ) {
                        Model.id = response.data.id;
                    }
                    return Model;
                } )
                .catch( function ( error ) {
                    this._errorHandling(error);
                    console.log( error );
                } );
        },

        /**
         * Asks the server to create the given item
         * @param Item
         */
        updateModel: (Model ) => {
            let api = this.makeRoute(Model.className) + '/' + Model.id;

            this.axios
                .put( api, Model )
                .then( ( response ) => {

                   // if (response.status == 200 ){
                        return callback(response);
                    // }
                    //
                    // console.log( response.data )
                    // //return Item with the new id loaded
                    // return Model;
                } )
                .catch( function ( error ) {
                    this._errorHandling(error);
                    console.log( error );
                } );
        },


        /**
         * Asks the server to create the given item
         * @param Item
         */
        deleteModel: ( Model , callback) => {

            let api = this.makeRoute(Model.className()) + '/' + Model.id;

            this.axios
                .delete( api )
                .then( ( response ) => {
                    if (response.status == 200 ){
                        return callback(response);
                    }
                } )
                .catch( function ( error ) {
                    this._errorHandling(error);
                    console.log( error );
                } );
        },

    }

// this.$http.get( _api ).then( ( response ) => {
//     console.log( response.data )
// } )
}