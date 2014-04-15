<?php
	
	/**
	 * Truncate a string to a specific length (30 by default)
	 * @param  string  $string
	 * @param  integer $length Maximum length of the output string
	 * @return string
	 */
	function truncate($string = null, $length = 30){
		if(strlen($string) > $length){
			return substr($string, 0, $length) ."...";

		}

		return $string;
	}

	/**
	 * Just a silly function to show the current branch and commit
	 * @return void
	 */
	function show_git_status(){
		if(IS_DEV){
			$_tmp = array();
			$_tmp["head"] = file('.git/HEAD', FILE_USE_INCLUDE_PATH);
			$_tmp["fetch_head"] = (@file('.git/FETCH_HEAD', FILE_USE_INCLUDE_PATH) ? file('.git/FETCH_HEAD', FILE_USE_INCLUDE_PATH) : array(md5(time())));

			$parts = explode("/", $_tmp["head"][0]);
			
			$git_status = new Generic;
			$git_status->set("branch", $parts[sizeof($parts)-1]);
			$git_status->set("commit", "0000000");
			//sometimes there is no commit to read here..
			if(isset($_tmp["fetch_head"][0])){
				$git_status->set("commit", substr($_tmp["fetch_head"][0], 0, 8));
			}

			echo $git_status->commit ."/". $git_status->branch;
		}
	}

	/**
	 * Corrects a URL that may be missing it's http://
	 * @param  string $url The partial URL which needs prefixing
	 * @return string
	 */
	function make_link($url){
		if(strlen($url) > 0){
			if(strpos($url, "http://") !== false || strpos($url, "https://") !== false){
				return $url;
			}else {
				return "http://". $url;
			}
		}

		return $url;
	}

	/**
	 * Creates valid link HTML that points to an external site
	 * @param  string $url The partial URL
	 * @return string
	 */
	function make_external_link($url){
		return sprintf('<a href="%s" target="_blank" title="Opens in a new tab/window">%s</a>', make_link($url), truncate(make_link($url)));
	}

	/**
	 * Get the referral URL for the current page, or the base URL if it does not
	 * exist
	 * @return string
	 */
	function referer_url(){
		if(isset($_SERVER["HTTP_REFERER"])){
			return $_SERVER["HTTP_REFERER"];
		}

		return base_url();
	}

	/**
	 * Determines if an array has items and if those items have values, false if
	 * both conditions fail
	 * @param  mixed  $arr Accepts any type of input but returns false if not array
	 * @return boolean
	 */
	function array_has_values($arr){
		//it's an array and it has some items
		if(is_array($arr) && sizeof($arr) > 0){
			//not sure if this is numeric or associative so..
			foreach($arr as $item){
				if(is_array($item)){
					return is_array_empty($item);
				}else {
					if(strlen($item) === 0 || is_null($item)){
						return false;
					}else {
						return true;
					}
				}
			}
		}

		return false;
	}
?>