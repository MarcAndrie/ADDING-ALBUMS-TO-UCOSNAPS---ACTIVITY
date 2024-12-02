<?php  
require_once 'dbConfig.php';
require_once 'models.php';


// Other existing handlers (insertNewUserBtn, loginUserBtn, etc.) remain unchanged

if (isset($_POST['insertPhotoBtn'])) {
    // Get Description
    $description = $_POST['photoDescription'];

    // Get file details
    $fileName = $_FILES['image']['name'];
    $tempFileName = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];

    // Get existing photo_id if editing
    $photo_id = isset($_POST['photo_id']) ? $_POST['photo_id'] : null;
    $oldPhotoName = isset($_POST['old_photo_name']) ? $_POST['old_photo_name'] : null;

    // If editing, update only the description if no new file is uploaded
    if ($photo_id && empty($fileName)) {
        $updatePhoto = updatePhotoDescription($pdo, $photo_id, $description);
        if ($updatePhoto) {
            $_SESSION['message'] = "Photo description updated successfully.";
        } else {
            $_SESSION['message'] = "Failed to update photo description.";
        }
        header("Location: ../index.php");
        exit();
    }

    // Check for file upload errors
    if ($fileError !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "File upload error code: $fileError";
        header("Location: ../index.php");
        exit();
    }

    // Ensure temp file exists
    if (!file_exists($tempFileName) || empty($tempFileName)) {
        $_SESSION['message'] = "Temporary file does not exist or was not uploaded.";
        header("Location: ../index.php");
        exit();
    }

    // Get file extension and unique name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueID = sha1(md5(rand(1, 9999999)));
    $imageName = $uniqueID . "." . $fileExtension;

    // Specify path
    $folder = __DIR__ . '/../images/' . $imageName;

    // Create directory if it doesn't exist
    if (!file_exists(dirname($folder))) {
        mkdir(dirname($folder), 0777, true);
    }

    // Save image 'record' to database (insert or update)
    if ($photo_id) {
        // Update existing record
        $saveImgToDb = updatePhoto($pdo, $photo_id, $imageName, $_SESSION['username'], $description);
    } else {
        // Insert new record
        $saveImgToDb = insertPhoto($pdo, $imageName, $_SESSION['username'], $description, "");
    }

    // Move file to the specified path
    if ($saveImgToDb && move_uploaded_file($tempFileName, $folder)) {
        if ($photo_id && $oldPhotoName) {
            // Delete the old photo file
            $oldFilePath = __DIR__ . '/../images/' . $oldPhotoName;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        $_SESSION['message'] = "Photo saved successfully.";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to save photo.";
        header("Location: ../index.php");
        exit();
    }
}
if (isset($_POST['deletePhotoBtn'])) {
    $photo_name = $_POST['photo_name'];
    $photo_id = $_POST['photo_id'];

    // Ensure both photo_name and photo_id are provided
    if (!empty($photo_name) && !empty($photo_id)) {
        $deletePhoto = deletePhoto($pdo, $photo_id);

        if ($deletePhoto) {
            $filePath = __DIR__ . '/../images/' . $photo_name;

            // Check if the file exists before attempting to delete
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $_SESSION['message'] = "Photo deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete photo from database.";
        }
    } else {
        $_SESSION['message'] = "Invalid photo ID or name.";
    }

    // Redirect to index.php regardless of success or failure
    header("Location: ../index.php");
    exit();
}

