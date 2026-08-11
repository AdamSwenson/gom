import Payload from "../../models/Payload";

const qualityRequests = {

    getQCData: ( exam ) => {
        let to = '/quality/exam/' + exam.id;

        return window.axios
            .get( to )
            .then( function ( response ) {
                return response.data;
            } );
    }
};

export const { getQCData } = qualityRequests;
