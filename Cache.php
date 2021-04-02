<?php

class Cache
{    
    /**
     * Cache folder path
     * 
     * @var string
     */
    private $cacheFolder;

    /**
     * Cache filename 
     * 
     * @var string
     */
    private $cacheName;

    /**
     * Cache file extension
     * 
     * @var string
     */
    private $cacheExtension;

    public function __construct($folder='cache/', $name = 'api', $extension = '.cache') {
        $this->cacheFolder      = $folder;
        $this->cacheName        = $name;
        $this->cacheExtension   = $extension; 
    }

    /**
     * Get the cache directory
     * 
     * @return string
     */
    public function getDir() {
        if (!is_dir($this->cacheFolder) and !mkdir($this->cacheFolder, 0775, true))
                throw new Exception("Fail when creating cache directory" . $this->cacheFolder);
        else 
            return $this->cacheFolder . $this->cacheName . $this->cacheExtension;        
    }

    /**
     * Load cache file
     * 
     * @return object or false
     */
    public function loadCacheFile() {
        if (file_exists($this->getDir())) {
            $fileContent = file_get_contents($this->getDir());
            return json_decode($fileContent, true); 
        } else {
            return false;
        }
    }

    /**
     * Put data into cache
     * 
     * @param string $key 
     * @param array $data
     * @param integer $expiration
     * @return object 
     */
    public function put($key, $data, $expiration = 10*60) {
        $timeNow = time();
        $details = array(
            "created" => $timeNow,
            "expiration" => $timeNow + $expiration,
            "data" => $data
        );
        $cache = $this->loadCacheFile();
        if (is_array($cache)) {
            $cache[$key] = $details;
        } else {
            $cache = array($key => $details);
        }
        $cache = json_encode($cache);
        file_put_contents($this->getDir(), $cache);
        return true;
    }

    /**
     * Remove item by its key from cache
     * 
     * @param string $key
     * @return object or false
     */
    public function remove($key) {
        $cache = $this->loadCacheFile();
        if (is_array($cache)) {
            if (isset($cache[$key])) {
                unset($cache[$key]);
                $cache = json_encode($cache);
                file_put_contents($this->getDir(), $cache);
            } else {
                throw new Exception("Fail erasing. Key $key not found.");
            }
        }
        return false;
    }

    /**
     * Remove all expired items from cache
     * @return integer 
     */
    public function removeExpired() {
        $cache = $this->loadCacheFile();
        if (is_array($cache)) {
            $numberExpired = 0;
            foreach ($cache as $key => $value) {
                if (time() > $value['expiration']) {
                    unset($cache[$key]);
                    $numberExpired++;
                }
            }
            if ($numberExpired > 0) {
                $cache = json_encode($cache);
                file_put_contents($this->getDir(), $cache);
            }
            return $numberExpired;
        }
    }

    /**
     * Remove all items from cache
     * 
     * @return true
     */
    public function removeAll() {
        $cacheDirectory = $this->getDir();
        if (file_exists($cacheDirectory)) {
            $file = fopen($cacheDirectory, 'w');
            fclose($file);
        }
        return true;
    }
    
    /**
     * Get item by its key in cache
     * 
     * @param string $key
     * @return object
     */
    public function find($key) {
        $cache = $this->loadCacheFile();
        return $cache[$key];
    }
    
    /**
     * Get all elements from cache
     * 
     * @return object
     */
    public function findAll() {
        return $this->loadCacheFile();
    }

}