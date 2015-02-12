<?php
use Parse\ParseUser;
class UserController extends BaseController {

	public function getSignIn(){

		// If the user is already logged in, then there is no need for us to show them the login screen
		if(Auth::check()){

			return Redirect::to('')->with('success', 'You are already logged in!');
		}

		return View::make('users.login');
	}



	public function postSignIn()
    {
        // Get all the inputs
        // id is used for login, username is used for validation to return correct error-strings
       

        $email = Input::get('email');
		$password = Input::get('password');

		$validator = Validator::make(
			array(
				'email' => $email,
				'password' => $password
			), 
			array(
				'email' => 'required|email',
				'password' => 'required|min:8'
			)
		);

		//Validate that the inputs are correct
		if($validator->passes()){

	        // Try to log the user in.
	        if (Auth::attempt(array('email'=> $email, 'password'=> $password)))
	        {
	        	try {
				  	$user = ParseUser::logIn($email, $password);
				  // Do stuff after successful login.
				  	return Redirect::to('')->with('success', 'You have logged in successfully');
				} catch (ParseException $error) {
				  // The login failed. Check error to see why.
		            return Redirect::to('signin')->withErrors(array('password' => 'Login Failed'))->withInput(Input::except('password'));
				}
	            // Redirect to homepage
	            
	        }
	        else
	        {
	            // Redirect to the login page.
	            return Redirect::to('signin')->withErrors(array('password' => 'Password invalid'))->withInput(Input::except('password'));
	        }
	    }
	        

        // Something went wrong.
        return Redirect::to('signin')->withErrors($validator)->withInput(Input::except('password'));
    }

    public function getCreate(){
    	if(Auth::check()){

			return Redirect::to('')->with('success', 'You are already logged in!');
		}

		return View::make('users.create');
    }

    public function postCreate(){
    	$username = Input::get('username');
    	$email = Input::get('email');
		$password = Input::get('password');
		$password_confirm = Input::get('password_confirm');

		$validator = Validator::make(
			array(
				'email' => $email,
				'password' => $password,
				'password_confirm' => $password_confirm
			), 
			array(
				'email' => 'required|email|unique:users',
				'password' => 'required|min:8',
				'password_confirm' => 'required|same:password'
			)
		);

		if($validator->passes()){

			$user = User::create( array(
					'username' => $username,
					'email' 	=> $email,
					'password'	=> Hash::make($password)
				)
			);

			if($user){

		        // Try to log the user in.
		        if (Auth::attempt(array('email'=> $email, 'password'=> $password)))
		        {
		        	$user = new ParseUser();
					$user->set("username", $email);
					$user->set("password", $password);
					$user->set("email", $email);
					
					try {
					  $user->signUp();
					} catch (ParseException $ex) {
						 return Redirect::to('signin')->withErrors($ex->getMessage())->withInput(Input::except('password'));
					  // error in $ex->getMessage();
					}

					// Login
					try {
					  $user = ParseUser::logIn($user, $password);
					} catch(ParseException $ex) {
						return Redirect::to('signin')->withErrors($ex->getMessage())->withInput(Input::except('password'));

					  // error in $ex->getMessage();
					}

					// Current user
					$user = ParseUser::getCurrentUser();
		            // Redirect to homepage
		            return Redirect::to('')->with('success', 'You have created your account successfully');
		        }
		        else
		        {
		            // Redirect to the login page.
		            return Redirect::to('create')->withErrors(array('password' => 'Password invalid'))->withInput(Input::except('password'));
		        }
	    	}
	    }

	    return Redirect::to('create')->withErrors($validator)->withInput(Input::except('password'));

    }

    public function getSignOut(){
    	ParseUser::logOut();
    	Auth::logout();

    	return Redirect::to('')->with('success', 'You are logged out');
    }


}