import ItemScore from "../../../resources/assets/js/models/ItemScore";

var faker = require( 'faker' );


/**
 * These create different parts of the vuex state
 *
 */


export const itemscores = {

    makePopulatedState: ( n = 5 ) => {
        // Format: { studentIndex : { elementIndex : elementScore},  ...
        let s = {
            scores: []
        };

        for (let i = 0; i < n; i++) {
            let score = ItemScore.factory( { studentId: i, examId: i, itemId: i } );
            score.score = faker.random.number();
            score.commentText = faker.company.catchPhrase;
            s.scores.push( score );
        }
        return s;
    },


    makeState: () => {
        return {
            scores: []
        };
    }


};
