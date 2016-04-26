<?php
namespace arydeoblo\yii2bigbluebutton;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class BbbMeetingModel extends ActiveRecord{
	public static function tableName()
	{
		return 'bbb_meeting';
	}

	public function rules()
	{
		return [
			[['name','meetingID','attendeePW','moderatorPW'],'required'],
			[['meetingID','name'],'unique'],
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Meeting Name',
			'meetingID' => 'Meeting ID',
			'attendeePW' => 'Attendee Password',
			'moderatorPW' => 'Moderator Password',
		];
	}

	public static function findOneMeeting($params)
	{	
		if(($model = self::findOne($params)) == null){
			throw new NotFoundHttpException('Page not found');
		}else{
			return $model;
		}
	}
} 