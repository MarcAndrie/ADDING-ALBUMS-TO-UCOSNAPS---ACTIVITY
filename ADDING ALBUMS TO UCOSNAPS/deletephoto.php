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
	<?php $getPhotoByID = getPhotoByID($pdo, $_GET['photo_id']); ?>
	<div class="deletePhotoForm" style="display: flex; justify-content: center;">
		<div class="deleteForm" style="border-style: solid; border-color: red; background-color: #ffcbd1; padding: 10px; width: 50%;">
			<form action="core/handleForms.php" method="POST">
				<p>
					<label for=""><h2>Are you sure you want to delete this photo below?</h2></label>
					<input type="hidden" name="photo_name" value="<?php echo $getPhotoByID['photo_name']; ?>">
					<input type="hidden" name="photo_id" value="<?php echo $_GET['photo_id']; ?>">
					<input type="submit" name="deletePhotoBtn" style="margin-top: 10px;" value="Delete">
				</p>
			</form>
		</div>
	</div>
	<div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
		<div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">

			<img src="images/<?php echo $getPhotoByID['photo_name']; ?>" alt="" style="width: 100%;">

			<div class="photoDescription" style="padding:25px;">
				<a href="#"><h2>Ivan</h2></a>
				<h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid iusto sequi tenetur. Non molestiae, blanditiis minus corporis ipsa harum itaque expedita aut voluptate dolorem voluptatibus unde dignissimos placeat nostrum quia?</h4>
				<a href="" style="float: right;">View Comments</a>
			</div>
		</div>
	</div>
</body>
</html>