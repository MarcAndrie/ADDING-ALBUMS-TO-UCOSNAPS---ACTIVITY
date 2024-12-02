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

	<?php $getUserByID = getUserByID($pdo, $_GET['username']); ?>
	<div class="container" style="display: flex; justify-content: center;">
		<div class="userInfo" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%; text-align: center;">
			<h3>Username: <span style="color: blue"><?php echo $getUserByID['username']; ?></span></h3>
			<h3>First Name: <span style="color: blue"><?php echo $getUserByID['first_name']; ?></span></h3>
			<h3>Last Name: <span style="color: blue"><?php echo $getUserByID['last_name']; ?></span></h3>
			<h3>Date Joined: <span style="color: blue"><?php echo $getUserByID['date_added']; ?></span></h3>
		</div>
	</div>


	<?php $getAllPhotos = getAllPhotos($pdo, $_GET['username']); ?>
	<?php foreach ($getAllPhotos as $row) { ?>
	<div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
		<div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">

			<img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">

			<div class="photoDescription" style="padding:25px;">
				<a href="#"><h2><?php echo $row['username']; ?></h2></a>
				<p><i><?php echo $row['date_added']; ?></i></p>
				<h4><?php echo $row['description']; ?></h4>

				<?php if ($_SESSION['username'] == $row['username']) { ?>
					<a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
					<br>
					<br>
					<a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>

</body>
</html>