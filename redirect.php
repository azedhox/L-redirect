<?php

// إعدادات الحساب الأصلي
$baseUrl = "http://live.lynxiptv.xyz";
$username = "334188914694";
$password = "bLe8QR48ko";

// قراءة المتغيرات
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    exit("Missing channel id");
}

// الرابط الأصلي
$originalUrl = "$baseUrl/$username/$password/$id";

// cURL لتتبّع التحويل
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $originalUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_NOBODY => true,
    CURLOPT_TIMEOUT => 15,
]);

curl_exec($ch);

// جلب الرابط النهائي بعد التحويل
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

if (!$finalUrl) {
    http_response_code(502);
    exit("Failed to fetch stream");
}

// إعادة التوجيه للبث الحقيقي
header("Location: $finalUrl", true, 302);
exit;
