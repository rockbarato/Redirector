<?php

require __DIR__ . '/vendor/autoload.php';


class Redirector {

	/**
	 * Android URL
	 * @var string
	 */
	private $androidURL;

	/**
	 * iOS URL
	 * @var string
	 */
	private $iOSURL;

	/**
	 * Optional URL
	 * @var string
	 */
	private $optionalURL;

	/**
	 * Convenience Constructor
	 * @param string $androidURL  Android URI
	 * @param string $iOSURL      iOS URI
	 * @param string $optionalURL An optional URI
	 */
	public function __construct($androidURL = '', $iOSURL = '', $optionalURL = '') {

		if (strlen($androidURL) == 0 && strlen($iOSURL) == 0 && strlen($optionalURL) == 0) {
			throw new Exception("Debes especificar al menos una URL!");
		}

		if (strlen($androidURL) > 0) {
			$this->androidURL = $androidURL;
		}

		if (strlen($iOSURL) > 0) {
			$this->iOSURL = $iOSURL;
		}

		if (strlen($optionalURL) > 0) {
			$this->optionalURL = $optionalURL;
		}

	}

	/**
	 * Distributor Function
	 */
	public function distribute() {

		$detect = new Mobile_Detect;

		if ( $detect->isiOS() ) {

			$finalURL = strlen($this->iOSURL) > 0 ? $this->iOSURL : (
							strlen($this->optionalURL) > 0 ? $this->optionalURL : (
								$this->androidURL
							)
						);

			$this->redirect($finalURL);

		} else if ( $detect->isAndroidOS() ) {

			$finalURL = '';

			// To open de Market Place for Android devices, we must transform the original URL into a URL Scheme
			if (strlen($this->androidURL) > 0) {

				$urlQuery = parse_url($this->androidURL, PHP_URL_QUERY);
				$finalURL = "market://details?" . $urlQuery;

			} else {

				$finalURL = strlen($this->optionalURL) > 0 ? $this->optionalURL : $this->iOSURL;

			}

			$this->redirect($finalURL);

		} else {

			$finalURL = strlen($this->optionalURL) > 0 ? $this->optionalURL : (
							strlen($this->androidURL) > 0 ? $this->androidURL : (
								$this->iOSURL
							)
						);

			$this->redirect($finalURL);

		}
	}

	/**
	 * Redirector Function
	 * @param  strong $finalURL finalURL
	 */
	public function redirect($finalURL) {

		if ( $this->isValidURL($finalURL) === TRUE ) {
			header('Location: ' . $finalURL);
			exit;
		} else {
			throw new Exception("La URL especificada no es válida: " . $finalURL);
		}
	}

	/**
	 * TODO: Check if URL is valid
	 * @return boolean URL redirect
	 */
	public function isValidURL($URL) {
		return !filter_var($URL, FILTER_VALIDATE_URL) === FALSE;
	}

}