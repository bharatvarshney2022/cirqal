<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use DB;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class apiController extends Controller
{
	//START LOGIN
	public function checkDevice($content)
	{
		try 
		{
			$json = $userData = array();
			
			$status_code = '1';
			$message = 'Thanks message';
			$json = array('status_code' => $status_code, 'message' => $message, 'content' => $content);
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();
	
			$json = array('status_code' => $status_code, 'message' => $message, 'content' => $content);
		}
		
		return response()->json($json, 200);
	}
	
	public function userLogin(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $email = $request->mobile;
			
			$device_id = $request->device_id;
			$device_type = $request->device_type;
			$registration_id = $request->registration_id;
			
			$user = DB::table('users')->where('mobile', $email)->first();
	        if($user) 
	        {
				$userDeviceData = DB::table('user_devices')->where(['user_id' => $user->id])->orderBy('id', 'ASC')->first();
				
				$user_device_id = '';
				if($userDeviceData)
				{
					$user_device_id = $userDeviceData->device_id;	
				}
				
				
				if($user_device_id != "" && $user_device_id != $device_id)
				{
					$status_code = '0';
					$message = 'Sorry! User device ID mismatch!';
					
					$json = array('status_code' => $status_code, 'message' => $message);
				}
				else if($user->status == 0) 
				{
					$status_code = '0';
					$message = 'Sorry! User is not verified yet!';
					
					$json = array('status_code' => $status_code, 'message' => $message);
				}
				else
				{
					if (Auth::attempt(array(
						'mobile' => $user->mobile,
						'password' => $request->post('password'),
					))) 
					{
						$userRole = DB::table('model_has_roles')->where('model_id', $user->id)->first();
						
						$role_id = 2;
						if($userRole)
						{
							$role_id = $userRole->role_id;
						}
						
						if($device_id != NULL)
						{
							DB::table('user_devices')->where(['user_id' => $user->id])->delete();
							
							DB::table('user_devices')->insert(['user_id' => $user->id, 'device_id' => $device_id, 'device_type' => $device_type, 'registration_id' => $registration_id, 'created_at' => date('Y-m-d H:i:s')]);
						}
					
						$status_code = '1';
						$message = 'User login sucessfully';
						$userData = ['user_id' => (int)$user->id, 'name' => $user->name, 'user_status' => $user->status, 'role_id' => (int)$role_id, 'device_id' => $device_id];
						$json = array('status_code' => $status_code, 'message' => $message, 'userData' => $userData, 'mobile' => $user->mobile);
					}
					else
					{
						$status_code = '0';
						$message = 'Sorry! Invalid Credentials, Please try again';
						$json = array('status_code' => $status_code, 'message' => $message, 'userData' => array('user_id' => 0, 'name' => '',  'user_status' => 0, 'role_id' => 0, 'device_id' => '', 'mobile' => ''));
					}
                }                
        	} 
        	else 
        	{
	        	$status_code = $success = '0';
				$message = 'Sorry! Mobile not exists!';
	            
	            $json = array('status_code' => $status_code, 'message' => $message);
           }
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message);
		}
		
		return response()->json($json, 200);
	}
	
	//START LOGIN
	public function userRegister(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $email = $request->email;
			$mobile = $request->mobile;
			$name = $request->name;
			$user_password = $request->user_password;
			
			$device_id = $request->device_id;
			$device_type = $request->device_type;
			$registration_id = $request->registration_id;
			
			
			$is_error = 0;
			$user = DB::table('users')->where('email', $email)->first();
	        if($user) 
	        {
				$is_error = 1;
                $status_code = '0';
				$message = 'Sorry! Email already exists.';
				$json = array('status_code' => $status_code, 'message' => $message);
        	} 
			
			$user = DB::table('users')->where('mobile', $mobile)->first();
	        if($user) 
	        {
				$is_error = 1;
                $status_code = '0';
				$message = 'Sorry! Phone Number already exists.';
				$json = array('status_code' => $status_code, 'message' => $message);
        	}
			
			if($is_error == 0)
			{
				$user_otp = rand(111111, 999999);
				$password = Hash::make($user_password);
				
				$user_id = DB::table('users')->insertGetId(['email' => $email, 'mobile' => $mobile, 'password' => $password, 'name' => $name, 'user_otp' => $user_otp, 'created_at' => date('Y-m-d H:i:s')]);
				
				DB::table('model_has_roles')->insert(['model_id' => $user_id, 'role_id' => '2', 'model_type' => 'App\Models\BackpackUser']);
				
				DB::table('user_devices')->insert(['user_id' => $user_id, 'device_id' => $device_id, 'device_type' => $device_type, 'registration_id' => $registration_id, 'created_at' => date('Y-m-d H:i:s')]);
				
				$message = str_replace(" ", "%20", "Your OTP is ".$user_otp);
				$this->httpGet("http://54.36.26.171/rest/services/sendSMS/sendGroupSms?AUTH_KEY=fa4c8291909ebf28ecab817b387d5078&message=".$message."&senderId=RELABL&routeId=1&mobileNos=".$mobile."&smsContentType=english");
				
				$status_code = $success = '1';
				$message = 'Your Account has been created successfully';
	            $json = array('status_code' => $status_code, 'message' => $message, 'user_id' => $user_id, 'user_otp' => $user_otp, 'device_id' => $device_id);
           }
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message);
		}
		
		return response()->json($json, 200);
	}
	
	public function httpGet($url)
	{
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$head = curl_exec($ch); 
		curl_close($ch);
		return $head;
	}
	
	public function sendSMS()
	{
		$message = str_replace(" ", "%20", "Your OTP is 489871");
		$mobile = "9462045321";
		$result = $this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=RSSVEHICAL&password=RSSVEHICAL&senderid=RELABL&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$message."&route=15");
		echo $result;
	}
	
	//START VERIFY
	public function userVerify(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $user_id = $request->user_id;
			$user_otp = $request->user_otp;
			$user = DB::table('users')->where('id', $user_id)->where('user_otp', $user_otp)->first();
	        if($user) 
	        {
				DB::table('users')->where(['id' => $user->id])->update(['status' => '1']);
					
				$status_code = '1';
				$message = 'User activated sucessfully';
				$json = array('status_code' => $status_code,  'message' => $message);
        	} 
        	else 
        	{
	        	$status_code = $success = '0';
				$message = 'Sorry! User does not exists or Incorrect OTP!';
	            
	            $json = array('status_code' => $status_code, 'message' => $message);
           }
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message);
		}
		
		return response()->json($json, 200);
	}
	
	//START FORGOT PASSWORD
	public function userForgotPassword(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $email = $request->email;
			$user = DB::table('users')->where('email', $email)->orWhere('mobile', $email)->first();
	        if($user) 
	        {
				$status_code = '1';
				$message1 = 'User OTP has been sent successfully';
				
				$message = str_replace(" ", "%20", "Your OTP is ".$user->user_otp);
				$this->httpGet("http://54.36.26.171/rest/services/sendSMS/sendGroupSms?AUTH_KEY=fa4c8291909ebf28ecab817b387d5078&message=".$message."&senderId=RELABL&routeId=1&mobileNos=".$user->mobile."&smsContentType=english");
				$json = array('status_code' => $status_code,  'message' => $message1, 'user_id' => $user->id, 'userOTP' => $user->user_otp);
        	} 
        	else 
        	{
	        	$status_code = $success = '0';
				$message = 'Sorry! This Email / Mobile not exists!';
	            
	            $json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'userOTP' => '');
           }
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message, 'user_id' => 0, 'userOTP' => '');
		}
		
		return response()->json($json, 200);
	}
	
	//START CHANGE PASSWORD
	public function userChangePassword(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $email = $request->email;
			$user_password = $request->user_password;
			
			$user = DB::table('users')->where('email', $email)->orWhere('mobile', $email)->first();
	        if($user) 
	        {
				$user_id = $user->id;
				
				$password = Hash::make($user_password);
				DB::table('users')->where(['id' => $user_id])->update(['password' => $password]);
				
				$status_code = '1';
				$message = 'User password has changed successfully';
				$json = array('status_code' => $status_code, 'message' => $message);
        	} 
        	else 
        	{
	        	$status_code = $success = '0';
				$message = 'Sorry! This Email / Mobile not exists!';
	            
	            $json = array('status_code' => $status_code, 'message' => $message);
           }
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message);
		}
		
		return response()->json($json, 200);
	}
	
	//START CATEGORY LIST
	public function getCategory(Request $request)
	{
		try 
		{
			$json = $categoryData = array();
            $lang = $request->lang;

			
			$categories = DB::table('categories')->get();
	        if($categories) 
	        {
				foreach($categories as $category)
				{
					$categoryName = json_decode($category->name);
					$categoryImage = URL('/').'/'.$category->image;
					$categoryData[] = array('id' => $category->id, 'category_name' => $categoryName->$lang, 'image' => $categoryImage);
				}
				
				$status_code = '1';
				$message = 'Category list';
				$json = array('status_code' => $status_code, 'message' => $message, 'categoryList' => $categoryData);
			}
			else
			{
				$status_code = '0';
				$message = 'Category list not exists.';
				$json = array('status_code' => $status_code, 'message' => $message, 'categoryList' => $categoryData);
			}
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message, 'user_status' => 0);
		}
		
		return response()->json($json, 200);
	}
	
	public function getPost(Request $request)
	{
		try 
		{
			$json = $articleData = array();
            $lang = $request->lang;
            $category_id = 0;
            if(isset($request->category))
            {
                $category_id = $request->category;
            }
            $topic = '';
            if(isset($request->topic))
            {
                $topic = $request->topic;
            }
            
            $api_key = $request->api_key;

            if($category_id > 0)
            {
                if($topic != "")
                {
    				$articlesExists = DB::table('articles')->where('category_id', '=', $category_id)->where('status', '=', 'PUBLISHED')->where(function ($query) use ($topic) {
                            $query->orWhere('content', 'like', '%'.$topic.'%')->orWhere('title', 'like', '%'.$topic.'%');
                        })->count();
                }
                else
                {
                    $articlesExists = DB::table('articles')->where(['category_id' => $category_id, 'status' => 'PUBLISHED'])->count();
                }
			}
			else
			{
			    if($topic != "")
                {
                    $articlesExists = DB::table('articles')->where('status', '=', 'PUBLISHED')->where(function ($query) use ($topic) {
                            $query->orWhere('content', 'like', '%'.$topic.'%')->orWhere('title', 'like', '%'.$topic.'%');
                        })->count();
                }
                else
                {
    				$articlesExists = DB::table('articles')->where(['status' => 'PUBLISHED'])->count();
                }
			}

	        if($articlesExists > 0) 
	        {
	        	if($category_id > 0)
            	{
            	    if($topic != "")
                    {
                        $articles = DB::table('articles')->where('category_id', '=', $category_id)->where('status', '=', 'PUBLISHED')->where(function ($query) use ($topic) {
                            $query->orWhere('content', 'like', '%'.$topic.'%')->orWhere('title', 'like', '%'.$topic.'%');
                        })->get();
                    }
                    else
                    {
                        $articles = DB::table('articles')->where(['category_id' => $category_id, 'status' => 'PUBLISHED'])->get();
                    }
				}
				else
				{
				    if($topic != "")
                    {
                        $articles = DB::table('articles')->where('status', '=', 'PUBLISHED')->where(function ($query) use ($topic) {
                            $query->orWhere('content', 'like', '%'.$topic.'%')->orWhere('title', 'like', '%'.$topic.'%');
                        })->get();
                    }
                    else
                    {
        				$articles = DB::table('articles')->where(['status' => 'PUBLISHED'])->get();
                    }
                    
					//$articles = DB::table('articles')->where(['status' => 'PUBLISHED'])->();
				}

				foreach($articles as $article)
				{
					$articleName = json_decode($article->title);
					$articleContent = json_decode($article->content);
					$articleImage = URL('/').'/'.$article->image;
					$articleArticleSource = $article->article_source;
					$articleSourceURL = $article->source_url;
					$articleDate = $article->date;//\Carbon\Carbon::createFromTimeStamp(strtotime())->diffForHumans(null, true).' ago';
					$articleData[] = array('source' => array('id' => '', 'name' => $articleArticleSource), 'author' => '', 'title' => $articleName->$lang, 'description' => strip_tags($articleContent->$lang), 'url' => $articleSourceURL, 'urlToImage' => $articleImage, 'publishedAt' => $articleDate);
				}
				
				$status_code = 'ok';
				$message = 'Post list';
				$json = array('status' => $status_code, 'totalResults' => count($articleData), 'articles' => $articleData);
			}
			else
			{
				$status_code = '0';
				$message = 'Post list not exists.';
				$json = array('status' => $status_code, 'totalResults' => 0, 'message' => $message, 'articles' => $articleData);
			}
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message, 'user_status' => 0);
		}
		
		return response()->json($json, 200);
	}
	
	
	public function checkDate(Request $request)
	{
		$manufacturing_year = $request->manufacturing_year;
		$manufacturingData = explode("-", $manufacturing_year);
		
		if($manufacturingData[1] <= 9)
		{
			$manufacturingData[1] = '0'.$manufacturingData[1];	
		}
		$manufacturing_year1 = $manufacturingData[1].'/'.$manufacturingData[0];
		echo $manufacturing_year1;
	}
	
	public function listNotification(Request $request)
	{
		try 
		{
			$json = $userData = array();
            $user_id = $request->user_id;
			
			$page_start = $request->page_start;
			$page_limit = $request->page_limit;
			
			$userRow = DB::table('users')->find($user_id);
			
			if($userRow)
			{
				$pageStart = ($page_start) * $page_limit;
				
				$notifications = DB::table('user_notifications')->where('user_id', $user_id)->skip($pageStart)->take($page_limit)->orderBy('id', 'DESC')->get();
				
				$notificationData = array();
				
				if($notifications)
				{
					foreach($notifications as $notification)
					{
						$notificationData[] = array('title' => $notification->title, 'content' => $notification->content, 'notification_date' => date('Y-m-d h:i A', strtotime($notification->created_at)), 'type' => $notification->type);
						
						DB::table('user_notifications')->where(['id' => $notification->id])->update(['is_read' => '1']);
					}
					
					$status_code = '1';
					$message = 'User notification list';
					$json = array('status_code' => $status_code,  'message' => $message, 'user_status' => $userRow->status, 'notifications' => $notificationData);
				}
				else
				{
					$status_code = '0';
					$message = 'User notification not exists.';
					$json = array('status_code' => $status_code,  'message' => $message, 'user_status' => $user->status);
				}
				
			}
			else
			{
				$status_code = '0';
				$message = 'User not exists.';
				$json = array('status_code' => $status_code,  'message' => $message, 'user_status' => '0');
			}
		}
		catch(\Exception $e) {
			$status_code = '0';
			$message = $e->getMessage();//$e->getTraceAsString(); getMessage //
	
			$json = array('status_code' => $status_code, 'message' => $message, 'user_status' => 0);
		}
		
		return response()->json($json, 200);
	}
	
	public function sendNotificationGroup(Request $request)
	{
		$title = "Hey";
		$message = "How are you today?";
		
		$notificationKey = ['fI3d0B6bfUg:APA91bG6dh2yeVVAuH_n7o0Fhu72tJmhWkOOBAsBh-B589aZ-diWYUqNNjTPv3STUXpyURG1KIGqZgyE-7ZJQfgm9Be-BDX9TEowA8kxEa9ft9wBFiHFTOPN0rpfOBI-eUc0iTBNifH4'];


		$notificationBuilder = new PayloadNotificationBuilder($title);
		$notificationBuilder->setBody($message)->setSound('default');
		
		$notification = $notificationBuilder->build();
		
		
		$groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
		
		echo $groupResponse->numberSuccess();
		$groupResponse->numberFailure();
		$groupResponse->tokensFailed();
	}
	
	public function sendNotification(Request $request)
	{
		$optionBuilder = new OptionsBuilder();
		$optionBuilder->setTimeToLive(60*20);
		
		$title = "Hey";
		$message = "How are you today?";
		
		$notificationBuilder = new PayloadNotificationBuilder($title);
		$notificationBuilder->setBody($message)->setSound('default');
		
		$dataBuilder = new PayloadDataBuilder();
		$dataBuilder->addData(['title' => $title, 'content' => $message]);
		
		$option = $optionBuilder->build();
		$notification = $notificationBuilder->build();
		$data = $dataBuilder->build();
		
		$tokens = array("fI3d0B6bfUg:APA91bG6dh2yeVVAuH_n7o0Fhu72tJmhWkOOBAsBh-B589aZ-diWYUqNNjTPv3STUXpyURG1KIGqZgyE-7ZJQfgm9Be-BDX9TEowA8kxEa9ft9wBFiHFTOPN0rpfOBI-eUc0iTBNifH4", "cCN29O0KH6g:APA91bGx1yAYvzB6OZ-QCJ2J4iZDZKCgBAnyU3kliK79CuQfAurlDULV9LikkzM0aj4_f2BaUOjVh1OK96CCYqOnrAsY2cuLopr0x2ul2hsMH5nAeyBe-STMtTW0URmQ9962q-T8uQ-s");
		
		$downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
		
		$success = $downstreamResponse->numberSuccess();
		$downstreamResponse->numberFailure();
		$downstreamResponse->numberModification();
		
		if($tokens)
		{
			foreach($tokens as $token)
			{
				$userRow = DB::table('user_devices')->where(['registration_id' => $token])->first();;
				DB::table('user_notifications')->insert(['user_id' => $userRow->user_id, 'title' => $title, 'content' => $message, 'type' => '10', 'created_at' => date('Y-m-d H:i:s')]);
			}
		}
			
		
		//echo $success; exit;
		
		// return Array - you must remove all this tokens in your database
		$downstreamResponse->tokensToDelete();
		
		// return Array (key : oldToken, value : new token - you must change the token in your database)
		$downstreamResponse->tokensToModify();
		
		// return Array - you should try to resend the message to the tokens in the array
		$downstreamResponse->tokensToRetry();
		
		// return Array (key:token, value:error) - in production you should remove from your database the tokens
		$downstreamResponse->tokensWithError();

		//$result = $this->notification('', $title, 'Check out the awesome game!');
		//echo $result;
	}
	
	public function notification($token, $title, $content)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;

        $notification = [
            'title' => $title,
            'body' => $content,
            'sound' => true,
        ];
        
        $extraNotificationData = ["message" => $notification, "title" => $title, "content" => $content];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AIzaSyAV-38ubZAuyVOUGXVmyM0V08uBdA_C0XY',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
		
		DB::table('user_notifications')->insert(['user_id' => 15, 'title' => $title, 'content' => $content, 'type' => '10', 'created_at' => date('Y-m-d H:i:s')]);

        return $result;
    }
}
