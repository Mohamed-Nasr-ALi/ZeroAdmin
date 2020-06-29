var data = [];
$.ajax({
    type: "GET",
    //  enctype: 'multipart/form-data',
    url: "/api/get_all_countries",
    processData: false,
    contentType: false,
    cache: true,
    timeout: 600000,
    success: function (response) {
        data.push(response.map((currentValue) => {
                return {
                    'id': currentValue.alpha2Code,
                    'text': currentValue.country_name_en,
                    'code': currentValue.calling_code
                }
            }
        ));

        $('#paises').select2({
            templateResult: formatoSelect,
            templateSelection: formatoSelect,
            data: data[0]
        });
        $('.telefono').text('+' + data[0][0].code);
    },
    error: function (e) {
        console.log("ERROR : ", e);
    }
});


function formatoSelect(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><img class="flag flag-' + state.element.value.toLowerCase() + '"/>' + state.text + '</span>'
    );
    return $state;
};

function arrayObjectIndexOf(myArray, searchTerm, property) {
    for (var i = 0, len = myArray.length; i < len; i++) {
        if (myArray[i][property] === searchTerm) return i;
    }
    return -1;
}
var x;
$('#paises').on('select2:select', function (evt) {
    if (arrayObjectIndexOf(data[0], $('#paises').val(), "id") !== -1) {
        var ct = arrayObjectIndexOf(data[0], $('#paises').val(), "id");
        x ='+' + data[0][ct].code;
        $('.telefono').text(x);
    }
});

$('#submit_button').on('click', function (evt) {
    let phone =   $('#phone_number').val();
    $('#phone_number').val(x+phone);
});
$('.dropdown-toggle').dropdown();
