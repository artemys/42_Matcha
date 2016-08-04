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

	<img class="photo" <?php echo get_path_file_by_number($db, $_SESSION['user'], 0); ?>/>

	<section class="appercu">
		<img class="miniature" <?php echo get_path_file_by_number($db, $_SESSION['user'], 1); ?>>
		<img class="miniature" <?php echo get_path_file_by_number($db, $_SESSION['user'], 2); ?>></br>
		<img class="miniature" <?php echo get_path_file_by_number($db, $_SESSION['user'], 3); ?>>
		<img class="miniature" <?php echo get_path_file_by_number($db, $_SESSION['user'], 4); ?>>
	</section>
   	
	<button id="PicturePopUpBtn" onclick="toggle_visibility('PicturePopUp'); changeImage('image0'); "><img id="image0" src="Image/add.png"/></button>

</section>

		
<section id="PicturePopUp" class="col-xs-12">

	<section>
		<img id="UploadedFile" 
		<?php
			if (isset($_SESSION['UploadedFile']) && file_exists($_SESSION['UploadedFile'])) 
			{
			file_put_contents("file.txt", $_SESSION['UploadedFile']);

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
	  			<input 	id="PictureUploadBtn" type="submit" value="" name="ValidateUpload" >
	  			<input 	id="PicCheckBtn" type="submit" name="PictureValidateBtn" value="">
		</form>
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
?>