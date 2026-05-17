<?php
// Create a test image file for upload
$testImagePath = 'test_image.jpg';
$imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
file_put_contents($testImagePath, $imageData);
echo "[+] Created test image: $testImagePath\n";

// Login first to get fresh cookies
$cookieJar = 'cookiejar.txt';
echo "[+] Using cookie jar: $cookieJar\n";

// Check if cookies exist
if(file_exists($cookieJar)) {
  echo "[+] Cookie jar exists, reading content...\n";
  $cookies = file_get_contents($cookieJar);
  echo substr($cookies, 0, 200) . "...\n";
}

// Prepare form data
$formData = [
  'judulberita' => 'Test Berita - ' . date('Y-m-d H:i:s'),
  'tanggalberita' => date('Y-m-d'),
  'isiberita' => 'Ini adalah konten berita test untuk pengajuan member'
];

echo "\n[+] Form Data:\n";
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

echo "\n[+] Response Status Code: " . $info['http_code'] . "\n";
echo "[+] Response Content-Type: " . $info['content_type'] . "\n";
echo "[+] Response Size: " . strlen($response) . " bytes\n";

echo "\n[+] Response Body (first 2000 chars):\n";
echo "=" . str_repeat('=', 79) . "\n";
echo substr($response, 0, 2000);
echo "\n" . str_repeat('=', 80) . "\n";

if(strlen($response) > 2000) {
  echo "[...truncated, total size: " . strlen($response) . " bytes]\n";
}
?>
