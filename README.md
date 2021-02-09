# vtiger-clicktocall


PhoneDetailView.tpl path:

/var/www/html/vtigercrm/layouts/vlayout/modules/Vtiger/uitypes



Detail.php path:

/var/www/html/vtigercrm/modules/Vtiger/views


to add call button
/var/www/html/vtigercrm/modules\Leads\models\DetailView.php



---------------------------------------------------------------------------


call function placed to PhoneDetailView.tpl 



```
		function call(exten,text){
			$.ajax({
				url: '/realtime/call/monitor.php?to='+exten+'&caller_id='+text+'&mysip=<?php echo $mysip;?>',
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
	</script
```





asterisk manager.conf

```
[test]
secret = 1234
read = system,call,log,verbose,command,agent,user,originate
write = system,call,log,verbose,command,agent,user,originate
permit=192.168.69.200
```




call button

```
///modifikim
			$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Call',
				'linkurl' => 'call();',
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);

```
