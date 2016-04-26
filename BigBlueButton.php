<?php
namespace arydeoblo\yii2bigbluebutton;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;

use BbbApiRequest;

Class BigBlueButton extends Object{

	public $response_type = 'json';

	public function init()
	{
		if(!isset(Yii::$app->params['bbb_server']) && Yii::$app->params['bbb_server'] == null){
			throw new InvalidConfigException('You mus set server url configuration in Yii Params');
		}
		if(!isset(Yii::$app->params['bbb_secret']) && Yii::$app->params['bbb_secret'] == null){
			throw new InvalidConfigException('You mus set server secret configuration in Yii Params');
		}
	}

	public function setUrl($request,$params=[])
	{
		$api_request = $request;

		$checksum =  $api_request . http_build_query($params) . $this->server_secret;

		return $this->server_url. '/api/' . $request. '?checksum=' . sha1($checksum);
	}

	public function getResponse($response,$type = $this->response_type)
	{
		$type = $this->response_type;

		$result = file_get_contents($response);

		$json = json_encode(simplexml_load_string($result));

		switch ($type) {
			case 'xml':
				$result = $result
				break;
			case 'array':
				$result = json_decode($json,TRUE);
				break;
			default:
				$result = $json;
				break;
		}

		return result;
	}

	public function getMeetings()
	{
		$getMeetings = $this->setUrl(BbbApiRequest::getMeetings);

		return $this->getResponse($getMeetings);
	}

}