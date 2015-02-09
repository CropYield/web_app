<?php
use Parse\ParseUser;
class HelpController extends BaseController {
	public function helpHome(){
		return View::make('help.home');
	}
}
