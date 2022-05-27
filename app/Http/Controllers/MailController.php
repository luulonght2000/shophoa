<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function forgotPass(Request $request)
    {
        return view('auth.forgot_pass');
    }

    public function recoverPass(Request $request)
    {
        $data = $request->all();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu" . ' ' . $now;
        $customer = User::where('email', '=', $data['email'])->get();
        foreach ($customer as $key => $value) {
            $customer_id = $value->id;
        }

        if ($customer) {
            $count_customer = $customer->count();
            if ($count_customer == 0) {
                return redirect()->back()->with('error', 'Email chưa được đăng ký!');
            } else {
                $token_random = Str::random();
                $customer = User::find($customer_id);
                $customer->customer_token = $token_random;
                $customer->save();
                //send email

                $to_email = $data['email'];
                $link_reset_pass = url('/update-new-pass?email=' . $to_email . '&token=' . $token_random);

                $data = array("name" => $title_mail, "body" => $link_reset_pass, 'email' => $data['email']); //body of mail.blade

                Mail::send('auth.forget_pass_notify', ['data' => $data], function ($message) use ($title_mail, $data) {
                    $message->to($data['email'])->subject($title_mail); //send this mail with subject
                    $message->from("shophoa@gmail.com"); //send from this mail
                    // $message->from($data['email'], $title_mail); //send from this mail
                });
                return redirect()->back()->with('message', 'Gửi email thành công, vui lòng vào email để reset password');
            }
        }
    }

    public function updatePass(Request $request)
    {
        return view('auth.new_pass');
    }

    public function update_new_pass(Request $request)
    {
        $data = $request->all();
        $token_random = Str::random();
        $customer = User::where('email', '=', $data['email'])->where('customer_token', '=', $data['token'])->get();
        $count = $customer->count();
        if ($count > 0) {
            foreach ($customer as $key => $cus) {
                $customer_id = $cus->id;
            }

            $reset = User::find($customer_id);
            $reset->password = Hash::make($data['password']);
            $reset->customer_token = $token_random;
            $reset->save();

            return redirect('login')->with('success', 'Mật khẩu đã cập nhật mới!');
        } else {
            return redirect('quen-mat-khau')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn!');
        }
    }
}
