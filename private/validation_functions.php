<?php

  // is_blank('abcd')
  function is_blank($value='') {
      if(!isset($value) || trim($value) == ''){
       		return true;
      }
      else{
      		return false;
      }
  }
  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
  		$length = strlen($value);
    	if(isset($options['max']) && ($length > $options['max'])) {
      		return false;
    	 } elseif(isset($options['min']) && ($length < $options['min'])) {
      	    return false;
    	 } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      		return false;
    	 } else {
      		return true;
    	 }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
  		$pattern = "/^[\w\_\.]+@[\w\_]+\.[\w]+$/";
  		return (bool)preg_match($pattern, $value);
  }
  //add function to validate names
  function has_valid_name($value){
  		$pattern = "/^[A-Za-z\s\.\'\-\,]+$/";
  		return (bool) preg_match($pattern, $value);
  }
    //add function to validate username
  function has_valid_username($value){
  		$pattern = "/^[\w\_]+$/";
  		return (bool) preg_match($pattern, $value);
  }

?>
