<?php
/**
 * Created by PhpStorm.
 * User: tinfo
 * Date: 11/29/2018
 * Time: 7:33 PM
 */

namespace BenFryer;


use MirazMac\DeepFry\Fryer;

class BenFryer extends Fryer
{
    /**
     * IP Address + ImageLog File Location
     * @var string
     */
    protected $ipLog = 'ipLog.txt';

    /**
     * Location to store images being fried
     * @var string
     */
    protected $imageDirectory = 'fryer';




    /**
     * Create a new Fryer instance
     *
     * @param string $imagePath Path to the image that'd be fried
     */
    public function __construct()
    {
    }


    public function dropIn($imagePath)
    {
        if (!extension_loaded('gd')) {
            throw new \RuntimeException("Lmao. PHP GD extension is required to run this library 😂😂😂");
        }

        if (!is_file($imagePath)) {
            throw new \LogicException("ni🅱🅱a u mad? no such file found at: {$imagePath}");
        }

        $this->fileName = pathinfo($imagePath, PATHINFO_FILENAME);
        $this->gd       = @imagecreatefromstring(file_get_contents($imagePath));

        if (!$this->gd) {
            throw new \LogicException('Failed to create GD instance, make sure your file is a valid image.');
        }
    }


    public function takeOut( )
    {
        ob_start();
        imagejpeg($this->gd, null, $this->quality);
        $contents = ob_get_contents();
        ob_end_clean();
        $return64 = base64_encode($contents);
        return "data:image/jpeg;base64," . $return64;
    }

    public function acetone ($url)
    {
        unlink($this->imageDirectory . '/' . basename($url));
    }

    public function grabImage($url){
        $curlObject = curl_init ($url);
        curl_setopt($curlObject, CURLOPT_HEADER, 0);
        curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObject, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($curlObject);
        curl_close ($curlObject);
        $saveTo = $this->imageDirectory . '/' . basename($url);
        if(file_exists($saveTo)){
            unlink($saveTo);
        }
        $fp = fopen($saveTo,'x');
        fwrite($fp, $raw);
        fclose($fp);
        return $saveTo;
    }

    public function saveIp ($ip, $imageUrl)
    {
        $logfile = $this->ipLog;
        $now = date("Y-m-d H:i:s");
        $formatted = '[' . $now . '] ';
        $formatted .= $ip . ' - ';
        error_log(json_encode($imageUrl));
        if (is_object($imageUrl)) {
            $imageUrl = json_encode($imageUrl);
        }
        $formatted .= $imageUrl;
        $formatted .= PHP_EOL;
        file_put_contents($logfile, $formatted,FILE_APPEND | LOCK_EX );
    }

    public function misEnPlace ($url)
    {
	    $headers = get_headers($url);
        error_log('=================================================');
        error_log(json_encode($headers));
        error_log('=================================================');

	    if ($headers[0] == 'HTTP/1.1 200 OK' || $headers[0] == 'HTTP/1.0 200 OK'  ) {

	        foreach ($headers as $header) {
	            $parseHeader = explode(' ', $header);

	            if ($parseHeader[0] == 'Content-Length:') {
	                $filesize = $parseHeader[1];
                    error_log($filesize);
                    return $filesize;
                }
            }
        } else {
            return 'Header not 200.\nHeader received:' . $headers[0];
	    }






    }

}
