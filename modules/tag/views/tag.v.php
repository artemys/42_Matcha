<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   tag.v.php                   		                               :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="" id="Tag">
	<section class="title">Tags</section>
    Choose existing tag
    <div id="searcher" class="searcher">
      <input type="text" id="field" onkeyup="search('field');">
      <div id="res"></div>
    </div>
    <div id="selected"></div>
    Or add a new tag
    <section id="AddNewTag">
      <form method="post" action="index.php?nav=Home">
        <input type="text" id="UserNewTag" name=newtag></br>
        <button id="Tbtn" name="tagbtn">Add new tag</button>
      </form>
    </section>
    Your current tags :
    <?php get_user_tag($db, $_SESSION['user']); ?>
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
var array = new Array();
function search(id)
{
  var str = document.getElementById(id);
  var i = 0;
  var x = event.keyCode;
  
  var data = "str=" + str.value + "&array=" + array;
  $.ajax({
         type: "POST",
         url: "modules/tag/controllers/s.php",
         data: data,
         cache: false,
         dataType : 'html',
         success: function(html)
            {
                $("#res").html(html).show();
              }
     });
           return false;

}
function setId(id) {
    cur_id = id;
}
function send_data()
{
  var tag = document.getElementById(cur_id).value;
  var res = document.getElementById('field');
  var data = "tag=" + tag;
  var request = new XMLHttpRequest();
  request.open('POST', 'index.php?nav=Home', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  request.send(data);
  window.location.reload(true);
}
</script>
