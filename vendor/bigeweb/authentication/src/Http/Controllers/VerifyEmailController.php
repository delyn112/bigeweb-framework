<?php

namespace Bigeweb\Authentication\Http\Controllers;

use Bigeweb\App\Http\Controllers\Controller;
use Bigeweb\Authentication\Events\EmailVerifiedConfirmationEvent;
use Bigeweb\Authentication\Events\VerifyEmailEvent;
use Bigeweb\Authentication\Facades\Auth;
use Bigeweb\Authentication\Repositories\Eloquents\ProfileRepository;
use Carbon\Carbon;
use illuminate\Support\Requests\Request;
use illuminate\Support\Requests\Response;
use illuminate\Support\Session;
use illuminate\Support\Str;

class VerifyEmailController extends Controller
{

    protected ProfileRepository $profileRepository;

    public function __construct()
    {
        parent::__construct();
        $this->profileRepository = new ProfileRepository;
    }

    public function index()
    {
        return view("auth::verification_email");
    }


    public function create()
    {
        $user = Auth::user();
        if($user->email_verified_at !== null)
        {
            Session::flash("success", "Your email has been verified.");
            return Response::redirectBack();
        }
        (new VerifyEmailEvent())->Notification($user, route('confirm-verify-email', [
            "token" => $user->token,
            "id" => $user->id,
            "username" => $user->username,
        ]));

        $this->profileRepository->updateVerifyEmail($user->id, [
            "uuid" => Str::string_generator(55),
            "expiry_date" => Carbon::now()->addMinute(60),
        ]);

        Session::flash("success", "A new verification link has been sent to your email address.");
        return Response::redirectRoute('verify-email');
    }

    public function store(Request $request)
    {
        $user = $this->profileRepository->getUser($request->input("id"), $request->input("token"));
        if (!$user || $user->username != $request->input("username"))
        {
            Session::flash("danger", "Invalid Credential Request!");
            return Response::redirectRoute('verify-email');
        }else if(strtotime(Carbon::now()) > strtotime(Auth::user()->expiry_date))
        {
            Session::flash("danger", "Verification link has expired!");
            return Response::redirectRoute('verify-email');
        }

        $this->profileRepository->updateVerifyEmail(Auth::user()->id, [
            "uuid" => null,
            "expiry_date" => null,
            "email_verified_at" => Carbon::now(),
            "force_email_verify" => null,
        ]);

        (new EmailVerifiedConfirmationEvent())->Notification();
        return Response::redirectRoute('home');
    }
}