<?php

namespace src\Model;

class BuildList
{
    private $builds = [];
    private $jenkins = '';

    /**
     * BuildList constructor.
     * @param string $jenkins
     */
    public function __construct($jenkins)
    {
        $this->jenkins = $jenkins;
    }


    public function addBuild(Build $build){
        $build->setJenkins($this->jenkins);
        $this->builds[] = $build;
    }

    /**
     * @param $idBuild
     * @return Build
     */
    public function find($idBuild){

        foreach($this->builds as $build){
            if($build->getId() == $idBuild){
                return $build;
            }
        }
        throw new \Exception('Build não encontrada.');
    }

    /**
     * @return array
     */
    public function getBuilds()
    {
        return $this->builds;
    }

}