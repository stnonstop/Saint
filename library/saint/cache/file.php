<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 21.12.2012
 * Time: 22:05
 * To change this template use File | Settings | File Templates.
 */
namespace saint\cache;
class file extends cacheAbstract
{

    private $cacheDir = null;

    private $cacheExt = null;

    public function get($key, $expire = 0)
    {
        $cacheFile = $this->getCacheFile($key);

        if(file_exists($cacheFile)){
            if($expire > 0){
                $fmtime =filemtime($cacheFile);
                if($fmtime + $expire < time()){
                    return null;
                }
                $value = file_get_contents($cacheFile);
                if($this->options['serialize'] == true) {
                    $value = unserialize($value);
                }
                return $value;
            }
        }
        return null;
    }

    public function set($key, $value, $expire = 0)
    {
        $cacheFile = $this->getCacheFile($key);

        $fp = null;

        for ($i=0; $i< 3; $i++){
            $tmpFile = tempnam(APPLICATION_PATH . $this->cacheDir, 'cache');
            $fp = fopen($tmpFile, 'wb');
            if($fp) break;
        }

        if(! $fp) return false;

        if($this->options['serialize'] == true) {
            $value = serialize($value);
        }
        fwrite($fp, $value);
        fclose($fp);
        if(rename($tmpFile, $cacheFile)) {
            if(isset($_SERVER['argv'][0])) {
                chown($cacheFile, 'www-data');
            }
            return true;
        }
        return false;
    }

    public function delete($key)
    {
        $cacheFile = $this->getCacheFile($key);
        if(file_exists($cacheFile)){
            unlink($cacheFile);
        }
    }

    private function getCacheFile($key) {

        if($this->cacheDir == null || $this->cacheExt == null) {
            $config = new \saint\config();
            $this->cacheDir = $config->cache['file']['cacheDir'];
            $this->cacheExt = $config->cache['file']['cacheExt'];
        }
        return APPLICATION_PATH . $this->cacheDir . $key . $this->cacheExt;
    }
}
