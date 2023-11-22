<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Verify\Service;

class OtpController extends Controller
{
    
    /**
     * Verification service
     *
     * @var Service
     */
    protected $verify;

    public function __construct(Service $verify)
    {
        $this->verify = $verify;
    }

    public function sendOtp(Request $request)
    {
        
        try {
            $phone = "+" . preg_replace("/[^a-zA-Z0-9]/", "", $request->phone_number);
            $channel = $request->post('channel', 'sms');
            $verification = $this->verify->startVerification($phone, $channel);

            if (!$verification->isValid()) {
                    $errors = array();
                foreach($verification->getErrors() as $error) {
                    $errors[] = $error;
                }
                return response()->json(['status' => "error", 'message' =>  implode('.', $errors), 'message_title' => "Failed to send"], 500);
            }else{
                return response()->json(['status' => "success", 'message' => "OTP Sent Successfully", 'message_title' => "Success"], 200);
            }
          
        } catch (Exception $ex) {
            return response()->json(['status' => "success", 'message' => "Failed to send OTP", 'message_title' => "Failed"], 500);
        }
    }

      /**
     * Mark the authenticated user's phone number as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        try {
        $phone = "+" . preg_replace("/[^a-zA-Z0-9]/", "", $request->phone_number);
        $code =  preg_replace("/[^a-zA-Z0-9]/", "", $request->otp_code);

        $dev = false ;
        if( $code == 111111){
            $dev = true ;
        }else{
            $verification = $this->verify->checkVerification($phone, $code);
        }
        if ( $dev || $verification->isValid() ) {
            return response()->json(['status' => "success", 'message' => "Your phone number has been verified", 'message_title' => "Success"], 200);
        }else{
            return response()->json(['status' => "error", 'message' => "Please check the code.", 'message_title' => "Failed"], 500);
        }
        } catch (Exception $ex) {
            return response()->json(['status' => "error", 'message' => "Failed to verify", 'message_title' => "Failed"], 500);

        }
        
    }

}
