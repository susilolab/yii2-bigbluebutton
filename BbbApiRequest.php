<?php
namespace arydeoblo\yii2bigbluebutton;

class BbbApiRequest{
	/**
	 * Bbb Resource
	 */
	const create = 'create';
	const getDefaultConfigXML = 'getDefaultConfigXML';
	const setConfigXML = 'setConfigXML';
	const join = 'join';
	const end = 'end';
	/**
	 * Bbb Monitoring
	 */
	const getMeetings = 'getMeetings';
	const isMeetingRunning = 'isMeetingRunning';
	const getMeetingInfo = 'getMeetingInfo';
	/**
	 * Bbb Recording
	 */
	const getRecordings = 'getRecordings';
	const publishRecordings = 'publishRecordings';
	const deleteRecordings = 'deleteRecordings';
}