<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function esqueciSenha()
     {
         return view('auth.passwords.email');
     }

     public function esqueciSenhaPost(Request $request)
    {
        $users= \App\User::where('email',$request->email)->get();
        if($users->count()==0){

          if(session()->has('locale')){
            if(session('locale')=='en'){
              return back()->with('erro','The email you have provided is not registered!');
            }
          }

          return back()->with('erro','O email fornecido não está registado!');

        }else{
          //mandar Mail
          //  return dd($users[0]);
          $user=$users[0];
          $user->remember_token = str_random(30);
          $user->save();

          //  return dd($user->name);

          $data = array (
            'name' => $user->name,
            'confirmation_code' => $user->remember_token
            );

            if(session()->has('locale')){
              if(session('locale')=='en'){
                \Mail::send('emails.esqueci_senha_en', $data, function($message) use ($user) {
                   $message->to($user->email)->subject('Reset Password');
                   $message->from('geral@influenzia.pt','Influenzia');
                });
              }else{
                \Mail::send('emails.esqueci_senha', $data, function($message) use ($user) {
                   $message->to($user->email)->subject('Reset Password');
                   $message->from('geral@influenzia.pt','Influenzia');
                });
              }
            }else{
              \Mail::send('emails.esqueci_senha', $data, function($message) use ($user) {
                 $message->to($user->email)->subject('Reset Password');
                 $message->from('geral@influenzia.pt','Influenzia');
              });
            }

          if(session()->has('locale')){
            if(session('locale')=='en'){
                return back()->with('status','A confirmation email has been sent!');
            }
          }

          return back()->with('status','Foi enviado um email de confirmação!');
        }
    }

    public function esqueciSenhaConfirm($remember_token)
   {
    //  return dd($remember_token);
      $users = \App\User::where('remember_token',$remember_token)->get();

      if($users->count()==0){
        return dd('O código não é válido!');
      }else{
        return view('auth.passwords.reset')->with('token',$remember_token);
      }

   }


   public function resetsenha(Request $request)
  {
    // return dd($request->all());

    $this->validate($request, [
        'email' => 'required|email|max:255',
        'password' => 'required|min:6|confirmed',
      ]);


    $users = \App\User::where([['remember_token',$request->token],['email',$request->email]])->get();

    if($users->count()==0){

      if(session()->has('locale')){
        if(session('locale')=='en'){
          return back()->with('erro','The data entered is not valid!');
        }
      }

      return back()->with('erro','Os dados inseridos não são válidos!');
    }else{
      $users[0]->password = bcrypt($request->password);
      $users[0]->save();

      if(session()->has('locale')){
        if(session('locale')=='en'){
          return back()->with('status','The password has been successfully changed!');
        }
      }

      return back()->with('status','A senha foi alterada com sucesso!');
    }

  }



}
