/**
 * Created by adam on 8/15/16.
 */

import IModel from './IModel';

/**
 * Helper function for checking whether a kumi is
 * in the student's list of kumis that she is associated with
 */
const isInList = ( kumi, listToCheck ) => {
    // if(_.isUndefined(kumi) || _.isUndefined(kumi.id)) return false;
    // if(_.isUndefined(listToCheck)) return false;

    return _.findIndex( listToCheck, { id: kumi.id } ) >= 0;
};


export default class Student extends IModel {
    constructor( studentId = -1 ) {
        super();
        this.email = '';
        this.id = studentId;
        this._index = null;
        this.studentIdentifier = null;
        this.lastName = '';
        this.firstName = '';

        /** Kumi objects with which the student is associated */
        this.associatedKumis = [];

        //sometimes it will be expeditious just
        //to store these on the student.
        this.score = null;
        this.grade = null;

        this.gradingTime;
    }

    /* ************************* Server stuff ****************** */
    /**
     * Tells whether the item has a valid id and thus can
     * be synced with the server.
     * @returns {boolean}
     */
    canSync() {
        if ( this.id >= 0 ) return true;
        return false;
    }

    /**
     * New student objects have a default id of -1
     * until an id is retrieved from the server.
     * This is a boolean check of whether that happened
     *
     * @returns {boolean}
     */
    isNew() {
        return this.id === -1;
    }

    /**
     * Given a kumi object or list of kumi objects,
     * it returns whether or not the student is a member
     * of that kumi by checking the provided kumi against
     * the internally stored list of kumis which the student
     * belongs to.
     * When a list is provided, it returns true only if
     * the student is a member of at least one of the kumis
     * @param kumi
     * @returns {boolean}
     */
    isInKumiOrKumiList( kumiOrKumis ) {
        //This student belongs to no groups
        if ( this.associatedKumis.length === 0 ) return false;

        let isIn = false;
        let me = this;

        //Make sure we have a list to check
        let kumis = _.isArray( kumiOrKumis ) ? kumiOrKumis : [ kumiOrKumis ];
        _.forEach( kumis, function ( kumi ) {
            //if it is in the list of kumis stored on the student,
            //set our value to true;
            if ( isInList( kumi, me.associatedKumis ) ) isIn = true;
        } );

        return isIn;
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
            'firstName',
            'lastName',
            'studentIdentifier',
            'email',
            'gradingTime'
        ];
    }

    static get aliasMap() {
        return {
            studentId: 'id',
            studentIndex: 'index',
            student_identifier: 'studentIdentifier',
            last_name: 'lastName',
            first_name: 'firstName',
            student_id: 'id',
            seconds: 'gradingTime'
        };

    }


    static factory( params ) {
        let student = new Student();
        return this.fillObject( student, params, Student.aliasMap );
    }

    /* *************************** Id *************** */
    // /**
    //  * Master getter for database identifier, i.e., studentId
    //  * Any checks or transformations should be done here
    //  * since everything else will call this.
    //  * @returns {*}
    //  */
    // get _id() {
    //     return Number( this._id );
    // }
    //
    // /**
    //  * Master setter for id
    //  * Any checks or transformations should be done here
    //  * since everything else will call this.
    //  */
    // set _id( v ) {
    //     this._id = v;
    // }
    //
    // /**
    //  * Alias for _id
    //  * @returns {*}
    //  */
    // get id() {
    //     return this._id;
    // }
    //
    // /**
    //  * Alias setter for _id
    //  * @param v
    //  */
    // set id( v ) {
    //     this._id = v;
    // }

    /**
     * Alias for _id
     */
    get studentId() {
        return Number( this.id )
    };

    /**
     * Alias for _id
     * @param val
     */
    set studentId( val ) {
        this.id = val;
    }


    /* *************************** Index ************* */

    /** Alias getter for _index  */
    get index() {
        return this._index;
    }

    /** Alias setter for _index */
    set index( v ) {
        this._index = v;
    }

    /** Alias getter for _index  */
    get studentIndex() {
        return Number( this._index )
    };

    /** Alias setter for _index */
    set studentIndex( val ) {
        this._index = val;
    }

    /* *************************** Names ************* */

    get nameLastFirst() {
        return this.lastName + ', ' + this.firstName;
    }

    get nameFirstLast() {
        return this.firstName + ' ' + this.lastName;
    }


    /* *************************** Identifier *********** */
    /**
     * Returns the identifier set by the user.
     * This is not the database id of the student
     * */
    get identifier() {
        return this.studentIdentifier;
    };

    set identifier( val ) {
        this.studentIdentifier = val;
    }


    static checkIfStudent( obj ) {
        if ( obj instanceof Student ) return true;

        if ( obj.kind === 'student' ) return true;

        return false;
    }


}