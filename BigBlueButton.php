<?php
namespace arydeoblo\yii2bigbluebutton;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;

use arydeoblo\yii2bigbluebutton\BbbApiRequest;

Class BigBlueButton extends Object{

	private $server_secret;
	private $server_url;

	public $response_type = 'json';

	public function init()
	{
		if(!array_key_exists('bbb_server',Yii::$app->params) && Yii::$app->params['bbb_server'] == null){
			throw new InvalidConfigException('You mus set server url configuration in Yii Params');
		}
		if(!array_key_exists('bbb_secret',Yii::$app->params) && Yii::$app->params['bbb_secret'] == null){
			throw new InvalidConfigException('You mus set server secret configuration in Yii Params');
		}

		$this->server_url = Yii::$app->params['bbb_server'];
		$this->server_secret = Yii::$app->params['bbb_secret'];
	}

	public function setUrl($request,$params=[])
	{
		$api_request = $request;

		$checksum =  $api_request . http_build_query($params) . $this->server_secret;

		return $this->server_url. '/api/' . $request. '?checksum=' . sha1($checksum);
	}

	public function getResponse($response)
	{
		$type = $this->response_type;

		$result = file_get_contents($response);

		$json = json_encode(simplexml_load_string($result));

		switch ($type) {
			case 'xml':
				$result = $result;
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

	/**
	 * Monitoring Resource
	 */

	public function getMeetings()
	{
		$getMeetings = $this->setUrl(BbbApiRequest::getMeetings);

		return $this->getResponse($getMeetings);
	}

	public function isMeetingRunning($meetingID)
	{
		$isMeetingRunning = $this->setUrl(BbbApiRequest::isMeetingRunning,['meetingID' => $meetingID]);

		return $this->getResponse($isMeetingRunning);
	}

	public function getMeetingInfo($meetingID,$moderator_pass)
	{
		$getMeetingInfo = $this->setUrl(BbbApiRequest::getMeetingInfo,['meetingID' => $meetingID, 'password' => $moderator_pass]);

		return $this->getResponse($getMeetingInfo);
	}

}