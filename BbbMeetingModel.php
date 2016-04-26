<?php
namespace arydeoblo\yii2bigbluebutton;

use yii\db\ActiveRecord;

class BbbMeetingModel extends ActiveRecord{
	public static function tableName()
	{
		return 'bbb_meeting';
	}

	public function rules()
	{
		return [
			[['name','meetingID','attendePW','moderatorPW','recordedMeeting'],'required']
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Meeting Name',
			'meetingID' => 'Meeting Token',
			'attendePW' => 'Attendence Password',
			'moderatorPW' => 'Moderator Password',
			'recordedMeeting' => 'Recorded Meeting',
		];
	}
} 