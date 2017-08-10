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


    }

    get priority(){
        if(this.props.priority){
            return this.props.priority;
        }
        return false;
    }

    set priority(v){
        this.props['priority'] = v;
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
            'priority'
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