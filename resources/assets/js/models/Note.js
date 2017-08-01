import IModel from './IModel';


export default class Note extends IModel {

    constructor() {
        super();

        /**
         * The db identifier of the model
         */
        this.id = -1;

        this.name = '';

        this.text = '';

        this.priority = '';

        this.props = [];

        this.createdAt = '';

        this.updatedAt = '';

        this.associatedItemSerialNumber = null;
    }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'associatedItemSerialNumber',
            'createdAt',
            'id',
            'name',
            'priority',
            'props',
            'text',
            'updatedAt',
        ];

    }


    /**
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'note';
    }


    static get aliasMap() {
        return {};

    }


    static factory( params ) {
        let obj = new Note();
        return this.fillObject( obj, params, Note.aliasMap );
    }

}