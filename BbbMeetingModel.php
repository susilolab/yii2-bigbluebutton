<?php
namespace arydeoblo\yii2bigbluebutton;

use yii\db\ActiveRecord;

class BbbMeetingModel extends ActiveRecord{
	public static function tableName()
	{
		return 'bbb_meeting'
	}
} 