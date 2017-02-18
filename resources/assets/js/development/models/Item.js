/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */
export default class Item {
    constructor() {
        /**
         * The db identifier of the model
         */
        this._id;
        this._index;
        this._type;
        this._name;

        /**
         * Whether the item is currently set to
         * be appear in pages, emails, or anything
         * else that a student could see.
         *
         * If this value is true, there are some outputs viewable
         * by students, which this appears in.
         *
         * @type {boolean}
         * @private
         */
        this._public = false;
    }


    /* *************************** Id *************** */
    /**
     * Alias for _id
     * @returns {*}
     */
    get id() {
        return this._id;
    }

    get index() {
        return this._index;
    }

    get type() {
        return this._type;
    }

    get name() {
        return this._name;
    }

    set name( v ) {
        this._name = v;
    }

    /**
     * Getter for whether this can currently appear in student-viewable outputs
     * @returns {boolean|*}
     */
    isPublic() {
        return this._public;
    }

    /**
     * Makes able to appear in student-viewable outputs
     */
    makePublic() {
        this._public = true;
    }

    /**
     * Makes no longer visible to students
     */
    hide() {
        this._public = false;
    }

    togglePublic(){
        console.log( 'Item', 'CALLED', 'togglePublic', this._public );
        this._public = ! this._public;
        console.log( this._public );
    }

}
