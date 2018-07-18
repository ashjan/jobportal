<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
         <script type="text/javascript" src="rating/jquery-1.10.0.min.js"></script>
        <script type="text/javascript" src="rating/jquery.rating.js"></script>
        <link rel="stylesheet" href="rating/rating.css">
    </head>
    <body>
        <div id="rate1"></div>
                <script>
                $('#rate1').rating('www.url.php', {maxvalue:5, increment:.5});
                            </script>
        <?php
        // put your code here
        ?>
    </body>
</html>
