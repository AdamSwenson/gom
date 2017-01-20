/**
 * Created by adam on 8/15/16.
 */

export default class Student {
    constructor( studentId ) {
        this._email = '';
        this._id = studentId;
        this._index = null;
        this._studentIdentifier = null;
        this._lastName = '';
        this._firstName = '';
    }

    get email() {
        return this._email;
    }

    set email( address ) {
        this._email = address;
    }

    get firstName() {
        return this._firstName
    };

    set firstName( val ) {
        this._firstName = val;
    }

    /** Alias for database identifier, i.e., studentId */
    get id() {
        return this.studentId;
    }


    get lastName() {
        return this._lastName
    };

    set lastName( val ) {
        this._lastName = val;
    }

    /**
     * Returns the identifier set by the user.
     * This is not the database id of the student
     * */
    get studentIdentifier() {
        return this._studentIdentifier
    };

    set studentIdentifier( val ) {
        this._studentIdentifier = val;
    }

    get studentId() {
        return Number( this._id )
    };

    set studentId( val ) {
        this._id = val;
    }

    get studentIndex() {
        return Number( this._index )
    };

    set studentIndex( val ) {
        this._index = val;
    }

    /**
     * Takes the json student object received from the server and
     * returns a Student object
     * @param studentJson
     * @returns {Student}
     */
    static factory( studentJson ) {
        if ( ! studentJson || ! studentJson.studentId ) throw new Error( "studentJson had no id" );

        let student = new Student( studentJson.studentId );
        // window.console.log( 'factory', student, studentJson.studentId );
        student.firstName = studentJson.firstName;
        student.lastName = studentJson.lastName;
        student.studentIndex = studentJson.studentIndex;
        student.studentIdentifier = studentJson.studentIdentifier;
        // for ( let i = 0; i < Object.keys( student ).length; i ++ ) {
        //     let key = Object.keys( student )[ i ];
        //     student[ key ] = studentJson[ key ];
        // }
        return student;
    }
}