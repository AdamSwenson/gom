import ItemScore from "../../../models/ItemScore";


export const itemScoreGetter = ( state, itemId, studentId ) => {
    return (function ( state, itemId, studentId ) {
        var r = state.scores.filter( function ( i ) {
            if ( i.itemId === itemId && i.studentId === studentId ) {
                return i;
            }
        } );
        return r[ 0 ];
    })( state, itemId, studentId )
};


export const create = ( state, exam, item, student ) => {
    let obj = ItemScore.factory( {
        examId: exam.id,
        itemId: item.id,
        studentId: student.id
    } );
    //add it to storage
    state.scores.push( obj )
    return obj;
}
