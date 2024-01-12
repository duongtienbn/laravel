
<script>
    // Lưu giá trị của ô input vào sessionStorage khi người dùng nhập liệu
    $("#name").on("input", function() {
        sessionStorage.setItem("name_value", $(this).val());
    });
    $("#name_kana").on("input", function() {
        sessionStorage.setItem("name_kana_value", $(this).val());
    });
    $(".sex").change(function() {
        // Lấy giá trị của input radio được chọn
        var sexVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("sex_value", sexVal);
    });
    $("#birthday").on("input", function() {
        sessionStorage.setItem("birthday_value", $(this).val());
    });
    $("#age").on("input", function() {
        sessionStorage.setItem("age_value", $(this).val());
    });
    $("#first_interv_date").on("input", function() {
        sessionStorage.setItem("first_interv_date_value", $(this).val());
    });
    $(".first_interv_result").change(function() {
        // Lấy giá trị của input radio được chọn
        var first_interv_resultVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("first_interv_result_value", first_interv_resultVal);
    });
    $("#sec_interv_date").on("input", function() {
        sessionStorage.setItem("sec_interv_date_value", $(this).val());
    });
    $(".sec_interv_result").change(function() {
        // Lấy giá trị của input radio được chọn
        var sec_interv_resultVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("sec_interv_result_value", sec_interv_resultVal);
    });
    $("#hire_date").on("input", function() {
        sessionStorage.setItem("hire_date_value", $(this).val());
    });
    $("#intern_interv_date").on("input", function() {
        sessionStorage.setItem("intern_interv_date_value", $(this).val());
    });
    $(".intern_result").change(function() {
        // Lấy giá trị của input radio được chọn
        var intern_resultVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("intern_result_value", intern_resultVal);
    });
    $("#phone").on("input", function() {
        sessionStorage.setItem("phone_value", $(this).val());
    });
    $("#email").on("input", function() {
        sessionStorage.setItem("email_value", $(this).val());
    });
    $("#skill_jlpt").change(function() {
        // Lấy giá trị của input radio được chọn
        var skill_jlptVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("skill_jlpt_value", skill_jlptVal);
    });
    $("#skill_hearing").change(function() {
        // Lấy giá trị của input radio được chọn
        var skill_hearingVal = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem("skill_hearing_value", skill_hearingVal);
    });
    $("#skill_speaking").change(function() {
        var skill_speakingVal = $(this).val();
        sessionStorage.setItem("skill_speaking_value", skill_speakingVal);
    });
    $("#skill_reading").change(function() {
        var skill_readingVal = $(this).val();
        sessionStorage.setItem("skill_reading_value", skill_readingVal);
    });
    $('#graduate_4').change(function() {
        if ($(this).is(':checked')) {
            $(this).prop('value', 1);
        } else {
            $(this).prop('value', 0);
        }
        sessionStorage.setItem("graduate_4_value", $(this).val());
    });
    $('#graduate_2').change(function() {
        if ($(this).is(':checked')) {
            $(this).prop('value', 1);
        } else {
            $(this).prop('value', 0);
        }
        sessionStorage.setItem("graduate_2_value", $(this).val());
    });
    $("#graduate_school").on("input", function() {
        sessionStorage.setItem("graduate_school_value", $(this).val());
    });
    $("#current_status").on("input", function() {
        sessionStorage.setItem("current_status_value", $(this).val());
    });
    $("#note").on("input", function() {
        sessionStorage.setItem("note_value", $(this).val());
    });
    $('#first_interv_staff').change(function() {
        // Lấy giá trị được chọn
        var first_interv_staffValue = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem('first_interv_staff_value', first_interv_staffValue);
    });
    $('#sec_interv_staff').change(function() {
        // Lấy giá trị được chọn
        var sec_interv_staffValue = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem('sec_interv_staff_value', sec_interv_staffValue);
    });
    $('#intern_department').change(function() {
        // Lấy giá trị được chọn
        var intern_departmentValue = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem('intern_department_value', intern_departmentValue);
    });
    $('#working_place').change(function() {
        // Lấy giá trị được chọn
        var working_placeValue = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem('working_place_value', working_placeValue);
    });
    $('#apply_department').change(function() {
        // Lấy giá trị được chọn
        var apply_departmentValue = $(this).val();
        // Lưu giá trị vào sessionStorage
        sessionStorage.setItem('apply_department_value', apply_departmentValue);
    });
    // $('.drawer').find('li').on('click',function() {
    //     // Lưu giá trị mới vào session storage
    //     var dataValue = $(this).attr('data-value');
    //     var skill_seVal = $(this).val();
    //     console.log(dataValue);
    //     sessionStorage.setItem('skill_se_value', JSON.stringify(skill_seVal));
    // });
    $(window).on("load", function() {
        var nameVal = sessionStorage.getItem("name_value");
        if (nameVal) {
            $("#name").val(nameVal);
        }
        var nameKanaVal = sessionStorage.getItem("name_kana_value");
        if (nameKanaVal) {
            $("#name_kana").val(nameKanaVal);
        }
        var sexVal = sessionStorage.getItem("sex_value");
        if (sexVal) {
            $('input[type=radio][name=sex][value=' + sexVal + ']').prop('checked', true);
        }
        var birthdayVal = sessionStorage.getItem("birthday_value");
        if (birthdayVal) {
            $("#birthday").val(birthdayVal);
        }
        var ageVal = sessionStorage.getItem("age_value");
        if (ageVal) {
            $("#age").val(ageVal);
        }
        var first_interv_dateVal = sessionStorage.getItem("first_interv_date_value");
        if (first_interv_dateVal) {
            $("#first_interv_date").val(first_interv_dateVal);
        }
        var first_interv_resultVal = sessionStorage.getItem("first_interv_result_value");
        if (first_interv_resultVal) {
            $('input[type=radio][name=first_interv_result][value=' + first_interv_resultVal + ']').prop(
                'checked', true);
        }
        var sec_interv_dateVal = sessionStorage.getItem("sec_interv_date_value");
        if (sec_interv_dateVal) {
            $("#sec_interv_date").val(sec_interv_dateVal);
        }
        var sec_interv_resultVal = sessionStorage.getItem("sec_interv_result_value");
        if (sec_interv_resultVal) {
            $('input[type=radio][name=sec_interv_result][value=' + sec_interv_resultVal + ']').prop(
                'checked', true);
        }
        var hire_dateVal = sessionStorage.getItem("hire_date_value");
        if (hire_dateVal) {
            $("#hire_date").val(hire_dateVal);
        }
        var intern_interv_dateVal = sessionStorage.getItem("intern_interv_date_value");
        if (intern_interv_dateVal) {
            $("#intern_interv_date").val(intern_interv_dateVal);
        }
        var intern_resultVal = sessionStorage.getItem("intern_result_value");
        if (intern_resultVal) {
            $('input[type=radio][name=intern_result][value=' + intern_resultVal + ']').prop(
                'checked', true);
        }
        var phoneVal = sessionStorage.getItem("phone_value");
        if (phoneVal) {
            $("#phone").val(phoneVal);
        }
        var emailVal = sessionStorage.getItem("email_value");
        if (emailVal) {
            $("#email").val(emailVal);
        }
        var skill_jlptVal = sessionStorage.getItem("skill_jlpt_value");
        if (skill_jlptVal) {
            $('#skill_jlpt option[value="' + skill_jlptVal + '"]').prop('selected', true);
        }
        var skill_hearingVal = sessionStorage.getItem("skill_hearing_value");
        if (skill_hearingVal) {
            $('#skill_hearing option[value="' + skill_hearingVal + '"]').prop('selected', true);
        }
        var skill_speakingVal = sessionStorage.getItem("skill_speaking_value");
        if (skill_speakingVal) {
            $('#skill_speaking option[value="' + skill_speakingVal + '"]').prop('selected', true);
        }
        var skill_readingVal = sessionStorage.getItem("skill_reading_value");
        if (skill_readingVal) {
            $('#skill_reading option[value="' + skill_readingVal + '"]').prop('selected', true);
        }
        var graduate_4Val = sessionStorage.getItem("graduate_4_value");
        if (graduate_4Val) {
            $('input[type="checkbox"][name="graduate_4"]').val(graduate_4Val);
            $('input[type="checkbox"][name="graduate_4"][value="1"]').prop('checked', true);
        }
        var graduate_2Val = sessionStorage.getItem("graduate_2_value");
        if (graduate_2Val) {
            $('input[type="checkbox"][name="graduate_2"]').val(graduate_2Val);
            $('input[type="checkbox"][name="graduate_2"][value="1"]').prop('checked', true);
        }
        var graduate_schoolVal = sessionStorage.getItem("graduate_school_value");
        if (graduate_schoolVal) {
            $("#graduate_school").val(graduate_schoolVal);
        }
        var current_statusVal = sessionStorage.getItem("current_status_value");
        if (current_statusVal) {
            $("#current_status").val(current_statusVal);
        }
        var noteVal = sessionStorage.getItem("note_value");
        if (noteVal) {
            $("#note").val(noteVal);
        }
    });
</script>
