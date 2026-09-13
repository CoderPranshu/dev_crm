<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    // public function sendOtp(Request $request)
    // {
    //     $request->validate([
    //         'phone' => 'required|digits:10'
    //     ]);

    //     $phone = $request->phone;

    //     // Ensure correct format
    //     if (strlen($phone) == 10) {
    //         $phone = '91' . $phone;
    //     }

    //     $otp = rand(1000, 9999);

    //     // Store OTP
    //     Session::put('otp', $otp);
    //     $phone = $this->formatPhone($request->phone);

    //     Session::put('otp_phone', $phone);

    //     // Encode message properly
    //     $message = urlencode("	Your OTP for warranty number generation is $otp Do not share this OTP with anyone. - BMS ELECTRONICS PVT. LTD.");

    //     // API URL
    //     $url = "http://sms.shribalajimessage.com:8080/vendorsms/pushsms.aspx?user=bms&password=bms123&msisdn=$phone&sid=BMSEPL&msg=$message&fl=0&gwid=2";

    //     // Send SMS
    //     try {
    //         $response = Http::get($url);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'OTP sent successfully via SMS'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to send OTP'
    //         ]);
    //     }
    // }


    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required',
    //         'phone' => 'required'
    //     ]);

    //     $phone = $this->formatPhone($request->phone);

    //     if (
    //         Session::get('otp') == $request->otp &&
    //         Session::get('otp_phone') == $phone
    //     ) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'OTP verified'
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Invalid OTP'
    //     ]);
    // }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10'
        ]);

        $phone = $request->phone;

        if (strlen($phone) == 10) {
            $phone = '91' . $phone;
        }

        $otp = rand(1000, 9999);

        // Store in session
        session([
            'otp' => $otp,
            'otp_phone' => $phone,
            'otp_expiry' => now()->addMinutes(5) // optional expiry
        ]);

        return response()->json([
            'success' => true,
            'otp' => $otp,
            'message' => 'OTP generated successfully'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $sessionOtp = session('otp');
        $sessionPhone = session('otp_phone');
        $expiry = session('otp_expiry');

        $phone = '91' . $request->phone;

        if (!$sessionOtp || !$sessionPhone) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found. Please resend OTP.'
            ]);
        }

        // Check expiry (optional)
        if ($expiry && now()->gt($expiry)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired. Please resend.'
            ]);
        }

        if ($request->otp == $sessionOtp && $phone == $sessionPhone) {
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ]);
    }

    private function formatPhone($phone)
    {
        $phone = preg_replace('/\D/', '', $phone); // remove non-digits

        if (strlen($phone) == 10) {
            return '91' . $phone;
        }

        return $phone;
    }
}
