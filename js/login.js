$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const password = $('#password').val();

        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    // Store session token in localStorage
                    localStorage.setItem('session_token', res.token);
                    localStorage.setItem('user_email', email);
                    
                    $('#responseMessage').html('<div class="alert alert-success">Login successful! Redirecting...</div>');
                    setTimeout(() => {
                        window.location.href = 'profile.html';
                    }, 1500);
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
