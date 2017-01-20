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

    /**
     * Alias for _id
     * @returns {*}
     */
    get id() {
        return this._id;
    }

    /**
     * Alias setter for _id
     * @param v
     */
    set id( v ) {
        this._id = v;
    }

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
    // /**
    //  * Master getter for index
    //  * Any checks or transformations should be done here
    //  * since everything else will call this.
    //  * @returns {*}
    //  */
    // get _index() {
    //     return this._index;
    // }
    //
    // /**
    //  * Master setter for index
    //  * Any checks or transformations should be done here
    //  * since everything else will call this.
    //  */
    // set _index( v ) {
    //     this._index = v;
    // }

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


    get firstName() {
        return this._firstName
    };

    set firstName( val ) {
        this._firstName = val;
    }

    /**
     * Getter for last name
     */
    get lastName() {
        return this._lastName;
    };

    /**
     * Setter for last name
     * @param val
     */
    set lastName( val ) {
        this._lastName = val;
    };


    /* *************************** Identifier *********** */
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


    /* *************************** Email ****************** */
    get email() {
        return this._email;
    }

    set email( address ) {
        this._email = address;
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
            'studentIdentifier'
        ];
    }

    static get aliasMap() {
        return {
            studentId: 'id',
            studentIndex: 'index'
        };

    }


    static factory( params ) {
        let student = new Student();
        if ( typeof params != 'undefined' ) {
            //fill any fillable values
            this.fillableProps.forEach( function ( v ) {
                // console.log( 'params', params, v );
                if ( typeof params[ v ] != 'undefined' ) {
                    student[ v ] = params[ v ];
                }
            } );

            //fill any aliased values
            for ( let v in this.aliasMap ) {
                if ( typeof params[ v ] != 'undefined' ) {
                    // console.log( 'alias', v, map[v] );
                    student[ this.aliasMap[ v ] ] = params[ v ];
                }
            }
        }
//we will still return an empty student if there
        //were no parameters
        return student;
    }

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
}