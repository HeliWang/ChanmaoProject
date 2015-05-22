<?php
include 'Contact.php';

class SiteController extends CController
{
	public function CheckToken($iv_token, $iv_type, $iv_message) 
	//疑问：什么类型的function? public? protected? 
	{
        $tokenResult = User::model->token_verify($iv_token);
		$tokenResult  = 0;
		//疑问: token_verify()的input规则？
		if ($tokenResult!=0) //成功返回0，不成功直接退出
		{
			$ev_result = 1;
			$ev_message = "token不合法";
			//throw new CHttpException(400,'Invalid request.');
			return array('ev_result'=>$ev_result, 'ev_message'=>$ev_message);
        }
		$newContact = new Contact;
		$newContact->type = $iv_type;
		$newContact->message = $iv_message;
		$iv_created = "What is the value of iv_created?";
		// 疑问: iv_created变量在Email中未提及是什么值，这里临时设个value
		$newContact->created = $iv_created;
		$newContact->save(); //疑问: save()成功返回的结果是？
		// if (save失败)，待补充，因为不知save()的返回结果 
		$ev_result = 0;
		$ev_message = "已成功提交，稍后会和您联系";
		return array('ev_result'=>$ev_result, 'ev_message'=>$ev_message);
	}
	
	 /**
	 * Index action 用来测试CheckToken()并返回结果
	 */
	public function actionIndex()
	{
		$Ex1 = self::CheckToken("0e4b294685f817b95cbed85ba5e82b8",1,"I'm hungry");
		$Ex2 = self::CheckToken("0e4b294685f817b95cbed85ba5f82b8",1,"I'm not hungry");
		echo '<html> 测试结果:<br />  Ex1:'.$Ex1['ev_message'].'<br />  Ex2:'.$Ex2['ev_message'] . '</html>';
	}
}
