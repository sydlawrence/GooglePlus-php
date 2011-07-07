<?php
/**
 * Copyright (C) 2011  Syd Lawrence (sydlawrence@gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
 * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
 * FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
 * OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
 * COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
 * BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
 * DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://gnu.org/licenses/>.
 */
 
/*
 * USAGE
 * $name = GooglePlus::get_name('101121344751994670210');
 * $url = GooglePlus::get_url('101121344751994670210');
 *
 */
 
class GooglePlus {
  
  /* 
    Using YQL to get data
    select * from html where url="https://profiles.google.com/101121344751994670210" and xpath="//span[@class='fn']"
  */
  public static function retreive_data($id) {
    $url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22https%3A%2F%2Fprofiles.google.com%2F".$id."%22%20and%20xpath%3D%22%2F%2Fspan%5B%40class%3D'fn'%5D%22&format=json&diagnostics=true";
    
    $data = file_get_contents($url);
    
    return json_decode($data);
  }
  
  public static function get_name($id) {
    
    $data = self::retreive_data($id);
    
    if (isset($data->query->results->span->content)) {
      return $data->query->results->span->content;
    } 
    return "";
  }
  
  public static function is_plus($id) {
    $data = self::retreive_data($id);
    
    if (isset($data->query->diagnostics->redirect)) {
      return true;
    }
    return false;
   
  }
  
  public static function get_url($id) {
    if (self::is_plus($id)) {
      return "https://plus.google.com/".$id."/about";
    }
    else {
      return "https://profiles.google.com/".$id."";
    } 
 
  }
  
}


