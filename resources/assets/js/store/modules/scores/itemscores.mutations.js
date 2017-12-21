import * as ngmTypes from "../newgrading/new-grading-mutation-types";
import Vue from "vue";

import { itemScoreGetter, create } from "./itemscores.helpers";
import getters from "./itemscores.getters";
import actions from "./itemscores.actions";

module.exports = {

    [ ngmTypes.updateScore ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = create( state, payload.exam, payload.item, payload.student );
        }
        let score = payload.score;
        //update the object
        Vue.set( obj, 'score', score );
    },

    [ ngmTypes.updateText ]: ( state, payload ) => {
        //check whether we already have the object
        let obj = itemScoreGetter( state, payload.item.id, payload.student.id );
        if ( _.isUndefined( obj ) ) {
            obj = create( state, payload.exam, payload.item, payload.student );
        }
        let text = payload.text;
        //update the object
        Vue.set( obj, 'text', text );
    }
};

