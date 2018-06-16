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

    //NB, styleMap is stored on parent. Not sure why I did that....

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

    /**
     * Utility for determining whether this tag is
     * associated with the provided object
     *
     * @param object
     * @returns {boolean}
     */
    isTagged( object ) {
        if ( object.tags.length === 0 ) return false;
        return _.findIndex( object.tags, this ) > -1;
    }

    styleString() {
        let map = Tag.styleMap;
        try {
            if(_.isUndefined(this.props) || _.isNull(this.props)) return '';
            let style = map[ this.props.priority ];
            // window.console.log( 'Tag', 'styleString', 88, this.priority, style, map);
            return style;
        } catch(err) {
            window.console.log( 'Tag', 'styleString', 98, err);
            return map[ 1 ];
        }
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