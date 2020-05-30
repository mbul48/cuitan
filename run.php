<?php
error_reporting(0);
// Memuat Data Yang Dibutuhkan
session_start();
require_once('twitteroauth/twitteroauth.php');

// Konfigurasi
define('CONSUMER_KEY', 'XXXXXX'); #consumer key app twitter
define('CONSUMER_SECRET', 'XXXXXX'); #consumer secret app twitter
define('access_token', 'XXXXXX'); #access token
define('access_token_secret', 'XXXXXX'); #access token secret

function get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");
    return $result = curl_exec($ch);
    curl_close($ch);
}

// random quotes
	$mt_rand = mt_rand(100, 2166);
    $ambil_quotes = get("https://otakotaku.com/quote/view/$mt_rand");
    preg_match_all('~(<i class="fa fa-fw fa-quote-left bquote"></i><p>(.*?)</p>)~', $ambil_quotes, $kata);

// get chara
    preg_match('/<div class="tebal">(.*?)<\/div>/s', $ambil_quotes, $nama);
    foreach ($nama as $data) {
        $pecah = explode(">", $data);
        $chara[] = str_replace('</a', " ", $pecah[2]);
    }
// ngetweet
    $tweet = $kata[2][0] ."\n". implode(" ",$chara);

// Posting Tweet
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, access_token, access_token_secret);
$eksekusi = $connection->post('statuses/update', array('status' => $tweet));
if($eksekusi->errors) {
echo "Tweet Gagal Dikirim\n";
}
else {
echo "Tweet Berhasil Dikirim!\n";
echo $kata[2][0] . "\n" . implode(" ",$chara);
}
?>
