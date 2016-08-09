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


	<form method="post" action="index.php?nav=Home">
		<img class="photo" id="ProfilPicture"  <?php echo get_path_file_by_number($db, $_SESSION['user'], 0); ?>/>
		<a><img id="ShowMore" src="Image/add.png" onmouseover="show_more('DelPicture0');" onmouseout="show_less('DelPicture0')"; ></a>
		<input class="delbtn" id="DelPicture0" type="submit" name="Del" value="0" title="Delete Picture">

		<section class="appercu">
			<img class="miniature" id="Min1"<?php echo get_path_file_by_number($db, $_SESSION['user'], 1); ?>>
			<a><img class="sh" id="ShowMore1" src="Image/add.png" onmouseover="show_more('DelPicture1');" onmouseout="show_less('DelPicture1')"; ></a>
			<input class="delbtn" id="DelPicture1" type="submit" name="Del" value="1" title="Delete Picture">

			<img class="miniature" id="Min2" <?php echo get_path_file_by_number($db, $_SESSION['user'], 2); ?>>
			<a><img class="sh" id="ShowMore2" src="Image/add.png" onmouseover="show_more('DelPicture2');" onmouseout="show_less('DelPicture2')"; ></a>
			<input class="delbtn" id="DelPicture2" type="submit" name="Del" value="2" title="Delete Picture">

			<img class="miniature" id="Min3" <?php echo get_path_file_by_number($db, $_SESSION['user'], 3); ?>>
			<a><img class="sh" id="ShowMore3" src="Image/add.png" onmouseover="show_more('DelPicture3');" onmouseout="show_less('DelPicture3')"; ></a>
			<input class="delbtn" id="DelPicture3" type="submit" name="Del" value="3" title="Delete Picture">

			<img class="miniature" id="Min4" <?php echo get_path_file_by_number($db, $_SESSION['user'], 4); ?>>
			<a><img class="sh" id="ShowMore4" src="Image/add.png" onmouseover="show_more('DelPicture4');" onmouseout="show_less('DelPicture4s')"; ></a>
			<input class="delbtn" id="DelPicture4" type="submit" name="Del" value="4" title="Delete Picture" >
		</section>

		<!-- <input id="ChangePicturePriority" type="submit" name="SetAsProfil"> -->
	</form>
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

 <script type="text/javascript">
// 
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
  // var v = x.getAttribute("src");
  // if (v != "")
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

function delbtn(delId, picId)
{
	var e = document.getElementById(picId);
	var b = document.getElementById(delId);

	var s = e.getAttribute("src");
	console.log(s);
	if (s != null)
		b.setAttribute("style", "display:block")
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
if(isset($_POST['PictureValidateBtn']))
{
	?>
	<script>
	delbtn('ShowMore1', 'Min1');
	delbtn('ShowMore2', 'Min2');
	delbtn('ShowMore3', 'Min3');
	delbtn('ShowMore4', 'Min4');

	</script>
	<?php
}
?>