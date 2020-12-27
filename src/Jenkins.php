<?php

namespace src;

use Carbon\Carbon;
use GuzzleHttp\Client;
use src\Model\Build;
use src\Model\BuildList;

class Jenkins
{
    const ACTION_BUILD = 'build';
    private $username;
    private $usertoken;
    private $url;
    private $client;
    private $version;
    private $jobs = array();
    /**
     * Jenkins constructor.
     * @param $user
     * @param $token
     */
    public function __construct($url,$user, $token)
    {
        $this->url = trim($url, "/");
        $this->username = $user;
        $this->usertoken = $token;
        $this->client = $this->client = new Client();
        $this->init();
    }
    public function init(){

        $response = $this->request('GET',$this->url.'/api/json',[]);
        $this->version = $response->getHeader('X-Jenkins')[0];
        $serverInfo = json_decode($response->getBody()->getContents());
        $this->jobs = $serverInfo->jobs;

    }
    /**
     * @return Build
     * @param string $job
     * @throws \Exception
     */
    public function getLastBuild($job){
        
        $job = $this->findJob($job);

        try{
            $response = $this->request('GET',$job->url.'lastBuild/api/json',[]);
            $responseJson = json_decode($response->getBody()->getContents());
        }catch(\Exception $e){
            throw $e;
        }
        
        return new Build(
                            $responseJson->id,
                            $responseJson->result,
                            $responseJson->timestamp,
                            $responseJson->url,
                            $this
                        );
    }
    /**
     * @param $job
     * @return BuildList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBuildList($job){
        $job = $this->findJob($job);
        $response = $this->request('GET',$job->url.'api/json?tree=builds[*]',[]);

        $responseJson = json_decode($response->getBody()->getContents());

        $builds = new BuildList($this);

        foreach ($responseJson->builds as $build){
            $builds->addBuild(new Build(
                                        $build->id,
                                        $build->result,
                                        $build->timestamp,
                                        $build->url
                            ));
        }

        return $builds;
    }
    public function build($jobName){
        $job = $this->findJob($jobName);
        $response = $this->request('POST',$job->url.self::ACTION_BUILD,[]);
        $this->verifyStatus($response);
    }
    public function verifyStatus($response){
        if($response->getStatusCode() != 200){
            throw new \Exception('Houve um erro ao fazer a requisição');
        }
        return true;
    }
    public function findJob($name){

        foreach($this->jobs as $job){
            if($job->name == $name)
                return $job;
        }
    }

    public function getJobs(){
        return $this->jobs;
    }

    /**
     * @param string $method
     * @param $action
     * @param $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method = 'GET',$action,$params){
        
        $request = $this->client->request($method, $action, array(
            "auth" => [$this->username, $this->usertoken],
            "headers" => [],
            "form_params" => $params
        ));
        //var_dump($request->getStatusCode(),$action);
        return $request;
    }


}