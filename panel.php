<?php
if(isset($_POST["gonder"])){
    require_once './db.php';
    extract($_POST);
    
    try{
    $sql = "insert into products (image, brand, description, price, title, rating, category) values(?, ?, ?, ?, ?, ?, ?)";
    $state = $db->prepare($sql);
    $result = $state->execute(array($image, $brand, $description, $price, $title, $rating, $category));
    alert("Product info inserted!");
    }
    catch(Exception $ex){
        print "<p>DB ERROR CANNOT INSERT" . $ex->getMessage() . "</p>";
        $error = true;
    }
}

if(isset($_POST["promosyon"])){
    require_once './db.php';
    extract($_POST);
    
    try{
    $sql = "insert into promotions (brand, image) values(?, ?)";
    $state = $db->prepare($sql);
    $result = $state->execute(array($brand, $image));
    alert("Promotion info inserted!");
    }
    catch(Exception $ex){
        print "<p>DB ERROR CANNOT INSERT" . $ex->getMessage() . "</p>";
        $error = true;
    }
}

if(isset($_POST["cikar"])){
    extract($_POST);
    
    try{
        $sql = "delete from products where brand = ?";
        $state = $db->prepare($sql);
        $result = $state->execute([$brand]);
        alert("Product has been removed!");
    }catch(Exception $ex){
        print "<p>DB ERROR CANNOT DELETE" . $ex->getMessage() . "</p>";
        $error = true;
    }
    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <form action="" method="post">
    <table>
        <tr>
            <td>
                Marka
            </td>
            <td>
        <input type="text" name="brand">
            </td>
        </tr>
         <tr>
            <td>
                Başlık
            </td>
            <td>
        <input type="text" name="title">
            </td>
        </tr>
         <tr>
            <td>
                Fiyat
            </td>
            <td>
        <input type="text" name="price">
            </td>
        </tr>
         <tr>
            <td>
                Katagori
            </td>
            <td>
        <input type="text" name="catagory">
            </td>
        </tr>
         <tr>
            <td>
                Resim linki
            </td>
            <td>
        <input type="text" name="image">
            </td>
        </tr>
         <tr>
            <td>
                Puan
            </td>
            <td>
        <input type="text" name="rating">
            </td>
        </tr>
         <tr>
             <td colspan="2">
        <input type="submit" name="gonder" value="Gönder">
            </td>
        </tr>
    </table>
        </form>
    <form action="" method="post">
        <table>
            <tr>
                <td colspan="2">Promosyonlar</td>
            </tr>
            <tr>
                <td>Ürün resmi: </td>
                <td><input type="text" name="image"></td>
            </tr><tr>
                <td>Markası: </td>
                <td><input type="text" name="brand"></td>
            </tr>
             <tr>
                <td>Ürün resmi: </td>
                <td><input type="text" name="image"></td>
            </tr><tr>
                <td>Markası: </td>
                <td><input type="text" name="brand"></td>
            </tr>
             <tr>
                <td>Ürün resmi: </td>
                <td><input type="text" name="image"></td>
            </tr><tr>
                <td>Markası: </td>
                <td><input type="text" name="brand"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="promosyon" value="Gönder"></td>
            </tr>
            
        </table>
    </form>
    <form action="" method="post">
        <table>
            <tr><td colspan="2">Ürün Çıkar</td></tr>
            <tr>
                <td>
                    Markasını giriniz
                </td>
                <td>
            <input type="text" name="brand">
                </td>
            </tr>
            <tr><td colspan="2"><input type="submit" name="cikar" value="Çıkar"></td></tr>

        </table>
    </form>
</body>
</html>
