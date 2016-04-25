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
		if($this->$server == null){
			throw new InvalidConfigException('You mus set server url configuration');
		}
		if($this->$secret == null){
			throw new InvalidConfigException('You mus set server secret configuration');
		}
	}

}