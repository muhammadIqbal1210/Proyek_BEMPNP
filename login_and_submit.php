<?php
// === STEP 1: LOGIN ===
echo "========== STEP 1: MEMBER LOGIN ==========\n";

$cookieJar = 'cookiejar_new.txt';
$loginUrl = 'http://localhost:8080/index.php/login';
$storeUrl = 'http://localhost:8080/index.php/login/store';

// First, GET the login page to get any CSRF tokens
echo "[+] Getting login page...\n";
$ch = curl_init($loginUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$loginPage = curl_exec($ch);
curl_close($ch);
echo "[+] Login page retrieved (" . strlen($loginPage) . " bytes)\n";

// Extract CSRF token if present
$csrf = '';
if(preg_match('/<input[^>]*name=["\']_token["\'][^>]*value=["\']([^"\']+)["\']/', $loginPage, $matches)) {
  $csrf = $matches[1];
  echo "[+] Found CSRF token: " . substr($csrf, 0, 20) . "...\n";
}

// POST login with credentials
echo "\n[+] Logging in with member@bem.ac.id / member123...\n";

$loginData = http_build_query([
  'email' => 'member@bem.ac.id',
  'password' => 'member123',
  '_token' => $csrf
]);

echo "[+] POST data: email=member@bem.ac.id, password=member123\n";

$ch = curl_init($storeUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/x-www-form-urlencoded'
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects yet

$loginResponse = curl_exec($ch);
$loginInfo = curl_getinfo($ch);
curl_close($ch);

echo "[+] Login Response Status: " . $loginInfo['http_code'] . "\n";
if(!empty($loginInfo['redirect_url'])) {
  echo "[+] Redirect to: " . $loginInfo['redirect_url'] . "\n";
}

// === STEP 2: SUBMIT BERITA FORM ===
echo "\n========== STEP 2: SUBMIT BERITA FORM ==========\n";

// Create test image
$testImagePath = 'test_image.jpg';
$imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
file_put_contents($testImagePath, $imageData);
echo "[+] Created test image: $testImagePath\n";

// Prepare form data
$formData = [
  'judulberita' => 'Test Berita - ' . date('Y-m-d H:i:s'),
  'tanggalberita' => date('Y-m-d'),
  'isiberita' => 'Ini adalah konten berita test untuk pengajuan member'
];

echo "\n[+] Form Data:\n";
foreach($formData as $k => $v) {
  echo "    $k: " . substr($v, 0, 50) . "...\n";
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

// Submit form with logged-in cookies
$submitUrl = 'http://localhost:8080/member/berita/store';
echo "\n[+] Submitting berita form to: $submitUrl\n";

$ch = curl_init($submitUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: multipart/form-data; boundary=' . $boundary
]);

$submitResponse = curl_exec($ch);
$submitInfo = curl_getinfo($ch);
curl_close($ch);

// === DISPLAY RESULTS ===
echo "\n========== SUBMISSION RESULTS ==========\n";
echo "[+] Response Status Code: " . $submitInfo['http_code'] . "\n";
echo "[+] Content-Type: " . $submitInfo['content_type'] . "\n";
echo "[+] Response Size: " . strlen($submitResponse) . " bytes\n";

if(!empty($submitInfo['redirect_url'])) {
  echo "[+] Redirect URL: " . $submitInfo['redirect_url'] . "\n";
}

echo "\n========== RESPONSE BODY (first 2000 chars) ==========\n";
echo substr($submitResponse, 0, 2000);
echo "\n\n[...Full response size: " . strlen($submitResponse) . " bytes]\n";

// Check for success/error indicators
if($submitInfo['http_code'] == 303 && stripos($submitInfo['redirect_url'] ?? '', 'login') === false) {
  echo "\n[✓] SUCCESS: Form submitted with redirect (HTTP 303)\n";
} elseif($submitInfo['http_code'] >= 200 && $submitInfo['http_code'] < 300) {
  echo "\n[✓] SUCCESS: Form submitted (HTTP " . $submitInfo['http_code'] . ")\n";
} else {
  echo "\n[✗] ERROR: Unexpected response code " . $submitInfo['http_code'] . "\n";
}
?>
