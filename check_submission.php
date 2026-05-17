<?php
// Create a test image file for upload
$testImagePath = 'test_image.jpg';
$imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
file_put_contents($testImagePath, $imageData);

$cookieJar = 'cookiejar.txt';
echo "[+] Using cookie jar: $cookieJar\n";

// Prepare form data
$formData = [
  'judulberita' => 'Test Berita - ' . date('Y-m-d H:i:s'),
  'tanggalberita' => date('Y-m-d'),
  'isiberita' => 'Ini adalah konten berita test untuk pengajuan member'
];

echo "[+] Form Data:\n";
foreach($formData as $k => $v) {
  echo "    $k: $v\n";
}

// Create multipart form data
$boundary = '----WebKitFormBoundary' . md5(time());
$body = '';

foreach($formData as $name => $value) {
  $body .= "--$boundary\r\n";
  $body .= "Content-Disposition: form-data; name=\"$name\"\r\n\r\n";
  $body .= $value . "\r\n";
}

// Add file
$body .= "--$boundary\r\n";
$body .= "Content-Disposition: form-data; name=\"gambarberita_file\"; filename=\"test_image.jpg\"\r\n";
$body .= "Content-Type: image/jpeg\r\n\r\n";
$body .= file_get_contents($testImagePath);
$body .= "\r\n--$boundary--\r\n";

echo "\n[+] Submitting form to http://localhost:8080/member/berita/store\n";

$ch = curl_init('http://localhost:8080/member/berita/store');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: multipart/form-data; boundary=' . $boundary
]);
curl_setopt($ch, CURLOPT_VERBOSE, false);

$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "\n========== RESPONSE DETAILS ==========\n";
echo "[+] HTTP Status Code: " . $info['http_code'] . "\n";
echo "[+] Content-Type: " . $info['content_type'] . "\n";
echo "[+] Total Response Size: " . strlen($response) . " bytes\n";

// Parse headers from response if available
if(!empty($info['redirect_url'])) {
  echo "[+] Redirect URL: " . $info['redirect_url'] . "\n";
}

echo "\n========== RESPONSE BODY (first 1500 chars) ==========\n";
echo substr($response, 0, 1500);
echo "\n\n[...Full response size: " . strlen($response) . " bytes]\n";

// Check if response contains success message
if(stripos($response, 'success') !== false) {
  echo "\n[✓] SUCCESS MESSAGE FOUND IN RESPONSE\n";
} elseif(stripos($response, 'error') !== false) {
  echo "\n[✗] ERROR MESSAGE FOUND IN RESPONSE\n";
}
?>
