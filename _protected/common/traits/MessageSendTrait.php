<?php

namespace common\traits;

use Yii;
use yii\base\Model;

trait MessageSendTrait
{

	public function SendMessage($phone,$msg,$job_name){
			$url = 'http://bulkpush.mytoday.com/BulkSms/SingleMsgApi';
			/* $varriable= array();
			$varriable['jobname'] = "php";
			$varriable['phone'] = 7837044046;
			$varriable['message'] = 'Hello Anurag, Will you marry me?....I like You.My name start from R.....'; */
			$data = array (
				'feedid' => 351370,
				'senderid' => 333,
				'username' => 9811893488,
				'password' => 'tjwwt',
				'jobname' => urlencode($job_name),
				'To' => urlencode($phone),
				'Text' => urlencode($msg),
				);
			
				
				$params = '';
			foreach($data as $key=>$value)
						$params .= $key.'='.$value.'&';
				 
			$params = trim($params, '&');
			
			$qs = str_replace(' ', '+', $url."?". $params);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $qs );
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($curl);
			$info = curl_getinfo($curl);

			if ($output === false || $info['http_code'] != 200) {
			  $output = "No cURL data returned for $url [". $info['http_code']. "]";
			  if (curl_error($curl))
				$output .= "\n". curl_error($curl);
				return false;
			  }
			else {
				return true;
			  // 'OK' status; format $output data if necessary here:

			}
			echo $output;
				curl_close($curl);

	}
}
