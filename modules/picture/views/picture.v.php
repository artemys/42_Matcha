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
		<!-- <a><img id="ShowMore" src="Image/add.png" onmouseover="show_more('DelPicture0');" onmouseout="show_less('DelPicture0')"; ></a> -->
		<!-- <input class="delbtn" id="DelPicture0" type="submit" name="Del" value="0" title="Delete Picture"> -->

		<section class="appercu">
			<a onclick="set_img_src('Min1'); toggle_visibility('PicGallery');  "><img class="miniature" id="Min1" <?php echo get_path_file_by_number($db, $_SESSION['user'], 1); ?>></a>

			<!-- <a><img class="sh" id="ShowMore1" src="Image/add.png" onmouseover="show_more('DelPicture1');" onmouseout="show_less('DelPicture1')"; ></a> -->
			<!-- <input class="delbtn" id="DelPicture1" type="submit" name="Del" value="1" title="Delete Picture"> -->

			<a onclick="set_img_src('Min2'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min2" <?php echo get_path_file_by_number($db, $_SESSION['user'], 2); ?>></a>
			<!-- <a><img class="sh" id="ShowMore2" src="Image/add.png" onmouseover="show_more('DelPicture2');" onmouseout="show_less('DelPicture2')"; ></a> -->
			<!-- <input class="delbtn" id="DelPicture2" type="submit" name="Del" value="2" title="Delete Picture"> -->

			<a onclick="set_img_src('Min3'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min3" <?php echo get_path_file_by_number($db, $_SESSION['user'], 3); ?>></a>
			<!-- <a><img class="sh" id="ShowMore3" src="Image/add.png" onmouseover="show_more('DelPicture3');" onmouseout="show_less('DelPicture3')"; ></a> -->
			<!-- <input class="delbtn" id="DelPicture3" type="submit" name="Del" value="3" title="Delete Picture"> -->

			<a onclick="set_img_src('Min4'); toggle_visibility('PicGallery');  " ><img class="miniature" id="Min4" <?php echo get_path_file_by_number($db, $_SESSION['user'], 4); ?>></a>
			<!-- <a><img class="sh" id="ShowMore4" src="Image/add.png" onmouseover="show_more('DelPicture4');" onmouseout="show_less('DelPicture4s')"; ></a> -->
			<!-- <input class="delbtn" id="DelPicture4" type="submit" name="Del" value="4" title="Delete Picture" > -->
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

<!-- 	<a><img id="ShowMore" src="Image/add.png" onmouseover="show_more('More');"></a>
	<section id='More'>
		<form method="post" action="index.php?nav=Home">
			<input class="delbtn" id="DelPicture" type="submit" name="Del" value="" title="Delete Picture">
			<input id="ChangePicturePriority" type="submit" name="SetAsProfil" value="">
		</form>
	</section> -->
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
	// var newid = document.getElementById(picId).getAttribute('id').charAt(3);
	// var to_set = document.getElementById(.attr('id').replace(/Min/, ''));
	// var newid = chaine.charAt(i)
	// windows.alert(to_set);
	// console.log(newid);
	var PicPopup = document.getElementById('PicPopup');
	PicPopup.setAttribute("src", newsrc);
	// document.getElementById('PicPopup').id = newid;

}

function get_next_img()
{
	var min = document.getElementsByClassName('miniature');
	var popup = document.getElementById('PicGallery');
	var src = document.getElementById('PicPopup').src;
	var delId = document.getElementById('DelPicture1');
	var i = 0;

	for (i = 0; i <= 3; i++)
	{
		if (min[i].src == src && i != 3 && min[i + 1].style.display != 'none')
		{
			var newsrc = min[i + 1].src;
			var id = min[i].id;
			var currentid = i + 2;
			break ;
		}
		else if (src == document.getElementById('ProfilPicture').src)
		{
			var newsrc = document.getElementById('Min1').src;
			var currentid = 1;
			break ;
		}
		if (i == 3 || min[i].style.display == 'none')
		{
			var newsrc = document.getElementById('ProfilPicture').src;
			var currentid = 0;
			break ;
		}
	}
	document.getElementById('PicPopup').src = newsrc;
	delId.setAttribute("value", currentid);
}

// function class_lengh(cl)
// {
// 	var cl = document.getElementsByClassName(cl);
// 	i = 0;
// 	while (cl[i])
// 	{
// 		i++;
// 	}
// }

function get_prev_img()
{
	var min = document.getElementsByClassName('miniature');
	var popup = document.getElementById('PicGallery');
	var src = document.getElementById('PicPopup').src;
	var delId = document.getElementById('DelPicture1');
	var i = 0;
	var l = class_lengh('miniature');
	for (i = 0; i <= 3; i++)
	{
		if (min[i].src == src && i != 0 && min[i - 1].style.display != 'none')
		{
			var newsrc = min[i - 1].src;
			var id = min[i].id;
			var currentid = i - 1;
			break ;
		}
		else if (src == document.getElementById('ProfilPicture').src)
		{
			var newsrc = document.getElementById('Min').src;
			var currentid = 1;
			break ;
		}
		if (i == 1 || min[i].style.display == 'none')
		{
			var newsrc = document.getElementById('ProfilPicture').src;
			var currentid = 0;
			break ;
		}
	}
	document.getElementById('PicPopup').src = newsrc;
	// delId.setAttribute("value", currentid);
}

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