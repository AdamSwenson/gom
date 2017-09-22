/**
 * Created by adam on 8/15/16.
 */

import IModel from './IModel';


export default class Student extends IModel{
    constructor( studentId = -1 ) {
        super();
        this.email = '';
        this.id = studentId;
        this._index = null;
        this.studentIdentifier = null;
        this.lastName = '';
        this.firstName = '';

        this.associatedKumis = [];

        //sometimes it will be expeditious just
        //to store these on the student.
        this.score = null;
        this.grade = null;
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
            'email'
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
        };

    }


    static factory( params ) {
        let student = new Student();
        return this.fillObject(student, params);
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
        return Number( this._id )
    };

    /**
     * Alias for _id
     * @param val
     */
    set studentId( val ) {
        this._id = val;
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

    //
    // get firstName() {
    //     return this._firstName
    // };
    //
    // set firstName( val ) {
    //     this._firstName = val;
    // }
    //
    // /**
    //  * Getter for last name
    //  */
    // get lastName() {
    //     return this._lastName;
    // };
    //
    // /**
    //  * Setter for last name
    //  * @param val
    //  */
    // set lastName( val ) {
    //     this._lastName = val;
    // };


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


    /* *************************** Email ****************** */
    // get email() {
    //     return this._email;
    // }
    //
    // set email( address ) {
    //     this._email = address;
    // }


    //
    // static get fillable(){
    //     return [
    //         'firstName',
    //         'lastName',
    //         'studentId',
    //         'studentIdentifier',
    //         'studentIndex',
    //     ]
    // }
    // /**
    //  * Takes the json student object received from the server and
    //  * returns a Student object
    //  * @param studentJson
    //  * @returns {Student}
    //  */
    // static factory( studentJson ) {
    //     let student = new Student(  );
    //     let fields = Student.fillable;
    //
    //     for(let i=0; i<fields.length; i++){
    //         let field = fields[i];
    //         if(typeof studentJson[field] != 'undefined' ){
    //             student[field] = studentJson[field];
    //         }
    //     }
    //
    //     console.log( 'student', student );
    //     return student;
    // }


    static checkIfStudent( obj ) {
        if ( obj instanceof Student) return true;

        if ( obj.kind === 'student' ) return true;

        return false;
    }


}