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

if (isset($_GET['id']))
{
	$img_owner = $_GET['id'];
}
else
{
	$img_owner = $_SESSION['user_id'];
}
?>

<section class="module" id="Picture">
	<section id="Userpictures">
			<img class="photo" id="ProfilPicture" <?php echo get_path_file_by_number($db, $img_owner, 0); ?>/>

		<section id="Appercu">
			<a onclick="set_img_src('Min1'); overlay('PicGallery', 'open');" ><img class="miniature" id="Min1" 	<?php echo get_path_file_by_number($db, $img_owner, 1); ?>></a>
			<a onclick="set_img_src('Min2'); overlay('PicGallery', 'open');" ><img class="miniature" id="Min2" 	<?php echo get_path_file_by_number($db, $img_owner, 2); ?>></a>
			<a onclick="set_img_src('Min3'); overlay('PicGallery', 'open');" ><img class="miniature" id="Min3" 	<?php echo get_path_file_by_number($db, $img_owner, 3); ?>></a>
			<a onclick="set_img_src('Min4'); overlay('PicGallery', 'open');" ><img class="miniature" id="Min4" 	<?php echo get_path_file_by_number($db, $img_owner, 4); ?>></a>
		</section>
	</section>
	<?php if (!isset($_GET['id'])) { ?>
		<button id="PicturePopUpBtn" onclick="overlay('Overlay','open');" title="Add picture">Add picture</button>
		<?php } ?>
		<section id="Overlay" class="overlay">

			<a href="javascript:void(0)" class="close" onclick="overlay('Overlay', 'close')">&times;</a>

			<section class="body">

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
						width="450" height="450" />
					</section>

					<section id="ImageUploader">
						<form  method="post"  enctype="multipart/form-data" action="index.php?nav=Home">
			  				Select image to upload:
			  				<input 	id="fileToUpload"       type="file"     name="fileToUpload" >
			  				<input 	id="PictureUploadBtn" 	type="submit"  	name="ValidateUpload" 		value="Upload" title="Upload Picture">
			  				<input 	id="PicCheckBtn" 		type="submit" 	name="PictureValidateBtn" 	value="Valide" title="Select as picture">
						</form>
					</section>

			</section>

		</section>

	<section id="PicGallery" class="overlay">
		<a href="javascript:void(0)" class="close" onclick="overlay('PicGallery', 'close')">&times;</a>
		<section class="body">

			<section id="Picplacecenter">
				<img id="PicPopup" class="galerie" src="" width="650" height="650">
			</section>

			<section id='More'>
				<form method="post" action="index.php?nav=Home">
					<input id="DelPicture" 			  type="submit" name="Del"         value="Delete" 		 title="Delete Picture">
					<input id="ChangePicturePriority" type="submit" name="SetAsProfil" value="Set as profil" title="Set as profil" >
				</form>
			</section>
			
			<button id="PrevButton" onclick="get_prev_img();">Prev</button>
			<button id="NextButton" onclick="get_next_img();">Next</button>
		</section>
	</section>

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

function overlay(id, command)
{
	switch(command)
	{
		case 'open' : document.getElementById(id).style.height = "100%"; break;
		case 'close': document.getElementById(id).style.height = "0%"  ; break;
	}
}


 </script>
<?php
if(isset($_POST['ValidateUpload']))
{
	?>
	<script>
		overlay("Overlay","open");
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