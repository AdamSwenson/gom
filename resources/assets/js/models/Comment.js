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

        this.commentIngredients = {
            absent: {
                prefix: 'To answer this correctly, you needed to',
                    postfix: 'Unfortunately, you forgot to do this'
            },
            poor: {
                prefix: 'This required you to',
                    postfix: 'You attempted to do it, but there were many problems'
            },

            good: {

                prefix: 'As was evident from your answer, you recognized that you needed to',
                    postfix: 'Your answer was okay'
            },

            excellent: {
                prefix: 'As was evident from your excellent answer, you recognized that you needed to',
                    postfix: 'You did a great job here'
            }
        };
    }

    isStock() {
        return this.valence === 'stock';
    }

    isEmpty(){
        if(! _.isUndefined(this.text) && this.text.length > 0) return false;
        return true;
    }



   static  makePrePopulatedContent  ( valence, stock ) {
        let prefix = me.commentIngredients[valence].prefix;
        let postfix = me.commentIngredients[valence].postfix;
        return `${prefix} ${stock} ${postfix}`
    }

    /**
     * Creates the expected empty comments in the comments array
      on the iModel object passed in
     */
    static initializeComments(iModel) {
        //create the comments map if it doesn't exist
        if (typeof iModel.comments === 'undefined') {
            iModel.comments = new Map();
        // iModel.comments = {};
        }
        //Set the expected structure
        // if (Object.keys(iModel.comments).length === 0) {
        //     Comment.valences.forEach(function (c) {
        //         iModel.addComment(c, Comment.factory({valence: c}));
        //     });
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
            body: 'text',
            ItemId: 'id',
            ItemIndex: 'index'
        };

    }


    static factory(params) {
        let obj = new Comment();
        return this.fillObject(obj, params);
    }
}