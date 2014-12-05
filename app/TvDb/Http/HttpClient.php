<?php
namespace TvDb\Http;
/**
 * 
 */
interface HttpClient
{
    public function fetch($url, array $params = array(), $method = self::GET);
}