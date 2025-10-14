$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'back/login.php',
            data: $(this).serialize(),
            dataType: 'json',
            
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = 'admin/';
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: " + textStatus, errorThrown);
                alert('Ocorreu um erro ao tentar fazer login. Tente novamente.');
            }
        });
    });
});