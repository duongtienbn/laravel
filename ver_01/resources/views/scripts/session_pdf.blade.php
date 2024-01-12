<script>
$("#name").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("name_value", value !== "" ? value : " ");
});

$("#name_kana").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("name_kana_value", value !== "" ? value : " ");
});

$("#country").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("country_value", value !== "" ? value : " ");
});

$("#sex").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("sex_value", value !== "" ? value : " ");
});

$("#birthday").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("birthday_value", value !== "" ? value : " ");
});

$("#phone").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("phone_value", value !== "" ? value : " ");
});

$("#email").on("input", function() {
    var value = $(this).val();
    sessionStorage.setItem("email_value", value !== "" ? value : " ");
});

  $(window).on("load", function() {
        var nameVal = sessionStorage.getItem("name_value");
        if (nameVal) {
            $("#name").val(nameVal);
        }
        var nameKanaVal = sessionStorage.getItem("name_kana_value");
        if (nameKanaVal) {
            $("#name_kana").val(nameKanaVal);
        }
        var countryVal = sessionStorage.getItem("country_value");
        if (countryVal) {
            $("#country").val(countryVal);
        }
        var sexVal = sessionStorage.getItem("sex_value");
        if (sexVal) {
            $("#sex").val(sexVal);
        }
        var birthdayVal = sessionStorage.getItem("birthday_value");
        if (birthdayVal) {
            $("#birthday").val(birthdayVal);
        }
        var phoneVal = sessionStorage.getItem("phone_value");
        if (phoneVal) {
            $("#phone").val(phoneVal);
        }
        var emailVal = sessionStorage.getItem("email_value");
        if (emailVal) {
            $("#email").val(emailVal);
        }
    });
</script>