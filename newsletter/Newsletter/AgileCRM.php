<?php
namespace ChopChop\PopUpPro\Newsletter;

class AgileCRM extends AbstractAdapter {

  public function signupAjaxResponse( $email, $id ) {

    $contact_json = array(
      "tags"=>array("website subscriber"),
      "properties"=>array(
        array(
          "name" => "email",
          "value" => $email,
          "type" => "SYSTEM"
        )
      )
    );
    if(!empty($_POST['fields'])) {
      foreach($_POST['fields'] as $field) {
        switch($field['fieldName']) {
          case 'chch_main_name':
          $contact_json['properties'][] = array(
            "name" => "first_name",
            "value" => $field['fieldVal'],
            "type" => "SYSTEM"
          );
          break;
        }
      }
    }
    $contact_json = json_encode($contact_json);
    $result = curl_wrap("contacts", $contact_json, "POST", "application/json");

    //echo $result;die();

    // Example of successful output:
    /*
    {"id":5742351410528256,"type":"PERSON","created_time":1460736140,"updated_time":0,"last_contacted":0,"last_emailed":0,"last_campaign_emaild":0,"last_called":0,"viewed_time":0,"viewed":{"viewed_time":0},"star_value":0,"lead_score":0,"tags":["website subscriber"],"tagsWithTime":[{"tag":"website subscriber","createdTime":1460736140370,"availableCount":0,"entity_type":"tag"}],"properties":[{"type":"SYSTEM","name":"email","value":"{email@email.com}"}],"campaignStatus":[],"entity_type":"contact_entity","unsubscribeStatus":[],"emailBounceStatus":[],"formId":0,"owner":{"id":6413738390847488,"domain":"{domain}","email":"{email@email.com}","name":"Martin Petts","pic":"https://d1gwclp1pmzk26.cloudfront.net/img/gravatar/75.png","schedule_id":"Martin_Petts","calendar_url":"{calendar_url}","calendarURL":"{calendar_URL}"}}
    */

    // Example of invalid output:
    /*
    {"errors":[{"error_type":"format_error","field_name":"chch_main_email","error_message":"This value is invalid."}],"status":"fields_error"}
    */

    if($this->isJson($result)) {
      $result = json_decode($result);
      if(!empty($result->id)) {
        return true;
      }
    } else {
      switch($result) {
          case 'Sorry, duplicate contact found with the same email address.':
          return array('code' => 214); // See AbstractAdapter.php line 94
          break;
      }
    }
    return false;
  }

  public function validateNewsletterParams( $param ) {
    $_fIsValid = true;
    return $_fIsValid;
  }

  public function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
  }

}
