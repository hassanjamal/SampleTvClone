$(function () {
    var parentId = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/admin/api/users/parent/%QUERY',
            filter: function (response) {
                return $.map(response., function (object) {
                    return {
                        value: object.first_name + " " + object.last_name,
                        firstName: object.first_name,
                        lastName: object.last_name,
                        personID: object.id
                    };
                });
            }
        }
    });

    parentId.initialize();

    $('#remote .typeahead').typeahead(null, {
        //minLenght:3,
        displayKey: 'value',
        source: parentId.ttAdapter()
    });
});