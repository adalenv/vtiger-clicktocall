{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}

{* To check current user has permission to make outbound call. If so, make all the detail view phone fields as links to call *}
{assign var=MODULE value='PBXManager'}
{assign var=MODULEMODEL value=Vtiger_Module_Model::getInstance($MODULE)}
{assign var=FIELD_VALUE value=$FIELD_MODEL->get('fieldvalue')}
{if $MODULEMODEL and $MODULEMODEL->isActive() and $FIELD_VALUE}
    {assign var=PERMISSION value=PBXManager_Server_Model::checkPermissionForOutgoingCall()}
    {if $PERMISSION}
        {assign var=PHONE_FIELD_VALUE value=$FIELD_VALUE}
        {assign var=PHONE_NUMBER value=$PHONE_FIELD_VALUE|regex_replace:"/[-()\s]/":""}
        
        <!-- <a class="phoneField">{$FIELD_MODEL->get('fieldvalue')}</a>&nbsp;&nbsp;Call:&nbsp;
        <a class="cbtn btn-info" onclick="call('77{$PHONE_NUMBER}')">77</a>&nbsp;&nbsp; -->

        <!-- <a class="phoneField" data-value="{$PHONE_NUMBER}" record="{$RECORD->getId()}" onclick="Vtiger_PBXManager_Js.registerPBXOutboundCall('{$PHONE_NUMBER}',{$RECORD->getId()})">{$FIELD_MODEL->get('fieldvalue')}</a> -->
    {else}
        {assign var=PHONE_FIELD_VALUE value=$FIELD_VALUE}
        {assign var=PHONE_NUMBER value=$PHONE_FIELD_VALUE|regex_replace:"/[-()\s]/":""}
        
        <a class="phoneField">{$FIELD_MODEL->get('fieldvalue')}</a>&nbsp;&nbsp;Zoiper:&nbsp;
        <a class="cbtn btn-warning" title='EN:35724021687' onclick="copyToClipboard('55{$PHONE_NUMBER}','55')">55</a>&nbsp;&nbsp;
        <a class="cbtn btn-info"    title='IT:35724021687' onclick="copyToClipboard('77{$PHONE_NUMBER}','77')">77</a>&nbsp;&nbsp;
        <a class="cbtn btn-info"    title='IT:390694806567' onclick="copyToClipboard('88{$PHONE_NUMBER}','88')">88</a>&nbsp;&nbsp;
        <!-- <a class="cbtn btn-danger"  onclick="hangup()">Hangup</a>&nbsp;&nbsp;     -->
  

        <!-- {$FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue'), $RECORD->getId(), $RECORD)} -->
    {/if}
{else}
    {$FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue'), $RECORD->getId(), $RECORD)}
{/if}


<style>
  .cbtn{
    padding:2px;
    border-radius: 5px;
  }
</style>

<script>

	function copyToClipboard(value1,kot) {
	  var $temp = $("<input>");
	  $("body").append($temp);
	  $temp.val(value1).select();
	  document.execCommand("copy");
	  $temp.remove();
	}

    function call1(exten,prefix){
      $.ajax({
        url: '/realtime/call/vici_call.php?action=call&to='+exten+'&dial_prefix='+prefix+'&mysip={$MYSIP}',
        type: 'GET'
      })
      .done(function(data) {
        console.log(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    }

    function hangup(){
      $.ajax({
        url: '/realtime/call/vici_call.php?action=hangup&mysip={$MYSIP}',
        type: 'GET'
      })
      .done(function(data) {
        console.log(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    }
</script>
