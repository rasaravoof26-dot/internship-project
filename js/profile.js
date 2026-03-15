$(document).ready(function() {
    // Check if logged in
    const token = localStorage.getItem('session_token');
    if (!token) {
        window.location.href = 'login.html';
        return;
    }

    // Fetch profile data
    $.ajax({
        url: 'php/profile.php',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                if (res.data) {
                    $('#age').val(res.data.age);
                    $('#dob').val(res.data.dob);
                    $('#contact').val(res.data.contact);
                    $('#address').val(res.data.address);
                }
            } else {
                localStorage.removeItem('session_token');
                window.location.href = 'login.html';
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            localStorage.removeItem('session_token');
            window.location.href = 'login.html';
        }
    });

    // Update profile data
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        const data = {
            age: $('#age').val(),
            dob: $('#dob').val(),
            contact: $('#contact').val(),
            address: $('#address').val()
        };

        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: data,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#responseMessage').html('<div class="alert alert-success">' + res.message + '</div>');
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#responseMessage').html('<div class="alert alert-danger">Server error occurred. Please check console.</div>');
            }
        });
    });

    // Logout
    $('#logoutBtn').on('click', function() {
        localStorage.removeItem('session_token');
        window.location.href = 'login.html';
    });
});
