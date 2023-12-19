<?php

const API_BASE_URL = 'https://api-football-v-p.rapidapi.com/';

function encodePath(array $path): array {
    return array_filter($path, function($el) { return trim($el) !== ''; });
}


function generateHash(array $path, array $params = []): string {
    $result = '';
    $path = encodePath($path);

    if (count($path) > 0) {
		$url = implode('/', $path);
		if (count($params) > 0) {
			ksort($params); // Sort by keys
			$url .= '?'.http_build_query($params);
		}
		$result = md5($url);
	}
	return $result;
}

function buildApiUrl(array $path, array $params = []): string {
    $result = '';
	$path = array_map('rawurlencode', encodePath($path));
	if (count($path) > 0) {
		$result = API_BASE_URL.implode('/', $path);
		if (count($params) > 0) {
			$result .= '?'.http_build_query($params, '', null, PHP_QUERY_RFC3986);
		}
	}
	return $result;
}

// Example usage remains the same
$path0 = ['v3', '        ', 'players'];
$params0 = ['id' => 23, 'season' => 2022, 'league' => 12, 'team' => 32];

$path1 = ['v3', '?', 'players      stats']; // Path with spaces
$params1 = ['season' => 2022, 'id' => 23, 'league' => 12, 'team' => 32];

$path2 = ['v3', 'fuck   the      police   ', 'teams']; // Updated path2 for 'teams'
$params2 = ['team' => 32, 'season' => 2022, 'id' => 23, 'league' => 12];

$path3 = ['v3', 'players'];
$params3 = ['season' => 2022, 'id' => 23, 'league' => 12, 'team' => 32];

$path4 = ['v3', 'teams'];
$params4 = ['league' => 12, 'season' => 2022, 'id' => 23, 'team' => 32];

$url0 = buildApiUrl($path0, $params0);
$url1 = buildApiUrl($path1, $params1);
$url2 = buildApiUrl($path2, $params2);
$url3 = buildApiUrl($path3, $params3);
$url4 = buildApiUrl($path4, $params4);


$hash0 = generateHash($path0, $params0);
$hash1 = generateHash($path1, $params1);
$hash2 = generateHash($path2, $params2);
$hash3 = generateHash($path3, $params3);
$hash4 = generateHash($path4, $params4);

echo "URL 0: " . $url0 . "<br>";
echo "MD5 Hash 0: " . $hash0 . "<br>";

echo "URL 1: " . $url1 . "<br>";
echo "MD5 Hash 1: " . $hash1 . "<br>";

echo "URL 2: " . $url2 . "<br>";
echo "MD5 Hash 2: " . $hash2 . "<br>";

echo "URL 3: " . $url3 . "<br>";
echo "MD5 Hash 3: " . $hash3 . "<br>";

echo "URL 4: " . $url4 . "<br>";
echo "MD5 Hash 4: " . $hash4 . "<br>";


