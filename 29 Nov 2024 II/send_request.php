<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['fileToUpload'];
    $targetDir = $_POST['targetDir'];

    // Check if the directory exists
    if (!is_dir($targetDir)) {
        echo "The directory '$targetDir' does not exist.";
    } else {
        // Define the target file path
        $targetFile = rtrim($targetDir, '/') . '/' . basename($file['name']);
        
        // Check if the file was uploaded without errors
        if ($file['error'] == 0) {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo "The file " . basename($file['name']) . " has been uploaded successfully to '$targetDir'.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "There was an error uploading your file. Error code: " . $file['error'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload a File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Choose a file:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
        
        <label for="targetDir">Target Directory (on the server):</label>
        <input type="text" name="targetDir" id="targetDir" required><br><br>
        
        <input type="submit" value="Upload File">
    </form>
</body>
</html>
