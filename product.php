<?php

require_once './db.php';

if(isset($_POST['ara'])){
 
    
    extract($_POST);
    header("Location: product.php?search=$search");
    exit;
    
}

?><html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <style>
            body { font-family: arial;}
            #main { width: 800px; margin:0 auto;}
            #addDiv { text-align: right;}
            .product {  border-collapse: collapse; margin: 10px auto; width: 100%;}
            .product td, th { border: 1px solid black; padding: 5px; text-align: center; }
            
            .price { width: 90px;}
            .stock { width: 90px;}
            .product tr:first-of-type { background: orange;}
            .icon_cell { width: 40px;}
            .product a { color: red; text-decoration: none; }
            .icon { width: 24px; height: 24px; }
            .labels img { width:10px; display: block;}
            .labels { font-weight: bold;  font-size: 1.2em;}
            .leftP { float:left; padding-left: 10px;}
            .rightP { float: right;}
            .paging { text-align: center; margin-top: 30px;}
            .paging a { margin-right: 20px; text-decoration: none; font-size: 16px; color: #999;}
            a.active { color: black; font-weight: bold;}
            img {
                width: 50%;
            }
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
    </head>
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
                echo "<div id='uyeol'><a href='uyeol.php'>Üye Ol</a></div>";
                echo "</td><td>";
                echo "<div id='giris'><a href='giris.php'>Giriş</a></div>";
                                echo "</td></tr></table>";


            }
                ?>
        </div>
                </td>
                <td>
                    <a href="product.php?catagory=giyim" >  Giyim </a>
                </td>
                <td>
                    <a href="product.php?catagory=elektronik">    Elektronik </a>
                </td>
                <td>
                    <a href="product.php?catagory=yiyecek" > Yiyecek </a>
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
        <div id="main">
        <?php
        const PER_PAGE = 5 ;
        require_once 'db.php'; 
        
                 
        
          
      
        
        // PAGING variables.
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
        $currentPage = filter_var($currentPage, \FILTER_VALIDATE_INT) === false ? 1 : $currentPage ;
        if ( $currentPage < 0) $currentPage = 1 ;
        $rs = $db->query("select count(*) as total from products")->fetch() ;
        $maxPage = ceil( $rs["total"] / PER_PAGE) ; 
        if ( $currentPage > $maxPage) $currentPage = $maxPage ;
        $startIndex = ($currentPage - 1) * PER_PAGE ;
        
        // SORTING variables.
$titles = ["image" => "Resim", "brand" => "Marka", "title" => "Başlık", "price" => "Fiyat", "description" => "Açıklama", "rating" => "Puan"] ;
        $orderBy = "title" ;
        if ( isset($_GET["orderBy"])) {
            if ( in_array($_GET["orderBy"], array_keys($titles))) {
                $orderBy = $_GET["orderBy"] ;
            }
        }

        $orderValues = ["asc", "desc"] ;
        $ordering = "asc" ;
        if ( isset($_GET["ordering"])) {
            if ( in_array($_GET["ordering"], $orderValues)) {
                $ordering = $_GET["ordering"] ;
            } 
        }        
        try {
       

          echo '<table class="product">';
          echo "<tr class='labels'>" ;
          foreach( $titles as $key => $title) {
              echo "<td class='$key'><div class='leftP'>$title</div>";
              echo "<div class='rightP'>" ;
              if ( $orderBy == $key ) {
                   if ($ordering == "asc") {
                       echo "<img src='up.png'>" ;
                   } else {
                       echo "<a href='?ordering=asc&orderBy=$key'><img src='up-gray.png'></a>" ;
                   }
               
                   if ($ordering == "desc") {
                       echo "<img src='down.png'>" ;
                    } else {
                       echo "<a href='?ordering=desc&orderBy=$key'><img src='down-gray.png'></a>" ; 
                    }
              } else {
                  echo "<a href='?ordering=asc&orderBy=$key'><img src='up-gray.png'></a>";
                  echo "<a href='?ordering=desc&orderBy=$key'><img src='down-gray.png'></a>" ;
              }
              echo "</div></td>" ;
          }
          
          echo "</tr>" ;
          
             if(isset($_GET['catagory'])){
          $sql = "select * from products where catagory = '".$_GET['catagory']."' order by $orderBy $ordering LIMIT $startIndex," . PER_PAGE ;
          $stmt = $db->query($sql) ;
          }else if(isset($_GET['search'])){
             $sql = "select * from products where lower(title)  like lower('%".$_GET['search']."%') order by $orderBy $ordering LIMIT $startIndex," . PER_PAGE ;
          $stmt = $db->query($sql) ;

          }else {
              
           $sql = "select * from products order by $orderBy $ordering LIMIT $startIndex," . PER_PAGE ;
          $stmt = $db->query($sql) ;
          }
 
          if ( $stmt->rowCount() > 0) {
          foreach ( $stmt as $item) {
             $title = $item['brand'];
             echo '<tr>' ;
             echo "<td><img src='". $item['image'] . "'></td>" ;
             echo '<td>' . $item['brand'] . '</td>' ;
             echo '<td>' . $item['title'] . '</td>' ;
             echo '<td>' . $item['price'] . '</td>' ;
             echo '<td>' . $item['description'] . '</td>' ;
             echo '<td>' . $item['rating'] . '</td>' ;
             echo "<td><a href='sepet.php?title=$title' >Sepete Ekle</a></td>" ;

             echo '</tr>' ;
          } 
          } else {
              echo '<tr><td colspan=5>Ürün Yok.</td></tr>' ;
          }
          echo '</table>' ;
          } catch( Exception $ex) {
              echo '<p>Query error ' . $ex->getMessage() . '</p>' ;
          }
          
          // PAGING HTML Part
          if ( $maxPage > 0 ) {
              echo "<div class='paging'>" ;
              if ( $currentPage > 1) {
                 echo "<a href='?ordering=$ordering&orderBy=$orderBy&page=" . ($currentPage - 1) . "'>Prev</a>" ; 
              }
              for( $i = 1 ; $i <= $maxPage; $i++) {
                 
                  
                  if ( $currentPage == $i) {
                    echo "<a class='active' href='?ordering=$ordering&orderBy=$orderBy&page=$i'>$i</a>" ;  
                  } else {
                    echo "<a href='?ordering=$ordering&orderBy=$orderBy&page=$i'>$i</a>" ;
                  }
              }
              
              if ( $currentPage < $maxPage) {
                 echo "<a href='?ordering=$ordering&orderBy=$orderBy&page=" . ($currentPage + 1) . "'>Next</a>" ; 
              }
              echo "</div>" ;
          }
        ?>
        </div>
    </body>
</html>
