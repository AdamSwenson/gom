/**
 * Created by adam on 7/10/17.
 */

import IModel from './IModel';

export default class Kumi extends IModel {


    /**
     * Create a new exam object
     * @param params
     */
    constructor( ...params ) {
        super();
    }

    static get fillableProps() {
        return [
            'year',
            'term',
            'name',
            'id'
        ].concat(super.fillableProps);

    };


    static factory( params ) {
        let o = new Kumi();
        return this.fillObject(o, params, {}); //Exam.aliasMap);
    }

}