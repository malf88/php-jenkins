<?php
namespace src\Model;

use Carbon\Carbon;
class Build
{
    private $jenkins;
    private $id;
    private $result;
    /**
     * @var Carbon
     */
    private $date;
    private $url;
    /**
     * Build constructor.
     * @param $id
     * @param $result
     * @param $date
     * @param $url
     */
    public function __construct($id, $result, $date, $url, $jenkins = null)
    {
        $this->id = $id;
        $this->result = $result;
        $this->date =  Carbon::createFromTimestampMs($date);
        $this->url = $url;
        $this->jenkins = $jenkins;
    }

    public function getURLPromotion(){
        return $this->url . '/promotion/forcePromotion';
    }

    public function promotion($name){
        $response = $this->jenkins->request('GET',$this->getURLPromotion(). '?name='.$name,[]);

        return $this->jenkins->verifyStatus($response);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed|null
     */
    public function getJenkins()
    {
        return $this->jenkins;
    }

    /**
     * @param mixed|null $jenkins
     */
    public function setJenkins($jenkins)
    {
        $this->jenkins = $jenkins;
    }

}