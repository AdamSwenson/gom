/**
 * Created by adam on 3/10/17.
 */

import IModel from './IModel';

import Item from './Item';

export default class Comment extends IModel {

    constructor() {
        super();
        this.type = 'comment';
        this.valence = null;
    }

    isStock (){
        if (this.valence == 'stock'){
            return true;
        }
        return false;
    }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get valences() {
        return [
            'stock',
            'absent',
            'poor',
            'good',
            'excellent'
        ];
    }


    /**
     * Returns a list of fields which may
     * be used to look up an exam from the store
     */
    static identifiers() {
        return [
            'id',
            'index'
        ]
    }


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id',
            'index',
            'text',
            'valence'
        ];
    }

    static get aliasMap() {
        return {
            ItemId: 'id',
            ItemIndex: 'index'
        };

    }


    static factory( params ) {
        let obj = new Comment();
        return this.fillObject( obj, params );
    }
}