/**
 * Originally just a transporation class. Now evolving to
 * handle the myriad different ways objects can be identified
 */

import IModel from "./IModel";
import Payload from "./Payload";

export default class PayloadScore extends Payload {
    constructor() {
        super();

        this.exam;
        this.item;
        this.student;
        this.score;
        this.text;
    }

    static get fillableProps() {
        return [
            'exam',
            'item',
            'student',
            'score',
            'text'
        ];
    }

    static factory( params ) {
        let pt = new PayloadScore();
        return this.fillObject( pt, params );
    }
}