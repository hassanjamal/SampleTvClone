<?php
namespace TvDb\Http;

use TvDb\Exceptions\CurlException;

class CurlClient implements HttpClient
{

    const POST = 'post';
    const GET  = 'get';

    /**
     * [fetch description]
     * @param $url
     * @param  array $params [description]
     * @param string $method
     * @throws CurlException
     * @return string [type]         [description]
     */
    public function fetch($url, array $params = array(), $method = self::GET)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($method == self::POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $data = substr($response, $headerSize);
        curl_close($ch);

        if ($httpCode != 200) {
            throw new CurlException(sprintf('Cannot fetch %s', $url), $httpCode);
        }

        return $data;
    }
}