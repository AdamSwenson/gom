/**
 * Created by adam on 8/15/16.
 */

import IModel from './IModel';

export default class Exam extends IModel{

    /**
     * Create a new exam object
     * @param examId
     * @param examIndex
     */
    constructor( ...params ) {
        super();
        this._id; // = examId;
        this._index; // = examIndex;
        this._name; // = name;
        this._year; // = year;
        this._term;// = term;

        if(params.length > 0){
            //fill in from params

        }
    };

    /* *************************** Id *************** */
    /**
     * The database id of the exam
     */
    get id() {
        return this._id;
    };

    set id(v){
        this._id = Number(v);
    }

    /**
     * Some things like to call the database id
     * this when they ask for the property. So
     * we oblige them with a nice alias.
     */
    get examId() {
        return this._id;
    }
    /* *************************** Index ************* */
    /**
     * Returns the examIndex
     * This used to be the main identifier with which the exam
     * was looked up in store.exams.
     * todo add sanitization
     * @returns {*}
     */
    get examIndex() {
        return this._index;
    }

    set index(v){
        this._index = v;
    }
    get index(){return this._index;}

    /* *************************** Props ************* */

    get name(){ return this._name; }
    set name(n){this._name = n; }

    get year(){ return this._year; }
    set year(v){ this._year = v; }

    get term(){ return this._term; }
    set term(v){ this._term = v; }



    /**
     * Returns a list of fields which may
     * be used to look up an exam from the store
     */
    static examIdentifiers() {
        return [
            'examId',
            'examIndex'
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
            'name',
            'year',
            'term'
        ];
    }

    static get aliasMap() {
        return {
            examId: 'id',
            examIndex: 'index'
        };

    }


    static factory( params ) {
        let exam = new Exam();

        return this.fillObject(exam, params);
//
//         if ( typeof params != 'undefined' ) {
//             //fill any fillable values
//             this.fillableProps.forEach( function ( v ) {
//                 // console.log( 'params', params, v );
//                 if ( typeof params[ v ] != 'undefined' ) {
//                     exam[ v ] = params[ v ];
//                 }
//             } );
//
//             //fill any aliased values
//             for ( let v in this.aliasMap ) {
//                 if ( typeof params[ v ] != 'undefined' ) {
//                     // console.log( 'alias', v, map[v] );
//                     exam[ this.aliasMap[ v ] ] = params[ v ];
//                 }
//             }
//         }
// //we will still return an empty exam if there
//         //were no parameters
//         return exam;
    }



}