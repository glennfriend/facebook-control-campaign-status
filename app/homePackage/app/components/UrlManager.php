<?php

/**
 *  路徑管理
 *      - Url Generator
 *
 *  @see https://en.wikipedia.org/wiki/Uniform_Resource_Identifier
 */
class UrlManager
{

    /**
     *  儲存基本路徑資訊
     */
    protected $data = [];

    /**
     *
     */
    public function init($option)
    {
        $this->data = [
            'basePath'  => $option['basePath'],
            'baseUrl'   => $option['baseUrl'],
            'host'      => $option['host'],
        ];
    }

    /**
     *
     */
    public function getBaseUrl()
    {
        return $this->data['baseUrl'];
    }

    /**
     *  傳回網站基本目錄 uri
     */
    public function getUrl($path)
    {
        return $this->data['baseUrl'] .'/'. $pathFile;
    }

    /* ================================================================================
        extends
    ================================================================================ */

    /**
     *
     */
    public function createUrl($segment, $args=[])
    {
        $url = $this->data['baseUrl'] . $segment;
        if (!$args) {
            return $url;
        }
        $query = [];
        foreach ($args as $key => $value) {
            $query[] = $key .'='. $value;
        }
        return $url . '?' . join('&', $query);
    }

    /**
     *
     */
    public function createUri($segment, $args=[])
    {
        return 'http://' . $this->data['host'] . $this->createUrl($segment, $args);
    }

    /* ================================================================================
        產生專案以外的網址
    ================================================================================ */

    // public function getxxxxxx()




}
