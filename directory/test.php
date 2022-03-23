<?php
$b = "http://www.whatever.com";
$sanitized_b = filter_var($b, FILTER_SANITIZE_URL);
echo "Are you mad $b - $sanitized_b<br>";

if (preg_match("/\bhttp:\/\/\b/i", $b)) {
    echo "A match was found.";
} else {
    echo "A match was not found.";
}


if (filter_var($sanitized_b, FILTER_VALIDATE_URL)) {
  echo "before: $b<br>";
  echo "After $sanitized_b<br>";
}
?>
