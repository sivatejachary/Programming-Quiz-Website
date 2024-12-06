<?php
// Get user's score from database
$email = "user@example.com"; // Replace with actual email address
$conn = mysqli_connect("localhost", "username", "password", "database");
$result = mysqli_query($conn, "SELECT score FROM quiz_results WHERE email='$email'");
$row = mysqli_fetch_assoc($result);
$score = $row['score'];

// Generate certificate
$image = imagecreatefrompng("certificate_template.png");
$font_color = imagecolorallocate($image, 255, 255, 255);
$font_size = 40;
$font = "arial.ttf"; // Replace with path to actual font file
imagettftext($image, $font_size, 0, 500, 500, $font_color, $font, "Certificate of Completion");
imagettftext($image, $font_size, 0, 500, 600, $font_color, $font, "Score: $score");

// Save certificate as a file
$filename = "certificate_" . time() . ".png";
imagepng($image, $filename);

// Send certificate to user's registered email address
$to = $email;
$subject = "Certificate for Quiz Score";
$message = "Congratulations on your score of $score! Attached is your certificate.";
$headers = "From: j.shivachary@gmail.com"; // Replace with actual email address
$attachments = array($filename);
$mime_boundary = "xyz123";
$headers .= "\nMIME-Version: 1.0\nContent-Type: multipart/mixed;\n boundary=\"$mime_boundary\"";
$message .= "--$mime_boundary\n";
$attachment_count = count($attachments);
for ($i=0; $i<$attachment_count; $i++) {
    $attachment = chunk_split(base64_encode(file_get_contents($attachments[$i])));
    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$attachments[$i]\"\n" .
    "Content-Disposition: attachment;\n" . " filename=\"$attachments[$i]\"\n" .
    "Content-Transfer-Encoding: base64\n\n" . $attachment . "\n\n";
    $message .= "--$mime_boundary\n";
}
mail($to, $subject, $message, $headers);

// Clean up
imagedestroy($image);
unlink($filename);
?>
