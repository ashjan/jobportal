<html>
 <head>
  <title>SuperSignature PHP</title>
  <script language="javascript" type="text/javascript">
        document.oncontextmenu = new Function("return false;");
  </script>
      <style>
        .Button
        {
            font-family: Segoe UI,Tahoma;
            font-size: 10px;
            font-weight: bolder;
            color: #000000;
            background-repeat: no-repeat;
            width: 80px;
            height: 20px;
            border: none;
            border: solid 1px #DCDCDC;
            margin-left: 0px;
            margin-top:-5px;
        }
        li input
        {
            margin: 0px;
        }
        body
        {
            font-family: Segoe UI,Tahoma;
            font-size: 11px;
        }
    </style>
</head>
<body>
  <noscript><meta http-equiv="refresh" content="1; URL='/'" /></noscript>
  <form method="post"  name="frmsignature"  action="super-signature.php">
  <div style="float:left;width:100%;">
   <iframe id="frmSign" name="frmSign" src="control.php" width="240px" height="190px" style="width:240px;height:190px;" scrolling="no" frameborder="1"></iframe>
   <br />
   <input type="button" value="Sign Again!" class="Button" onClick="javascript:document.getElementById('frmSign').src = 'control.php';"/>
   </div>
 
   </form> 
</body>
</html>