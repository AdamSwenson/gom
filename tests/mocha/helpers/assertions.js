

export const assertExpectedDivIsDisplayed = ( wrapper, componentDivId  ) => {
         expect( wrapper.find( componentDivId ).isEmpty() ).toBe( false );
};
