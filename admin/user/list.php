<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<style>
	/* .user-avatar {
		width: 3rem;
		height: 3rem;
		object-fit: scale-down;
		object-position: center center;
	} */

	.card {
		margin-top: 15px;
		background-color: #fff;
		border-radius: 20px;
		width: 100%;
		min-height: 550px;
		text-align: left;
		border: none;
	}

	h4 {
		margin: 10px;
		text-align: center;
	}

	div.form-group {
		padding: 25px;

	}

	.card-footer {
		background-color: transparent;
		text-align: center;
		justify-content: center;
	}

	.btn-primary {
		background-color: #F05454;
		border: none;
		width: 115px;
		border-radius: 20px;
		padding: 10px;
		font-size: 1em;
	}

	.btn-primary:hover {
		background-color: rgb(48, 71, 94);
	}

	table#list {
		background-color: #fff;
		border: none;
		width: 1100px;
		border-radius: 20px;
		padding: 10px;
		font-size: 1em;
	}

	button.btn {
		background-color: #DDDDDD;
		border: none;
		width: 80px;
		border-radius: 20px;
		padding: 10px;
		font-size: 1em;
	}

	button.btn:hover {
		background-color: rgb(48, 71, 94);
	}

	.card-title {
		margin-top: 15px;
		background-color: transparent;
		width: 150px;
		text-align: center;
	}
</style>
<div class="card  rounded-20 card-gray">
	<div class="card-header">
		<h3 class="card-title">List of Users</h3>
		<div class="card-tools">
			<a href="./?page=user/manage_user" id="create_new" class="btn  btn-primary"><span
					class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<!-- <col width="15%"> -->
					<col width="25%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Updated</th>
						<!-- <th>Avatar</th> -->
						<th>Name</th>
						<th>Username</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *, concat(firstname,' ', coalesce(concat(middlename,' '), '') , lastname) as `name` from `users` where id != '{$_settings->userdata('id')}' order by concat(firstname,' ', lastname) asc ");
					while ($row = $qry->fetch_assoc()):
						?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i", strtotime($row['date_updated'])) ?></td>
							<!-- <td class="text-center">
								<img src="<?= validate_image($row['avatar']) ?>" alt=""
									class="img-thumbnail rounded-circle user-avatar">
							</td> -->
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['username'] ?></td>
							<td class="text-center">
								<?php if ($row['type'] == 1): ?>
									Administrator
								<?php elseif ($row['type'] == 2): ?>
									Registered User
								<?php else: ?>
									N/A
								<?php endif; ?>
							</td>
							<td align="center">
								<button type="button" class="btn  p-1  dropdown-toggle dropdown-icon "
									data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item" href="./?page=user/manage_user&id=<?= $row['id'] ?>"><span
											class="fa fa-edit text-dark"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
										Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.delete_data').click(function () {
			_conf("Are you sure to delete this User permanently?", "delete_user", [$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [5] }
			],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_user($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=delete",
			method: "POST",
			data: { id: $id },
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function (resp) {
				if (resp == 1) {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>