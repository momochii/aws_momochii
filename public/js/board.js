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

const delBoard = (id) => {
    if (confirm('정말로 삭제 하시겠습니까??')) {
        $.ajax({
                url : `/boards/${id}`
                ,type : 'DELETE'
                ,headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF 토큰을 헤더에 추가
                }
                ,dataType: 'json'
                ,success : function(res) {
                    alert(res.message);
                    location.href='/boards/';
                }
            });
    }
}
