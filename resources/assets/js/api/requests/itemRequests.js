import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import { errorHandling, handleResponse } from '../responseHandlers';


module.exports = {

    getItemsForExam: ( exam ) => {
        let to = 'items/exam/' + exam.id;

        return window.axios.get( to ).then( function ( response ) {
// //The returned array  will have the keys
//             //  'itemObjects'
//             //  'itemOrder'

            return response.data;

        } ).catch( function () {

        } );
    },


};