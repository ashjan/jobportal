<html>
 <head>
  <title>SuperSignature</title>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script language="javascript" type="text/javascript">
        document.oncontextmenu = new Function("return false;");
        if (self == top) 
        { 
	  window.location.href = 'sign.php';
	}
  </script>
  <script type="text/javascript" src="wz_jsgraphics.js"></script> <!-- if you need windows mobile support -->
  <script type="text/javascript" src="ss.js"></script>
      <style>
        .Button
        {
            font-family: Segoe UI,Tahoma;
            font-size: 12px;
            font-weight: bolder;
            color: #000000;
            background-repeat: no-repeat;
            width: 80px;
            height: 20px;
            border: none;
            border: solid 1px #DCDCDC;
            margin: 5px;
        }
        li input
        {
            margin: 5px;
        }
        body
        {
            font-family: Segoe UI,Tahoma;
            font-size: 12px;
        }
    </style>
 </head>
 <body>
  <noscript>
        <meta http-equiv="refresh" content="1; URL='/'" />
  </noscript>
  <form method="post" action="super-signature.php">
    <div id='ctlSignature_Container' style='width:240px;height:200px;'>
    <script language="javascript" type="text/javascript">
            var ieVer = getInternetExplorerVersion();
            if (isIE) {
                if (ieVer >= 9.0)
                    isIE = false;
            }
            if (isIE) 
            {
                document.write("<div ID='ctlSignature' style='width:120px;height:100px;border:Dashed 2px #DDDDDD'></div>");
            }
            else 
            {
                document.write("<canvas ID='ctlSignature' width='120' height='100'></canvas>");
            }
         </script>
    </div>
    <input type="hidden" value="<?php echo uniqid() . '.png' ?>" id="ctlSignature_file" name="ctlSignature_file"/>
    <input type="submit" value="Sign Now!" class="Button"/>
  </form> 
   <script type="text/javascript">
	var signObjects = new Array('ctlSignature');
	var objctlSignature = new SuperSignature({SignObject:"ctlSignature",SignWidth: "120",SignHeight: "100" ,BorderStyle:"Dashed",BorderWidth: "1px",BorderColor: "#DDDDDD",RequiredPoints: "150",ClearImage:"refresh.png", PenCursor:"pencil.cur", Visible: "true"});	
	// Initialize signatures
	$(document).ready(function(){
	  objctlSignature.Init();
	});
   </script>
 </body>
</html>