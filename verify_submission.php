<?php
echo "========== VERIFYING FORM SUBMISSION ==========\n";

$cookieJar = 'cookiejar_final.txt';

// Check the berita list page
$beritaListUrl = 'http://localhost:8080/member/berita';
echo "[+] Fetching berita list page: $beritaListUrl\n";

$ch = curl_init($beritaListUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$listResponse = curl_exec($ch);
$listInfo = curl_getinfo($ch);
curl_close($ch);

echo "[+] Response Status: " . $listInfo['http_code'] . "\n";
echo "[+] Response Size: " . strlen($listResponse) . " bytes\n";

// Look for recently submitted berita
echo "\n========== CHECKING FOR SUBMITTED BERITA ==========\n";

// Search for the title in the response
$title = 'Test Berita';
if(stripos($listResponse, $title) !== false) {
  echo "[✓] Found submitted berita with title containing '$title'\n";
  
  // Extract a snippet
  $pos = stripos($listResponse, $title);
  $snippet = substr($listResponse, max(0, $pos - 100), 300);
  echo "\n[+] Context around submission:\n";
  echo "..." . $snippet . "...\n";
} else {
  echo "[-] Submitted berita not immediately visible in list\n";
  echo "[+] This may be normal if items need approval or page refresh\n";
}

// Check for any validation messages
if(stripos($listResponse, 'error') !== false || stripos($listResponse, 'failed') !== false) {
  echo "\n[!] WARNING: Error messages found in page\n";
} else {
  echo "\n[✓] No error messages detected on berita list page\n";
}

// Show page preview
echo "\n========== PAGE CONTENT PREVIEW (first 1500 chars) ==========\n";
echo substr($listResponse, 0, 1500);
echo "\n...\n";
?>
