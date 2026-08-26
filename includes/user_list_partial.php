<?php
while ($user = mysqli_fetch_array($users)) {
    $role = $user['user_type'] == 1 ? 'Admin' : ($user['user_type'] == 2 ? 'Staff' : '—');
    $hasMfa = !empty($user['google_auth_secret']);
    $uid = (int)$user['user_id'];
    $isSelf = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === $uid;
?>
<tr>
    <td><?php echo $uid; ?></td>
    <td><?php echo htmlspecialchars($user['user_name']); ?></td>
    <td><?php echo htmlspecialchars($user['user_email']); ?></td>
    <td><?php echo $role; ?></td>
    <td><?php echo $user['user_status'] == 0 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
    <td>
        <?php if ($hasMfa): ?>
            <span class="badge bg-info">MFA On</span>
        <?php else: ?>
            <span class="badge bg-secondary">MFA Off</span>
        <?php endif; ?>
    </td>
    <td>
        <div class="d-flex flex-wrap gap-1">
            <button type="button" class="btn btn-sm btn-warning edit_user" data-id="<?php echo $uid; ?>" title="Edit">
                <i class="mdi mdi-pencil"></i> Edit
            </button>
            <button type="button" class="btn btn-sm btn-outline-primary reset_mfa_user"
                data-id="<?php echo $uid; ?>"
                data-name="<?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?>"
                <?php echo $hasMfa ? '' : 'disabled'; ?>
                title="Reset authenticator">
                <i class="mdi mdi-shield-key"></i> Reset MFA
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger delete_user"
                data-id="<?php echo $uid; ?>"
                data-name="<?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?>"
                <?php echo $isSelf ? 'disabled' : ''; ?>
                title="<?php echo $isSelf ? 'You cannot delete your own account' : 'Delete permanently'; ?>">
                <i class="mdi mdi-delete"></i> Delete
            </button>
        </div>
    </td>
</tr>
<?php } ?>
