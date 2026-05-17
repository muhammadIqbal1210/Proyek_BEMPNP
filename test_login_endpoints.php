<?php
// Try different login endpoint variations
$endpoints = [
  'http://localhost:8080/login/store',
  'http://localhost:8080/index.php/login/store',
  'http://localhost:8080/auth/login/store',
];

echo "========== TESTING LOGIN ENDPOINTS ==========\n";

$cookieJar = 'cookiejar_test.txt';

foreach($endpoints as $endpoint) {
  echo "\n[+] Testing: $endpoint\n";
  
  $loginData = http_build_query([
    'email' => 'member@bem.ac.id',
    'password' => 'member123'
  ]);
  
  $ch = curl_init($endpoint);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
  ]);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  
  $response = curl_exec($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);
  
  echo "    Response Code: " . $info['http_code'];
  if(!empty($info['redirect_url'])) {
    echo " (redirect to: " . $info['redirect_url'] . ")";
  }
  echo "\n";
}

// Also check available routes
echo "\n========== CHECKING LOGIN PAGE STRUCTURE ==========\n";
$ch = curl_init('http://localhost:8080/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$page = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "[+] GET /login response: " . $info['http_code'] . "\n";

// Look for form action
if(preg_match('/<form[^>]*action=["\']([^"\']+)["\']/', $page, $matches)) {
  echo "[+] Form action found: " . $matches[1] . "\n";
}

// Look for CSRF token
if(preg_match('/<input[^>]*name=["\']_token["\'][^>]*value=["\']([^"\']+)["\']/', $page, $matches)) {
  echo "[+] CSRF token found: " . substr($matches[1], 0, 20) . "...\n";
}

// Show first 500 chars of page to check structure
echo "\n[+] Login page preview:\n";
echo substr($page, 0, 500) . "\n";
?>
