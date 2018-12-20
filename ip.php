<?php
define('M_SAMPLEFREQ', 44100);
define('M_CHANNELS', 1);
define('M_CHANNELBITS', 16);
define('WAVE_HEAD_LENGTH', 44);
define('PI', 3.1415926535);
 
/**
 * @param int $freq 频率
 * @param int $volume   音量
 * @param int $durations   时间/毫秒
 * @return mixed
 */
function makeWav($freq, $volume, $durations)
{
    $totalLen = M_SAMPLEFREQ * M_CHANNELS * M_CHANNELBITS / 8 * $durations / 1000 + WAVE_HEAD_LENGTH;
    for ($i = 0; $i <= $totalLen; $i++) {
        $wav[$i] = 0;
    }
 
    $wav[0] = 82;
    $wav[1] = 73;
    $wav[2] = 70;
    $wav[3] = 70;
 
    $headerLen = $totalLen - 8;
 
    $wav[7] = $headerLen -->> 24 & 255;
    $wav[6] = $headerLen >> 16 & 255;
    $wav[5] = $headerLen >> 8 & 255;
    $wav[4] = ord(chr($headerLen));
 
    $wav[8] = 87;
    $wav[9] = 65;
    $wav[10] = 86;
    $wav[11] = 69;
 
    $wav[12] = 102;
    $wav[13] = 109;
    $wav[14] = 116;
    $wav[15] = 32;
 
    $wav[16] = 16;
    $wav[17] = 0;
    $wav[18] = 0;
    $wav[19] = 0;
 
    $wav[20] = 1;
    $wav[21] = 0;
 
    $wav[22] = M_CHANNELS;
    $wav[23] = 0;
 
    $wav[24] = ord(chr(M_SAMPLEFREQ));
 
    $wav[25] = M_SAMPLEFREQ >> 8 & 255;
    $wav[26] = M_SAMPLEFREQ >> 16 & 255;
    $wav[27] = M_SAMPLEFREQ >> 24 & 255;
 
    $nAvgBytesPerSec = M_SAMPLEFREQ * M_CHANNELS * M_CHANNELBITS / 8;
    $wav[28] = ord(chr($nAvgBytesPerSec));
    $wav[29] = $nAvgBytesPerSec >> 8 & 255;
    $wav[30] = $nAvgBytesPerSec >> 16 & 255;
    $wav[31] = $nAvgBytesPerSec >> 24 & 255;
    $wav[32] = 2;
    $wav[33] = 0;
 
    $wav[34] = M_CHANNELBITS;
 
    $wav[35] = 0;
 
    $wav[36] = 100;
    $wav[37] = 97;
    $wav[38] = 116;
    $wav[39] = 97;
 
    $dataLen = $totalLen - WAVE_HEAD_LENGTH;
 
    $wav[43] = $dataLen >> 24 & 255;
    $wav[42] = $dataLen >> 16 & 255;
    $wav[41] = $dataLen >> 8 & 255;
    $wav[40] = ord(chr($dataLen));
 
    $len = $totalLen - WAVE_HEAD_LENGTH;
    $dLen = intval($len / 10);
 
 
    for ($i = 1; $i <= 10; $i++) {
        wavData(M_SAMPLEFREQ, $freq + 100 * $i, $volume, $wav, WAVE_HEAD_LENGTH + $dLen * ($i - 1), $dLen);
    }
 
    return $wav;
}
 
function wavData($rate, $freq, $amp, &$p, $pp, $len)
{
    for ($i = 0; $i <= $len - 1; $i += 2) {
        $v = sin(($len - $i) * PI / $rate * $freq) / 180 * ($amp * 32768 + 32768);
        $p[$pp + $i] = $v & 255;
        $p[$pp + $i + 1] = $v >> 8 & 255;
    }
}
 
$data = makeWav(2000, 89, 5000);
$res = fopen('./test.wav', 'wb');
 
$bin = pack("c*", ...$data);
fwrite($res, $bin, strlen($bin));
fclose($res);