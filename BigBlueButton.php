<?php
namespace arydeoblo\yii2bigbluebutton;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;
use yii\helpers\Url;

use arydeoblo\yii2bigbluebutton\BbbApiRequest;
use arydeoblo\yii2bigbluebutton\BbbMeetingModel;

Class BigBlueButton extends Object{

	private $server_secret;
	private $server_url;

	public $response_type = 'array';

	public $welcome = '<br>Welcome to <b>%%CONFNAME%%</b>!<br><br><br><br>To join the audio bridge click the headset icon (upper-left hand corner).  Use a headset to avoid causing background noise for others.<br>';

	/**
	 * Init class
	 */
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

	/**
	 * Get all meeting in database table
	 */

	public static function getDataProvider()
	{
		$dataProvider = new \yii\data\ActiveDataProvider(['query' => BbbMeetingModel::find()]);

		return $dataProvider;
	}

	/**
	 * Set URL Request
	 */
	public function setUrl($request,$params=[])
	{
		$api_request = $request;

		$params_url = $params == null ? '' : http_build_query($params) . '&';

		$params_checksum = http_build_query($params);

		$checksum =  $api_request . $params_checksum . $this->server_secret;

		return $this->server_url. '/api/' . $request. '?' . $params_url . 'checksum=' . sha1($checksum);
	}

	/**
	 * Get Response
	 */
	public function getResponse($request)
	{
		$type = $this->response_type;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request)

		$result = curl_exec($ch);

		curl_close($ch);

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

		$return_code = json_decode($json,TRUE)['returncode'];

		if($return_code != 'SUCCESS'){
			throw new ServerErrorHttpException('Error get response from BigBlueButton server, please check your server secret or server url.');
		}

		return $result;
	}

	/**
	 * Monitoring Resource
	 */

	/**
	 * Get all running meetings
	 */
	public function getMeetings()
	{
		$getMeetings = $this->setUrl(BbbApiRequest::getMeetings);

		return $this->getResponse($getMeetings);
	}

	/**
	 * Check meeting is running
	 */
	public function isMeetingRunning($meetingID)
	{
		$isMeetingRunning = $this->setUrl(BbbApiRequest::isMeetingRunning,['meetingID' => $meetingID]);

		return $this->getResponse($isMeetingRunning);
	}

	/**
	 * Get meeting info
	 */
	public function getMeetingInfo($meetingID,$moderatorPW)
	{
		$getMeetingInfo = $this->setUrl(BbbApiRequest::getMeetingInfo,['meetingID' => $meetingID, 'password' => $moderatorPW]);

		return $this->getResponse($getMeetingInfo);
	}

	/**
	 * Administration Resource
	 */

	/**
	 * Create a meeting
	 * @param string $params['name']
	 * @param string $params['meetingID']
	 * @param string $params['attendeePW']
	 * @param string $params['moderatorPW']
	 * @param string $params['welcome']
	 * @param string $params['dialNumber']
	 * @param string $params['voiceBridge']
	 * @param string $params['webVoice']
	 * @param string $params['logoutURL']
	 * @param string $params['record']
	 * @param integer $params['duration']
	 * @param string $params['meta']
	 * @param string $params['moderatorOnlyMessage']
	 * @param boolean $params['autoStartRecording']
	 * @param boolean $params['allowStartStopRecording']
	 * return sting xml,json,or array
	 */
	public function create($params)
	{
		$params = array_merge($params,['logoutURL' => Url::base(true),'welcome' => $this->welcome ]);

		$create = $this->setUrl(BbbApiRequest::create,$params);

		return $this->getResponse($create);
	}

	/**
	 * join a meeting
	 * @param string $params['fullNname']
	 * @param string $params['meetingID']
	 * @param string $params['password']
	 * @param string $params['createTime']
	 * @param string $params['userID']
	 * @param string $params['webVoiceConf']
	 * @param string $params['configToken']
	 * @param string $params['avatarURL']
	 * @param string $params['redirect']
	 * @param string $params['clientURL']
	 * return string Url
	 */
	public function join($params){
		return $this->setUrl(BbbApiRequest::join,$params);
	}

	/**
	 * end a meeting
	 * @param string $params['password']
	 * @param string $params['meetingID']
	 **/
	public function end($params)
	{
	
		$end = $this->setUrl(BbbApiRequest::end,$params);

		return $this->getResponse($end);
	}

}