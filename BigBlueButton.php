<?php
namespace arydeoblo\yii2bigbluebutton;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;

Class BigBlueButton extends Object{

	public $server_url;

	public $server_secret;

	public function init()
	{
		if($this->server_url == null){
			throw new InvalidConfigException('You mus set server url configuration');
		}
		if($this->server_secret == null){
			throw new InvalidConfigException('You mus set server secret configuration');
		}
	}

	public function setUrl($request,$params=[])
	{
		$api_request = $request;

		$checksum =  $api_request . http_build_query($params) . $this->server_secret;

		return $this->server_url. '/api/' . $request. '?checksum=' . sha1($checksum);
	}

	public function getResponse($response)
	{
		return file_get_contents($response);
	}

	public function getMeetings()
	{
		$getMeetings = $this->setUrl('getMeetings');

		return $this->getResponse($getMeetings);
	}

}