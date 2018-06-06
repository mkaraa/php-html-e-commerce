<?php
session_start();

     /*if ( empty($_SESSION["user"])) {
        header("Location: login.php");
        exit ;
  } */

require_once './db.php';

if(isset($_POST['ara'])){
    extract($_POST);
    header("Location: product.php?search=$search");
    exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
</head>
<style>
    td {
        padding-left: 50px;
    }
    header {
        border: 2px solid orange;
        background: white;
    }
    body {
        background: antiquewhite;
    }
</style>

<body>
    <header>
        <table>
            <tr>
                <td>
                  <img id="logo" src="logo.png" alt="" width="50%"/>
                </td>
                <td>
                     <div id="login">
            <?php if(isset($_GET['id'])){
                if($_GET['id'] != 1){
                  echo '<table><tr><td>';
                  echo "<div id='siparisler'><a href='siparisler.php?id=". $_GET['id'] ."' >Siparislerim</a></div>";
                  echo "</td><td>";
                  echo "<div id='sepet'><a href='sepet.php?id=". $_GET['id'] ."' >Sepetim</a></div></td></tr></table>";

                }else {
                  echo "<div id='yonetim'><a href='yonetim.php'>Panel</a></div>";  
                }    
            }
            else {
                echo '<table><tr><td>';
                echo "<div id='uyeol'><a href='signup.php'>Üye Ol</a></div>";//To signup.php
                echo "</td><td>";
                echo "<div id='giris'><a href='login.php'>Giriş</a></div>";//To login.php
                echo "</td></tr></table>";
            }
                ?>
        </div>
                </td>
                <td>
                    <a href="product.php?type='giyim'>" >  Giyim </a>
                </td>
                <td>
                    <a href="product.php?type='elektronik'>" >    Elektronik </a>
                </td>
                <td>
                    <a href="product.php?type='yiyecek'>" > Yiyecek </a>
                </td>
                <td>
                    <form action="" method="post">
                         Arama Butonu:
                <input type="text" name="search"></input>
                <input type="submit" name="ara" value="ara"></input>
                    </form>
                
                </td>
            </tr>
        </table>
    </header>
<div id="promosyon">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<h2 class="w3-center">Promosyonlar</h2>

<div class="w3-content w3-display-container">
  <img class="mySlides" src="pro1.png" style="width:100%">
  <img class="mySlides" src="pro1.png" style="width:100%">
  <img class="mySlides" src="pro1.png" style="width:100%">
  <img class="mySlides" src="pro1.png" style="width:100%">

  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>


</div>
    <?php
    // put your code here
    ?>
</body>
</html>
