<?php
/**
 * Created by PhpStorm
 * User: anushilnandan
 * Date: 07/07/15
 * Time: 3:52 PM
 */

namespace Cwi\PageBundle\Manager;

use GuzzleHttp\Client;
use Symfony\Component\Security\Acl\Exception\Exception;

class FeedManager extends BaseManager
{

    public function fetchfeed($params)
    {
        $page=$params['page'];
        $limit=10;
        $offset=$page*$limit;
        $client = new Client(array('base_url'=>$this->ConsultUrl));
        $FilterParams=array();
        unset($params['page']);



        /*foreach($params as $FilterKey=>$FilterVal)
        {
            $FilterParams[$FilterKey]=$FilterVal;
        }*/


        try{
            $response = $client->get('questions',array('query' => array('limit' => $limit,'offset'=>$offset, 'state' => 'answered',$params)));
            $Feeds=json_decode($response->getBody());
            $TotalPages=ceil($Feeds->count/$limit) - 1;
            //echo $page.'--->'.$TotalPages;die;
            if($page>=$TotalPages)
            {
                $LastPage=true;
            }else{
                $LastPage=false;
            }
            $Feeds->lastpage=$LastPage;
            return $Feeds;
        }
        catch(Exception $e) {

        }
    }

    public function fetchquestion($params)
    {
        $client = new Client(array('base_url'=>$this->ConsultUrl));
        try{
            $response = $client->get('questions/'.$params['qid']);
            $QuestionDetails=json_decode($response->getBody());
            return $QuestionDetails;
        }
        catch(Exception $e){

        }
    }


}