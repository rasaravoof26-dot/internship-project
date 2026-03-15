$(document).ready(function() {
    function loadAdminData() {
        $('#adminTableBody').html('<tr><td colspan="8" class="text-center">Loading data...</td></tr>');
        
        $.ajax({
            url: 'php/admin_data.php',
            type: 'GET',
            success: function(response) {
                // Ensure response is an object
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (res.status === 'success') {
                    let html = '';
                    res.users.forEach(user => {
                        const profile = res.profiles[user.id] || {};
                        html += `
                            <tr>
                                <td>${user.id}</td>
                                <td class="fw-bold">${user.name}</td>
                                <td>${user.email}</td>
                                <td><code class="small text-truncate d-inline-block" style="max-width: 100px;">${user.password}</code></td>
                                <td><span class="badge bg-info text-dark">${profile.age || '-'}</span></td>
                                <td>${profile.dob || '-'}</td>
                                <td>${profile.contact || '-'}</td>
                                <td class="small text-muted">${profile.address || '-'}</td>
                                <td>${user.created_at}</td>
                            </tr>
                        `;
                    });
                    
                    if (res.users.length === 0) {
                        html = '<tr><td colspan="8" class="text-center">No users found.</td></tr>';
                    }
                    
                    $('#adminTableBody').html(html);
                } else {
                    $('#adminTableBody').html('<tr><td colspan="8" class="text-center text-danger">Error: ' + res.message + '</td></tr>');
                }
            },
            error: function() {
                $('#adminTableBody').html('<tr><td colspan="8" class="text-center text-danger">Failed to fetch data from server.</td></tr>');
            }
        });
    }

    $('#refreshBtn').on('click', loadAdminData);
    loadAdminData();
});
