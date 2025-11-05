<?php while($user=mysqli_fetch_array($users)){ ?>
<tr>
    <td><?php echo $user['user_id']; ?></td>
    <td><?php echo $user['user_name']; ?></td>
    <td><?php echo $user['user_email']; ?></td>
    <td><?php echo $user['user_status']==0 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
    <td>
        <button class="btn btn-sm btn-warning edit_user" data-id="<?php echo $user['user_id']; ?>">
            <i class="mdi mdi-pencil"></i>
        </button>
    </td>
</tr>
<?php } ?>