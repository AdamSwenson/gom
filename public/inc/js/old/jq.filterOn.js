/* 
 * Adapted from http://stackoverflow.com/questions/877328/jquery-disable-select-options-based-on-radio-selected-need-support-for-all-brow/878331#878331
 */
/**
 * This plugin filters options in a select by removing them or replacing them when a radio button is pressed.
 * Usage: $(function() {$('#theOptions').filterOn(radio, values);});
 * @param {type} radio Name of the radio buttons to operate on in the form: 'input:radio[name=$NameOfRadioButtons]'
 * @param {type} values Dictionary object with the radiobutton id's as keys and the class names in a list: {'button1ID': ['class1','class2','class3'], 'button2ID': ['class4','class5','class6']}
 * @returns {jQuery.fn@call;each}
 */
jQuery.fn.filterOn = function(radio, values) {
    return this.each(function() {
        var select = this;
        var options = [];
        $(select).find('option').each(function() {
            var classes = $(this).attr('class').split(" ");
//            window.console.log(classes);
            options.push({
                value: $(this).val(),
                text: $(this).text(),
                name: $(this).attr('name'),
                data: $(this).attr('data'),
                classString: $(this).attr('class'),
                classList: classes
            });
//            window.console.log(options);
        });
        if (checkFilled(select)) {
            $(select).data('options', options);
        }
        $(radio).click(function() {


            var options = $(select).empty().data('options');

            var needle = $(this).attr('id');
            $.each(options, function(i) {
                var option = options[i];
                for (var i = 0, l = option.classList.length; i < l; ++i) {
                    if (needle === option.classList[i]) {
                        $(select).append(
                                $('<option>').text(option.text)
                                .val(option.value)
                                .attr('data', option.data)
                                .attr('name', option.name)
                                .addClass(option.classString)
                                );
                    }
                }
            });
        });
    });
    /**
     * Determines whether the list of options has been saved to the select. This prevents it overwritting with a more limited set on a second select
     * @returns {boolean} Returns false if the list has already been saved. Returns true if still empty.
     */
    function checkFilled(select) {
        if ($(select).data('options')) {
            return false;
        } else {
            return true;
        }

    }
};
