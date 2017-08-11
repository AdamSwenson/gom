import IModel from './IModel';


export default class Tag extends IModel {

    constructor() {
        super();

        /**
         * The db identifier of the model
         */
        this.id = -1;

        this.name = '';

        this.text = '';

        this.props = [];

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

    get priority() {
        if ( this.props.priority ) {
            return this.props.priority;
        }
        return false;
    }

    set priority( v ) {
        this.props[ 'priority' ] = v;
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