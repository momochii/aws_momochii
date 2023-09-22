const boardWrite = () => {

    let check = true;
    $('.check-invalid').each(function () {
        if ($(this).val() == '') {
            $(this).addClass('is-invalid');
            check = false;
        }
    });

     if (check) {
        $('form[name=boardForm]').submit();
    }
}
