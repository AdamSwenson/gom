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

    isStock() {
        return this.valence === 'stock';
    }

    /**
     * Creates the expected empty comments in the comments array
      on the iModel object passed in
     */
    static initializeComments(iModel) {
        //create the comments map if it doesn't exist
        if (typeof iModel.comments === 'undefined') {
            iModel.comments = new Map();
        }
        //Set the expected structure
        if (iModel.comments.size === 0) {
            Comment.valences.forEach(function (c) {
                iModel.addComment(c, Comment.factory({valence: c}));
            });
        }
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


    static factory(params) {
        let obj = new Comment();
        return this.fillObject(obj, params);
    }
}