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
            this.year;
            this.term ='';
            this.name ='';
            this.description ='';
            this.id;
            this.isRoster = false;
    }

    /**
     * Whether the kumi is newly created.
     * That is, whether it has a name or other
     * essential properties. (right now, just checks
     * for a name).
     *
     */
    isNew(){
        return (_.isNull(this.name) || this.name.length === 0);
    }

    static get aliasMap() {
        return {
            is_roster : 'isRoster'
        };

    }

    static get fillableProps() {
        return [
            'year',
            'term',
            'name',
            'description',
            'id',
            'isRoster'
        ].concat(super.fillableProps);

    };


    static factory( params ) {
        let o = new Kumi();
        return this.fillObject(o, params, Kumi.aliasMap);
    }

}