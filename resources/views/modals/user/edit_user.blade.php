<div class="modal fade preview-modal" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" id="editUserId">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" name="edit_first_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="edit_middle_name" name="edit_middle_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_last_name">Last Name</label>
                                <input type="text" class="form-control" id="edit_last_name" name="edit_last_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_user_name">User Name</label>
                                <input type="text" class="form-control" id="edit_user_name" name="edit_user_name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="edit_email" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="edit_password" name="edit_password">
                                    <div class="input-group-append" id="edittogglePassword">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_role">Role</label>
                                <select data-placeholder="Select Role" type="text" class="form-control"
                                    id="edit_role" name="edit_role" required>
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
    $('#edittogglePassword').on('click', function() {
        var passwordField = $('#edit_password');
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
