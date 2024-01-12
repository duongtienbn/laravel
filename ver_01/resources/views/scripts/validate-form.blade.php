<script>
    $(document).ready(function() {
            $('#birthday').change(function() {
                getAge();
            });
            function getAge() {
                var age = calculateAge($('#birthday').val());
                $('#age').val(age);
            }
            getAge();
            function calculateAge(dateString) {
                var birthday = new Date(dateString);
                var today = new Date();
                var age = today.getFullYear() - birthday.getFullYear();
                var m = today.getMonth() - birthday.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
                    age--;
                }
                return age;
            }
        });
</script>
<script>
    //validate form
    function validateName() {
        var name = $('#name').val();
        // console.log(name);
        if (name.length === 0) {
            $('#nameError').html('<i class="fa-solid fa-circle-exclamation"></i>');
            $('#name').attr('style', 'border-color: red');
            $('#name-mess').html("名前を空白にすることはできません。!");
            return false;
        }
        $('#nameError').html('<i class="fa-solid fa-circle-check" style="color: seagreen;"></i>');
        $('#name').attr('style', 'border-color: seagreen');
        $('#name-mess').html("");
        return true;
    }

    function validateNameKana() {
    var name_kana = $('#name_kana').val();
    
    if (name_kana.length === 0) {
        $('#name_kana').html('<i class="fa-solid fa-circle-exclamation"></i>');
        $('#name_kana').attr('style', 'border-color: none');
        $('#nameKanaError').html('');
        $('#name-kana-mess').html('');
        return true;
    } else if (/^[\p{Script=Katakana}\u0020\u3000ー　]+$/u.test(name_kana)) {
        $('#name_kana').attr('style', 'border-color: seagreen');
        $('#nameKanaError').html('<i class="fa-solid fa-circle-check" style="color: seagreen;"></i>');
        $('#name-kana-mess').html('');
        return true;
    } else {
        $('#name_kana').attr('style', 'border-color: red');
        $('#nameKanaError').html('<i class="fa-solid fa-circle-exclamation"></i>');
        $('#name-kana-mess').html("正しいカタカナ名を入力してください。！");
        return false;
    }
}

    function validatePhone() {
        var phone = $('#phone').val();
        if (phone.length === 0) {
            $('#phoneError').html("");
            $('#phone').attr('style', 'border-color: none');
            $('#phone-mess').html("");
            return true;
        } else if (/^\d+(?:-\d+)*$/.test(phone)) {
            $('#phoneError').html('<i class="fa-solid fa-circle-check" style="color: seagreen;"></i>');
            $('#phone').attr('style', 'border-color: seagreen');
            $('#phone-mess').html("");
            return true;
        } else {
            $('#phoneError').html('<i class="fa-solid fa-circle-exclamation"></i>');
            $('#phone').attr('style', 'border-color: red');
            $('#phone-mess').html("正しい電話番号を入力してください。!");
            return false;
        }
    }

    function validateEmail() {
        var email = $('#email').val();
        if (email.length === 0) {
            $('#emailError').html("");
            $('#email').attr('style', 'border-color: none');
            $('#email-mess').html("");
            return true;
        } else if (/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,5})$/.test(email)) {
            $('#emailError').html('<i class="fa-solid fa-circle-check" style="color: seagreen;"></i>');
            $('#email').attr('style', 'border-color: seagreen');
            $('#email-mess').html("");
            return true;
        } else {
            $('#emailError').html('<i class="fa-solid fa-circle-exclamation"></i>');
            $('#email').attr('style', 'border-color: red');
            $('#email-mess').html("正しいメールを入力してください。!");
            return false;
        }
    }

    function whenInputName() {
        $('#nameError').html("");
        $('#name').attr('style', 'border-color: none');
        $('#name-mess').html("");
        $('#php_err_mess').text('');
        return true;
    }
    function whenInputNameKana() {
        $('#nameKanaError').html("");
        $('#nameKana').attr('style', 'border-color: none');
        $('#name-kana-mess').html("");
        $('#php_err_mess_kana').text('');
        return true;
    }
    function whenInputPhone() {
        $('#phoneError').html("");
        $('#phone').attr('style', 'border-color: none');
        $('#phone-mess').html("");
        $('#php_phone_err_mess').text('');
        return true;
    }
    function whenInputEmail() {
        $('#emailError').html("");
        $('#email').attr('style', 'border-color: none');
        $('#email-mess').html("");
        $('#php_email_err_mess').text('');
        return true;
    }
</script>