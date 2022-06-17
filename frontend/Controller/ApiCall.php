<?php


class ApiCall
{
  const  COMPANY_BASEURL = "http://127.0.0.1:8000/api/v1/company/";
  const  STATION_BASEURL = "http://127.0.0.1:8000/api/v1/station/";

  // url to be called for
  private $curlURL = "";
  // data to be sent
  private $curlData = "";
  // get or post
  private $curlMethod = "";


  private $curl;

  function __construct($curlURL, $curlMethod, $curlData)
  {
    $this->curlData = $curlData;
    $this->curlMethod = $curlMethod;
    $this->curlURL = $curlURL;
    $this->curl = curl_init();
  }

  /**
   * @return mixed
   */
  public function getCurlURL()
  {
    return $this->curlURL;
  }

  /**
   * @param mixed $curlURL
   */
  public function setCurlURL($curlURL)
  {
    $this->curlURL = $curlURL;
  }

  /**
   * @return mixed
   */
  public function getCurlData()
  {
    return $this->curlData;
  }

  /**
   * @param mixed $curlData
   */
  public function setCurlData($curlData)
  {
    $this->curlData = $curlData;
  }

  /**
   * @return mixed
   */
  public function getCurlMethod()
  {
    return $this->curlMethod;
  }

  /**
   * @param mixed $curlMethod
   */
  public function setCurlMethod($curlMethod)
  {
    $this->curlMethod = $curlMethod;
  }

  public static function baseurl()
  {
    return self::BASEURL;
  }

  public function createCURLRequest()
  {
    $curl = $this->curl;
    $headers = array(
        'Content-Type: application/json',
    );
    curl_setopt($curl, CURLOPT_URL, $this->curlURL);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->curlData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->curlMethod);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);
//    var_dump($this->curlUR, $response);

    return $response == null ? false : $response;
  }

}