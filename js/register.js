$(document).ready(function() {
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();
        
        const name = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();

        if (password !== confirmPassword) {
            $('#responseMessage').html('<div class="alert alert-danger">Passwords do not match!</div>');
            return;
        }

        $.ajax({
            url: 'php/register.php',
            type: 'POST',
            data: {
                name: name,
                email: email,
                password: password
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#responseMessage').html('<div class="alert alert-success">' + res.message + '</div>');
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 2000);
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            },
            error: function() {
                $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
            }
        });
    });
});
