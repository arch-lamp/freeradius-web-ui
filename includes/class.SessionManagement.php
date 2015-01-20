<?php
if ( preg_match( "/class.SessionManagement.php/", $_SERVER['SCRIPT_NAME'] ) ) {
	header( "Location: ../" );
	exit;
}
/**
 * @package         PHP-Lib
 * @description     Class is used for the Session Management
 * @copyright       Copyright (c) 2013, Peeyush Budhia
 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
 */
class SessionManagement
{

	public $secureWord = 'CRYPT';
	protected $checkBrowser = true;
	protected $checkIP = true;
	protected $checkHost = true;
	protected $regenerateID = true;
	protected $fingerPrint = '';
	protected $portal = '';

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to start the session and regenerate the session id
	 */
	function __construct($portal)
	{
		session_start();
		$this->portal = $portal;
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to set a session variable based on visitor's finger prints.
	 */
	function sessionOpen()
	{
		$_SESSION[$this->portal . 'fingerPrint'] = $this->fingerPrints();
		$this->regenerateID();
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to set the finger prints like browser, ip and predefined secure word
	 * @return string   sha1 fingerprints
	 */
	protected function fingerPrints()
	{
		$this->fingerPrint = $this->secureWord;
		if ($this->checkBrowser) {
			$this->fingerPrint .= $this->checkBrowser();
		}
		if ($this->checkIP) {
			$this->fingerPrint .= $this->checkIP();
		}
		if ($this->checkHost) {
			if (gethostbyaddr($this->checkIP()) == '') {
				$this->fingerPrint .= 'Unknown Host';
			} else {
				$this->fingerPrint .= gethostbyaddr($this->checkIP());
			}
		}

		return sha1($this->fingerPrint);
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to check the visitor's browser
	 * @return string   Visitor's browser
	 */
	protected function checkBrowser()
	{
		static $agent = null;
		if (empty($agent)) {
			$agent = $_SERVER['HTTP_USER_AGENT'];

			if (stripos($agent, 'Firefox') !== false) {
				$agent = 'Firefox';
			} elseif (stripos($agent, 'MSIE') !== false) {
				$agent = 'Internet Explorer';
			} elseif (stripos($agent, 'iPad') !== false) {
				$agent = 'IPAD';
			} elseif (stripos($agent, 'Android') !== false) {
				$agent = 'Android';
			} elseif (stripos($agent, 'Chrome') !== false) {
				$agent = 'Chrome';
			} elseif (stripos($agent, 'Safari') !== false) {
				$agent = 'Safari';
			} elseif (stripos($agent, 'AIR') !== false) {
				$agent = 'AIR';
			} elseif (stripos($agent, 'Fluid') !== false) {
				$agent = 'Fluid';
			} else {
				$agent = $_SERVER['HTTP_USER_AGENT'];
			}
		}

		return $agent;
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to check the visitor's IP
	 * @return mixed    Visitor's IP
	 */
	protected function checkIP()
	{
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$_realIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$_realIP = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				$_realIP = $_SERVER['REMOTE_ADDR'];
			}
		} else {
			if (getenv($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$_realIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} elseif (getenv($_SERVER['HTTP_CLIENT_IP'])) {
				$_realIP = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				$_realIP = $_SERVER['REMOTE_ADDR'];
			}
		}

		return $_realIP;
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to regenerate the session id
	 */
	protected function regenerateID()
	{
		if (version_compare(phpversion(), '5.1.0', '>=')) {
			session_regenerate_id(true);
		} else {
			session_regenerate_id();
		}
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to check the session
	 * @return bool     "true" if current fingerprints matched with session fingerprints
	 *                  "false" if current fingerprints not matched with session fingerprints
	 */
	function checkSession()
	{
		if ($_SESSION[$this->portal . 'fingerPrint'] == $this->fingerPrints()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
	 * @description     The function is used to destroy all the session variables and close the session
	 * @return bool     "true" if session destroyed successfully
	 *                  "false" if session not destroyed successfully
	 */
	function sessionClose()
	{
		if (isset($_SESSION[$this->portal . 'fingerPrint'])) {
			$_SESSION[$this->portal . 'fingerPrint'] = '';
			session_unset();
			session_destroy();

			return true;
		} else {
			return false;
		}
	}
}
