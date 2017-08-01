
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

        this.priority='';

        this.props = [];

        this.createdAt = '';

        this.updatedAt = '';

        this.associatedItemSerialNumber = null;
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