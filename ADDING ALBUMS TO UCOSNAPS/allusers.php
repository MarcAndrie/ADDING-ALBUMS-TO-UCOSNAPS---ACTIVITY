<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php  
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="container" style="display: flex; justify-content: center;">
		<div class="allUsers" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 25%; text-align: center;">
			<h1>All Users</h1>
			<ul style="display: flex; flex-direction: column; align-items: center; list-style-type: disc; padding: 0;">
				<?php $getAllUsers = getAllUsers($pdo); ?>
				<?php foreach ($getAllUsers as $row) { ?>
					<li style="margin-top: 10px;"><a href="profile.php?username=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</body>
</html>