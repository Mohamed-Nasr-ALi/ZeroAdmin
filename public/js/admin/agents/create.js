$("#business_logo").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.image-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

/***********************POS & PUR **************************/

$('input[type="checkbox"]').click(function () {
    if ($("#POS").is(':checked') === true && $("#PUR").is(':checked') === true) {
        $('#business_type').attr('value', 2);
    } else if ($("#POS").is(':checked') === true) {
        $('#business_type').attr('value', 1);
    } else if ($("#PUR").is(':checked') === true) {
        $('#business_type').attr('value', -1);
    } else {
        $('#business_type').attr('value', null);
    }
});

/***********************END POS & PUR **************************/
/***********************cashback **************************/
function sum() {
    let x = $('#client_cashback').val();
    let y = $('#zerocach_cashback').val();
    var total_cashback = +x + +y;
    document.getElementById("total_cashback").innerHTML = total_cashback;
}

/***********************END cashback **************************/

