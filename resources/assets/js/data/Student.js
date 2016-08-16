/**
 * Created by adam on 8/15/16.
 */

export default class Student {
    constructor( studentId ) {

        /** Alias for studentId */
        this.id = this._studentId;

        this._studentId = studentId;
        this._studentIndex = null;
        this._studentId = null;
        this._studentIdentifier = null;
        this._lastName = '';
        this._firstName = '';
    }

    get studentIdentifier() {
        return this._studentIdentifier
    };

    set studentIdentifier( val ) {
        this._studentIdentifier = val;
    }

    get studentId() {
        return Number( this._studentId )
    };

    set studentId( val ) {
        this._studentId = val;
    }

    get studentIndex() {
        return Number( this._studentIndex )
    };

    set studentIndex( val ) {
        this._studentIndex = val;
    }

    get firstName() {
        return this._firstName
    };

    set firstName( val ) {
        this._firstName = val;
    }

    get lastName() {
        return this._lastName
    };

    set lastName( val ) {
        this._lastName = val;
    }
}