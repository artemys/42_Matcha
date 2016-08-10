<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   picture.v.php                                                     :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="module" id="Picture">
		<img class="photo" id="ProfilPicture"  <?php echo get_path_file_by_number($db, $_SESSION['user'], 0); ?>/>

		<section class="appercu">
			<a onclick="set_img_src('Min1'); toggle_visibility('PicGallery');  "><img class="miniature" id="Min1" <?php echo get_path_file_by_number($db, $_SESSION['user'], 1); ?>></a>
			<a onclick="set_img_src('Min2'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min2" <?php echo get_path_file_by_number($db, $_SESSION['user'], 2); ?>></a>
			<a onclick="set_img_src('Min3'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min3" <?php echo get_path_file_by_number($db, $_SESSION['user'], 3); ?>></a>
			<a onclick="set_img_src('Min4'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min4" <?php echo get_path_file_by_number($db, $_SESSION['user'], 4); ?>></a>
		</section>

		<button id="PicturePopUpBtn" onclick="toggle_visibility('PicturePopUp'); changeImage('image0'); " title="Add picture"><img id="image0" src="Image/add.png"/></button>
</section>
		
<section id="PicturePopUp" class="col-xs-12">
	<section>
		<img id="UploadedFile" 
		<?php
			if (isset($_SESSION['UploadedFile']) && file_exists($_SESSION['UploadedFile'])) 
			{
				echo "src=". $_SESSION['UploadedFile'];
			}
			else
			{
				echo "src=Image/user.png";
			} 
		?> 
		width="650" height="650">
	</section>

	<section id="ImageUploader">
		<form  method="post"  enctype="multipart/form-data" action="index.php?nav=Home">
	  			Select image to upload:
	  			<input 	type="file" name="fileToUpload" id="fileToUpload">
	  			<input 	id="PictureUploadBtn" type="submit" value="" name="ValidateUpload" title="Upload Picture">
	  			<input 	id="PicCheckBtn" type="submit" name="PictureValidateBtn" value="" title="Select as picture">
		</form>
	</section>
</section>

<section id="PicGallery">

	<img id="PicPopup" class="galerie" src="" width="650" height="650">

	<a id="HandelMore"  ><img id="ShowMore" src="Image/add.png" onmouseout="show_less('More');" onmouseover="show_more('More');"></a>
	<section id='More' onmouseout="show_less('More'); " onmouseover="show_more('More');">
		<form method="post" action="index.php?nav=Home">
			<input class="delbtn" id="DelPicture" type="submit" name="Del" value="" title="Delete Picture" >
			<input id="ChangePicturePriority" type="submit" name="SetAsProfil" value="" >
		</form>
	</section>
	<button id="NextButton" onclick="get_next_img();"></button>
	<button id="PrevButton" onclick="get_prev_img();"></button>

</section>

 <script type="text/javascript">

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'block')
       e.style.display = 'none';
    else
       e.style.display = 'block';
    }

function del_image(id)
{
  var x = document.getElementById(id);
  	x.removeAttribute("src");
}

function show_more(id)
{
	var e = document.getElementById(id);
	e.style.display = 'block';
}
function show_less(id)
{
	var e = document.getElementById(id);
	e.style.display = 'none';
}

function changeImage(id)
{
  var x = document.getElementById(id);
  var v = x.getAttribute("src");
  if(v == "Image/minus.png")
    v = "Image/add.png";
  else
    v = "Image/minus.png";
  x.setAttribute("src", v);	
}

// function delbtn(delId, picId)
// {
// 	var e = document.getElementById(picId);
// 	var b = document.getElementById(delId);

// 	var s = e.getAttribute("src");
// 	console.log(s);
// 	if (s != null)
// 		b.setAttribute("style", "display:block")
// }

function set_img_src(picId, popId)
{
	var newsrc = document.getElementById(picId).getAttribute('src');
	var delId  = document.getElementById('DelPicture');
	var setId  = document.getElementById('ChangePicturePriority');


	// var newid = document.getElementById(picId).getAttribute('id').charAt(3);
	// var to_set = document.getElementById(.attr('id').replace(/Min/, ''));
	// var newid = chaine.charAt(i)
	// windows.alert(to_set);
	// console.log(newid);
	var PicPopup = document.getElementById('PicPopup');
	var id       = document.getElementById(picId).getAttribute('id');
	var curid    = id.charAt(3);
	console.log(curid);
	PicPopup.setAttribute("src", newsrc);
	delId.setAttribute("value", curid);
	setId.setAttribute("value", curid);

	// document.getElementById('PicPopup').id = newid;

}

function get_next_img()
{
	var min   = document.getElementsByClassName('miniature');
	var popup = document.getElementById('PicGallery');
	var src   = document.getElementById('PicPopup').src;
	var delId = document.getElementById('DelPicture');
	var setId = document.getElementById('ChangePicturePriority');
	var i     = 0;

	for (i = 0; i <= 3; i++)
	{
		if (min[i].src == src && i != 3 && min[i + 1].style.display != 'none')
		{
			var newsrc = min[i + 1].src;
			var id     = min[i].id;
			var curid  = i + 2;
			break ;
		}
		else if (src == document.getElementById('ProfilPicture').src)
		{
			var newsrc = document.getElementById('Min1').src;
			var curid  = 1;
			break ;
		}
		if (i == 3 || min[i].style.display == 'none')
		{
			var newsrc = document.getElementById('ProfilPicture').src;
			var curid  = 0;
			break ;
		}
	}
	document.getElementById('PicPopup').src = newsrc;
	delId.setAttribute("value", curid);
	setId.setAttribute("value", curid);
}

function class_lengh(cl)
{
	var cl = document.getElementsByClassName(cl);
	i = 0;
	while (cl[i] && cl[i].hasAttribute('src') == true)
	{
		i++;
	}
	return(i);
}

function get_prev_img()
{
	var min   = document.getElementsByClassName('miniature');
	var popup = document.getElementById('PicGallery');
	var src   = document.getElementById('PicPopup').src;
	var delId = document.getElementById('DelPicture');
	var setId = document.getElementById('ChangePicturePriority');
	var i     = 0;
	var l     = class_lengh('miniature');

	for (i = 0; i <= 3; i++)
	{
		if (min[i].src == src && i != 0 && min[i - 1].style.display != 'none')
		{
			var newsrc = min[i - 1].src;
			var id     = min[i].id;
			var nb     = id.charAt(3);
			var curid  = nb - 1;
			break ;
		}
		else if (src == document.getElementById('ProfilPicture').src)
		{
			var newsrc = document.getElementById('Min' + l).src;
			var curid  = l;
			break ;
		}
		if (min[i].style.display == 'none')
		{
			var newsrc = document.getElementById('ProfilPicture').src;
			var curid  = 0;
			break ;
		}
		if (i == 1)
		{
			var newsrc = document.getElementById('ProfilPicture').src;
			var curid  = 0;
			break;
		}
	}
	document.getElementById('PicPopup').src = newsrc;
	delId.setAttribute("value", curid);
	setId.setAttribute("value", curid);

}

// function change_picture_src()
// {
// 	var delId = document.getElementById('DelPicture').getAttribute('value');

// }

 </script>
<?php
if(isset($_POST['ValidateUpload']))
{
	?>
	<script>
		toggle_visibility("PicturePopUp");
	</script>
	<?php
}
// if(isset($_POST['PictureValidateBtn']))
// {
	// delbtn('ShowMore1', 'Min1');
	// delbtn('ShowMore2', 'Min2');
	// delbtn('ShowMore3', 'Min3');
	// delbtn('ShowMore4', 'Min4');

?>