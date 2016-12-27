<?php

    session_start();
    if(isset($_SESSION['username'])) {
      
		$username = $_SESSION['username'];
    }
    else {
      
        session_unset();
        session_destroy();
    }

    if(isset($_REQUEST['submitadminbtn'])) {
		if(isset($_REQUEST['password'])) {
            
			if($_REQUEST['username'] === "admin" && $_REQUEST['password'] === "adminpass") {
                
                session_start();
				$username = $_REQUEST['username'];
				$_SESSION['username']= $username;
                $_SESSION['state'] = "adminmode";
			}
			else {
                
				session_unset();
                session_destroy();
				$username = "";
			}
		}
    }

    $adminXML = "admin.xml";
    $exists = file_exists($adminXML);
    if($exists == FALSE) {
        
        $adminData = new SimpleXMLElement("<admin></admin>");
        $adminData->addChild('username', "admin");
        $adminData->addChild('password', "adminpass");
        $adminData->asXML($adminXML);
    }
    else {
       
        $adminData = simplexml_load_file($adminXML);
    }

    // XML for the posts
    $postsXML = "posts.xml";
    $exists = file_exists($postsXML);
    if($exists == FALSE) {
        
        $postData = new SimpleXMLElement("
        <posts>
            <post>
                <title>
                    First meme
                </title>
                <desc>
                    This is the first meme
                </desc>
            </post>
            <post>
                <title>
                    Second meme
                </title>
                <desc>
                    This is the second meme
                </desc>
            </post>
            <post>
                <title>
                    Third meme
                </title>
                <desc>
                    This is the third meme
                </desc>
            </post>
        </posts>");
        $postData->asXML($postsXML);
    }

    else {
        
      $postData = simplexml_load_file($postsXML);
    }

    if (isset($_POST['save_title'])) {
      
      $postData->title = $_POST['input_title'];
      $postData->asXML($postsXML);
    }

    if (isset($_POST['save_desc'])) {
        
      $postData->desc = $_POST['input_desc'];
      $postData->asXML($postsXML);
    }

    if (isset($_POST['delete_title'])) {
        
      $postData->title = "";
      $postData->asXML($postsXML);
    }

    if (isset($_POST['delete_desc'])) {
        
      $postData->desc = "";
      $postData->asXML($postsXML);
    }

    if( isset($_GET['subject']) && isset($_SESSION['username'])) {
        
        if($_GET['subject'] == "adminlogout"){
            
          session_unset();
          session_destroy();
          $username = "";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Natus Memere</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link id="csswitch" rel="stylesheet" type="text/css" href="meme_style.css">
        <script src="dropdownScript.js"></script>
        <script src="ajaxScript.js"></script>
        <script src="galleryScript.js"></script>
        <script src="adminModal.js"></script>
    </head>
    <body>
        <div class="content"> 
            <div class="pretty">
                <h1><a href="main_page.html">Natus Memere</a></h1>
                <img src="Images/kappa1.png" id="kappa">
                <div class="dropdown">
                    <button onclick="openDropdown()" class="dropdownbtn">Menu stuff</button>
                    <div id="dropdownops" class="dropdown-options">
                        <a href="#" onclick="ajaxSwitch('http://localhost:81/wt/clonerino/Files/admin_content.html', 'admin_style.css')">Admin page</a>
                        <!--<a href="#" onclick="ajaxSwitch('http://localhost:81/wt/clonerino/Files/meme_content.php', 'meme_style.css')">Saucy memes</a>-->
                        <a href="meme_content.php">Saucy memes</a>
                        <a href="http://www.w3schools.com/css/css_rwd_grid.asp">Doggos and other special animols</a>
                        <a href="#" onclick="ajaxSwitch('http://localhost:81/wt/clonerino/Files/harambe_content.html', 'harambe_style.css')">Harambe tribute page</a>
                    </div>
                </div>
            </div>
            <div id="innercontent">
                <h2><a href="" id="submitlink">Submit your own dankness</a></h2>
                <div class="gallery">
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="Images/meme1.png" alt="cuck king of england" id="image1" class="images" onload="modalThing(0)">
                            </div>
                            <div class="col-1-2">
                                <?php echo $_SESSION['state']; ?>
                                <?php if(isset($_SESSION['state']) && $_SESSION['state'] === "adminmode"): ?>
                                    <form>
                                        <input type="text" value="Title 1">
                                        <input type="button" value="Change title" name="">
                                        <a href="comment_page.html" class="commentslink">comments</a>
                                        <input type="text" value="Description">
                                        <input type="button" value="Change description" name="">
                                    </form>
                                <?php else: ?>
                                    <h3>Memerino titlerino 1</h3>
                                    <a href="comment_page.html" class="commentslink">comments</a>
                                    <p>Description, maybe</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="Images/meme2.png" id="image2" class="images" onload="modalThing(1)">
                            </div>
                            <div class="col-1-2">
                                <h3>Memerino titlerino 1</h3>
                                <a href="comment_page.html" class="commentslink">comments</a>
                                <p>Description, maybe</p>
                            </div>
                        </div>
                    </div>
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="Images/meme3.jpg" id="image3" class="images" onload="modalThing(2)">
                            </div>
                            <div class="col-1-2">
                                <h3>Memerino titlerino 1</h3>
                                <a href="comment_page.html" class="commentslink">comments</a>
                                <p>Description, maybe</p>
                            </div>
                        </div>
                    </div>
                    <div id="modalid" class="modal">
                        <span class="close" id="imgclose" onclick="document.getElementById('modalid').style.display='none'">&times;</span>
                        <img class="modal-content" id="img">
                        <div id="caption" class="caption"></div>
                    </div>
                </div>
                <button id="adminloginbtn" onclick="adminFoo()">Log in as admin</button>
                <div id="adminmodal" class="modal">
                    <?php require('login.php'); ?>
                </div>
            </div>
        </div>
    </body>
</html>
