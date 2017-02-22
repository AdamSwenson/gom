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

        /**
         * The locator value
         */
        this._index;

        /**
         * The role played by the item
         */
        this._type;

        /**
         * The possible values of this._type
         */
        this.types = ['comment', 'element', 'question'];

        /** The nickname or title by which this item is identified */
        this._name;

        /**
         * The full length text of the item.
         * This could be the question prompt;
         * a longer description of the element; etc
         */
        this._text;

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

    /**
     * The locator for the item
     * @returns {*}
     */
    get index() {
        return this._index;
    }

    /**
     * The locator for the item
     * @param v
     */
    set index(v) {
        this._index = v;
    }


    get type() {
        return this._type;
    }


    /**
     * The full length text of the item.
     * @returns {*}
     */
    get text() {
        return this._text;
    }

    /**
     * The full length text of the item.
     * @param v
     */
    set text( v ) {
        this._text = v;
    }


    /**
     * The nickname or title by which this item is identified
     * @returns {*}
     */
    get name() {
        return this._name;
    }

    /**
     * The nickname or title by which this item is identified
     * @param v
     */
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
