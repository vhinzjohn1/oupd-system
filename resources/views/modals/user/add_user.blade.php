<div class="modal fade preview-modal" id="addUsersModal" tabindex="-1" role="dialog" aria-labelledby="addUsersModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUsersModalLabel">Add User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_first_name">First Name</label>
                                <input type="text" class="form-control" id="add_first_name" name="add_first_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="add_middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="add_middle_name" name="add_middle_name">
                            </div>
                            <div class="form-group">
                                <label for="add_last_name">Last Name</label>
                                <input type="text" class="form-control" id="add_last_name" name="add_last_name">
                            </div>
                            <div class="form-group">
                                <label for="add_user_name">User Name</label>
                                <input type="text" class="form-control" id="add_user_name" name="add_user_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_email">Email</label>
                                <input type="email" class="form-control" id="add_email" name="add_email">
                            </div>
                            <div class="form-group">
                                <label for="add_password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="add_password" name="add_password">
                                    <div class="input-group-append" id="togglePassword">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="add_role">Role</label>
                                <select data-placeholder="Select Role" type="text" class="form-control"
                                    id="add_role" name="add_role" required>
                                    <option value=""></option>
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn bg-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#togglePassword').on('click', function() {
        var passwordField = $('#add_password');
        var toggleIcon = $(this).find('i');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
</script>
