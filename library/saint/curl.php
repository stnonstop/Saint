<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 11.01.2013
 * Time: 15:26
 * To change this template use File | Settings | File Templates.
 */
namespace saint;
class curl
{
    protected $userAgent        = 'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/533.3 (KHTML, like Gecko) Chrome/5.0.360.0 Safari/533.3';
    protected $referer          = 'http://www.google.com';

    protected $followLocation;
    protected $headerJson = false;
    public $timeOut;
    protected $maxRedirects;
    protected $binaryTransfer;
    protected $includeHeader;
    protected $noBody;
    protected $cookieFileLocation;
    protected $contentType;
    protected $customRequestType;

    protected $post = false;
    protected $postFields;

    protected $webPage;
    protected $status;


    protected $authentication   = false;
    protected $authName         = '';
    protected $authPass         = '';

    public function __construct($timeOut=30, $followLocation=true, $maxRedirects=4, $binaryTransfer=false, $includeHeader = false, $noBody = false) {
        $this->timeOut          = $timeOut;
        $this->followLocation   = $followLocation;
        $this->maxRedirects     = $maxRedirects;
        $this->binaryTransfer   = $binaryTransfer;
        $this->includeHeader    = $includeHeader;
        $this->noBody           = $noBody;
    }

    public function useAuth($auth = false, $authName, $authPass) {
        if($auth) {
            $this->authentication = true;
            $this->authName = $authName;
            $this->authPass = $authPass;
        } else {
            $this->authentication = false;
        }
    }

    public function setPost($post=true, $postFields) {
        if($post) {
            $this->post = true;
            $this->postFields = $postFields;
        } else {
            $this->post = false;
        }
    }

    public function setRefererAndUsetAgent($referer = null, $userAgent = null) {
        if($referer != null) {
            $this->referer = $referer;
        }
        if($userAgent != null){
            $this->userAgent = $userAgent;
        }
    }

    public function setHeaderJson(){
        $this->headerJson = true;
    }

    public function connectToSite($url) {
        $curl = curl_init();

        if($this->headerJson== true){
            $header[] = "Accept: text/plain,text/xml,application/json";
        } else {
            $header[] = "Accept: text/plain,text/xml,application/xml,application/json,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        }

        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";

        if ($this->contentType != ''){
            $header[] = "Content-type: $this->contentType";
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeOut);
        curl_setopt($curl, CURLOPT_MAXREDIRS, $this->maxRedirects);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFileLocation);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFileLocation);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($curl, CURLOPT_REFERER, $this->referer);
        curl_setopt($curl, CURLOPT_ENCODING, '');


        if($this->authentication){
            curl_setopt($curl, CURLOPT_USERPWD, $this->authName.':'.$this->authPass);
        }
        if($this->post) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->postFields);
        }
        if($this->includeHeader) {
            curl_setopt($curl, CURLOPT_HEADER, true);
        }
        if($this->noBody) {
            curl_setopt($curl, CURLOPT_NOBODY, true);
        }

        if ($this->customRequestType != ''){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->customRequestType);
        }

        $result = curl_exec($curl);

        $this->webPage  = $result;
        $this->status   = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        curl_close($curl);

    }

    public function getHttpStatus(){
        return $this->status;
    }

    public function __toString(){
        return $this->webPage;
    }

    public function getResult(){
        return $this->webPage;
    }

    public function setContentType($type){
        $this->contentType = $type;
    }

    public function setCustomRequest($requestType){
        $this->customRequestType = $requestType;
    }

}
