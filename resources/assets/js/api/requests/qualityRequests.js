import Payload from "../../models/Payload";

module.exports = {

    getQCData: ( exam ) => {
        let to = '/quality/exam/' + exam.id;

        return window.axios
            .get( to )
            .then( function ( response ) {
                return response.data;
            } );
    }
}