import IModel from './IModel';


export default class Tag extends IModel {

    constructor() {
        super();

        this.kind = 'tag';

        /**
         * The db identifier of the model
         */
        this.id = -1;

        this.name = '';

        this.text = '';

        this.props = {
            priority: 1
        };

        /**
         * Holds arbitrary representations
         * of the exams this is associated with.
         *
         * NB:
         *      Make sure to type check when using!
         *
         *      Only used in limited places. Don't count on things being here
         */
        this.exams = [];

        /**
         * Holds arbitrary representations
         * of the items this is associated with.
         *
         * NB:
         *      Make sure to type check when using!
         *
         *      Only used in limited places. Don't count on things being here
         */
        this.items = [];


        /**
         * Holds arbitrary representations
         * of the students this is associated with.
         *
         * NB:
         *      Make sure to type check when using!
         *
         *      Only used in limited places. Don't count on things being here
         */
        this.students = [];


    }

    // static get styleMap() {
    //     //making this 1-indexed because
    //     //some problem arises when trying to
    //     //retrieve a key of 0
    //     return {
    //         1: 'is-primary',
    //         2: 'is-info',
    //         3: 'is-warning',
    //         4: 'is-danger',
    //         5: 'is-black',
    //         6: 'is-light',
    //         7: 'is-success',
    //         8: 'is-white',
    //         9: 'is-dark',
    //
    //     }
    // }

    /**
     * Given the string style returns the numeric key
     * which is the thing stored in the db
     * @param styleString
     * @returns {*}
     */
    static getStyleKey( styleString ) {
        let key = _.findKey( Tag.styleMap, function ( t ) {
            return t === styleString;
        } );
        if ( _.isUndefined( key ) ) return null;

        return _.toNumber( key );
    }


    styleString() {
        let map = Tag.styleMap;
        let style = map[ this.priority ];
        // window.console.log( 'Tag', 'styleString', 88, this.priority, style, map);
        return style;
    }

    get priority() {
        if ( this.props.priority ) {
            return this.props.priority;
        }
        // return false;
    }

    set priority( v ) {
        this.props.priority = _.toNumber( v );
    }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id',
            'name',
            'props',
            'text',
            'priority',
            //associated objects
            'items',
            'exams',
            'students'
        ];

    }


    /**
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'tag';
    }


    static get aliasMap() {
        return {};

    }


    static factory( params ) {
        let obj = new Tag();
        return this.fillObject( obj, params, Tag.aliasMap );
    }

}