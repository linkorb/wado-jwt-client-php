<?php

namespace WadoJwt\Client;

use Firebase\JWT\JWT;

class Client
{
    protected $key;
    protected $url;
    protected $pacs;

    public function __construct($url, $key, $algorithm, $pacs = null)
    {
        $this->url = $url;
        $this->key = $key;
        $this->algorithm = $algorithm;
        $this->pacs = $pacs;
    }

    public function getJwt($studyUid, $seriesUid, $objectUid, $contentType)
    {
        $expire = (60*5); // 5 minutes
        $token = [
            'iat' => time(),
            'exp' => time() + $expire,
            'studyUid' => $studyUid,
            'seriesUid' => $seriesUid,
            'objectUid' => $objectUid,
            'contentType' => $contentType
        ];
        if ($this->pacs) {
            $token['pacs'] = $this->pacs;
        }
        $jwt = JWT::encode($token, $this->key, $this->algorithm);
        return $jwt;
    }

    public function getUrl($studyUid, $seriesUid, $objectUid, $contentType)
    {
        $jwt = $this->getJwt($studyUid, $seriesUid, $objectUid, $contentType);
        $url = $this->url . '?jwt=' . $jwt;
        return $url;

    }
}
