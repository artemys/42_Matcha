function get_notif()
{
	var id = '<?php echo $user_id; ?>';
	var data = "id=" + id;
	console.log(id);
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			// if (callback)
				// callback(xhr.responseText);
				console.log(JSON.parse(xhr.responseText)[0]);
				$('.test').notif({title:JSON.parse(xhr.responseText)[0], content:JSON.parse(xhr.responseText)[0]});
			// }
	};
  	xhr.open('POST', "core/php/check_notif.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
  	setTimeout('get_notif(notif)', 2000); 
}
