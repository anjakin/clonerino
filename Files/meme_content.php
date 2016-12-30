<?php
    
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

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
                
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                phpAlert("Successful login.");
				$username = $_REQUEST['username'];
				$_SESSION['username']= $username;
                $_SESSION['state'] = "adminmode";
			}
			else {
                
                phpAlert("Wrong login info.");
                if (session_status() != PHP_SESSION_NONE) {
                    session_unset();
                    session_destroy();
                }
                
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
                <title>First meme</title>
                <desc>This is the first meme</desc>
                <image>Images/meme1.png</image>
            </post>
            <post>
                <title>Second meme</title>
                <desc>This is the second meme</desc>
                <image>Images/meme2.png</image>
            </post>
            <post>
                <title>Third meme</title>
                <desc>This is the third meme</desc>                
                <image>Images/meme3.jpg</image>
            </post>
        </posts>");
        $postData->asXML($postsXML);
    }

    else {
        
      $postData = simplexml_load_file($postsXML);
    }

    // updates part
    if (isset($_POST['save_changes1'])) {
        
        $postData->post[0]->title = $_POST['input_title1'];
        $postData->post[0]->desc = $_POST['input_desc1'];
        
        $postData->asXML($postsXML);
    }

    if (isset($_POST['save_changes2'])) {
        
        $postData->post[1]->title = $_POST['input_title2'];
        $postData->post[1]->desc = $_POST['input_desc2'];
        
        $postData->asXML($postsXML);
    }

    if (isset($_POST['save_changes3'])) {
        
        $postData->post[2]->title = $_POST['input_title3'];
        $postData->post[2]->desc = $_POST['input_desc3'];
        
        $postData->asXML($postsXML);
    }

    if (isset($_POST['delete_post1'])) {
        
        $postData->post[0]->title = "REMOVED";
        $postData->post[0]->desc = "REMOVED";
        $postData->post[0]->image = 'Images/placeholder.png';
        
        $postData->asXML($postsXML);
    }

    if (isset($_POST['delete_post2'])) {
        
        $postData->post[1]->title = "REMOVED";
        $postData->post[1]->desc = "REMOVED";
        $postData->post[1]->image = 'Images/placeholder.png';
        
        $postData->asXML($postsXML);
    }

    if (isset($_POST['delete_post3'])) {
        
        $postData->post[2]->title = "REMOVED";
        $postData->post[2]->desc = "REMOVED";
        $postData->post[2]->image = 'Images/placeholder.png';
        
        $postData->asXML($postsXML);
    }

    if(isset($_GET['subject']) && isset($_SESSION['username'])) {
        
        if($_GET['subject'] == "adminlogout"){
            
          session_unset();
          session_destroy();
          $username = "";
        }
    }
    
    // csv part
    $file = fopen("data.csv", "w") or die("Can't create file");
    $file_input = array();
    
    foreach($postData->children() as $post) {
        $line = array();
        foreach($post->children() as $item) {
            array_push($line, $item);
        }
        
        array_push($file_input, $line);
    }

    foreach ($file_input as $fields) {
        
        fputcsv($file, $fields);
    }
    
    $jpgs = 0;
    $pngs = 0;

    if (strpos($postData->post[0]->image, 'jpg')) {
        
        $jpgs++;
    }
    else {
        
        $pngs++;
    }

    if (strpos($postData->post[1]->image, 'jpg')) {
        
        $jpgs++;
    }
    else {
        
        $pngs++;
    }

    if (strpos($postData->post[2]->image, 'jpg')) {
        
        $jpgs++;
    }
    else {
        
        $pngs++;
    }

    // pdf part
    require('fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B', 16);
    $pdf->SetTitle('Random stuff');
    $pdf->Cell(40, 5, "Title");
    $pdf->Cell(40, 5, "Description");
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(40, 5, $postData->post[0]->title);
    $pdf->Cell(40, 5, $postData->post[0]->desc);
    $pdf->Ln(10);
    $pdf->Cell(40, 5, $postData->post[1]->title);
    $pdf->Cell(40, 5, $postData->post[1]->desc);
    $pdf->Ln(10);
    $pdf->Cell(40, 5, $postData->post[2]->title);
    $pdf->Cell(40, 5, $postData->post[2]->desc);
    $pdf->Image('Images/kappa1.png', 120, 5, -300);
    $pdf->Ln(30);
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(40, 5, "JPG images");
    $pdf->Cell(40, 5, "PNG images");
    $pdf->SetFont('Arial','I', 12);
    $pdf->Ln(10);
    $pdf->Cell(40, 5, $jpgs);
    $pdf->Cell(40, 5, $pngs);
    $pdf->Output('F', "statistics.pdf");
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
        <script src="search.js"></script>
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
                        <a href="#" onclick="ajaxSwitch('http://localhost:81/wt/clonerino/Files/doggos_content.html', 'doggos_style.css')">Doggos and other special animols</a>
                        <a href="#" onclick="ajaxSwitch('http://localhost:81/wt/clonerino/Files/harambe_content.html', 'harambe_style.css')">Harambe tribute page</a>
                    </div>
                </div>
            </div>
            <div id="innercontent">
                <h2><a href="submit_page.html" id="submitlink">Submit your own dankness</a></h2>
                <div class="gallery">
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="<?php echo $postData->post[0]->image ?>" alt="cuck king of england" id="image1" class="images" onload="modalThing(0)">
                            </div>
                            <div class="col-1-2">
                                <?php if(isset($_SESSION['state']) && $_SESSION['state'] === "adminmode"): ?>
                                    <?php
                                        $postData = simplexml_load_file($postsXML);
                                        $children = $postData->children();
                                        $grandchildren = $children[0]->children();
                                        echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($grandchildren[0])).'" name="input_title1" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes1" id="savebtn1">Save changes</button>
                                            <button type="submit" name="delete_post1" id="deletebtn1">Remove post</button>
                                            <br>
                                            <textarea name="input_desc1" id="desc_textarea">'.trim(htmlspecialchars($grandchildren[1])).'</textarea>
                                        </form>';
                                        if (isset($_POST['save_changes1'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[0]->title = $_POST['input_title1'];
                                            $newXML->post[0]->desc = $_POST['input_desc1'];
                                            $newXML->asXML($postsXML);
                                        }
                                
                                        if (isset($_POST['delete_post1'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[0]->title = "REMOVED";
                                            $newXML->post[0]->desc = "REMOVED";
                                            $newXML->post[0]->image = 'Images/placeholder.png';
                                            $newXML->asXML($postsXML);
                                        }
                                    ?>
                                <?php else: ?>
                                    <h3><?php echo $postData->post[0]->title ?></h3>
                                    <a href="comment_page.html" class="commentslink">comments</a>
                                    <p><?php echo $postData->post[0]->desc ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="<?php echo $postData->post[1]->image ?>" id="image2" class="images" onload="modalThing(1)">
                            </div>
                            <div class="col-1-2">
                                <?php if(isset($_SESSION['state']) && $_SESSION['state'] === "adminmode"): ?>
                                    <?php
                                        $postData = simplexml_load_file($postsXML);
                                        $children = $postData->children();
                                        $grandchildren = $children[1]->children();
                                        echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($grandchildren[0])).'" name="input_title2" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes2" id="savebtn2">Save changes</button>
                                            <button type="submit" name="delete_post2" id="deletebtn2">Remove post</button>
                                            <br>
                                            <textarea name="input_desc2" id="desc_textarea">'.trim(htmlspecialchars($grandchildren[1])).'</textarea>
                                        </form>';
                                        if (isset($_POST['save_changes2'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[1]->title = $_POST['input_title2'];
                                            $newXML->post[1]->desc = $_POST['input_desc2'];
                                            $newXML->asXML($postsXML);
                                        }
                                
                                        if (isset($_POST['delete_post2'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[1]->title = "REMOVED";
                                            $newXML->post[1]->desc = "REMOVED";
                                            $newXML->post[1]->image = 'Images/placeholder.png';
                                            $newXML->asXML($postsXML);
                                        }
                                    ?>
                                <?php else: ?>
                                    <h3><?php echo $postData->post[1]->title ?></h3>
                                    <a href="comment_page.html" class="commentslink">comments</a>
                                    <p><?php echo $postData->post[1]->desc ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-2 clearfix">
                        <div class="bordered">
                            <div class="col-1-4">
                                <img src="<?php echo $postData->post[2]->image ?>" id="image3" class="images" onload="modalThing(2)">
                            </div>
                            <div class="col-1-2">
                                <?php if(isset($_SESSION['state']) && $_SESSION['state'] === "adminmode"): ?>
                                    <?php
                                        $postData = simplexml_load_file($postsXML);
                                        $children = $postData->children();
                                        $grandchildren = $children[2]->children();
                                        echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($grandchildren[0])).'" name="input_title3" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes3" id="savebtn3">Save changes</button>
                                            <button type="submit" name="delete_post3" id="deletebtn3">Remove post</button>
                                            <br>
                                            <textarea name="input_desc3" id="desc_textarea">'.trim(htmlspecialchars($grandchildren[1])).'</textarea>
                                        </form>';
                                        if (isset($_POST['save_changes3'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[2]->title = $_POST['input_title3'];
                                            $newXML->post[2]->desc = $_POST['input_desc3'];
                                            $newXML->asXML($postsXML);                                           
                                        }
                                
                                    if (isset($_POST['delete_post3'])) {
                                            
                                            $newXML = simplexml_load_file($postsXML);
                                            $newXML->post[2]->title = "REMOVED";
                                            $newXML->post[2]->desc = "REMOVED";
                                            $newXML->post[2]->image = 'Images/placeholder.png';
                                            $newXML->asXML($postsXML);
                                        }
                                    ?>
                                <?php else: ?>
                                    <h3><?php echo $postData->post[2]->title ?></h3>
                                    <a href="comment_page.html" class="commentslink">comments</a>
                                    <p><?php echo $postData->post[2]->desc ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div id="modalid" class="modal">
                        <span class="close" id="imgclose" onclick="document.getElementById('modalid').style.display='none'">&times;</span>
                        <img class="modal-content" id="img">
                        <div id="caption" class="caption"></div>
                    </div>
                </div>
                <div class="row-2 clearfix">
                    <?php if(isset($_SESSION['state']) && $_SESSION['state'] === "adminmode"): ?>
                        <a href="meme_content.php?subject=adminlogout" id="logoutlink">Log out</a>
                        <br>
                        <a href="data.csv" id="downloadcsv">Download csv file</a>
                        <br>
                        <a href="statistics.pdf" id="downloadpdf">Open pdf file</a>
                    <?php else: ?>
                        <button id="adminloginbtn" onclick="adminFoo()">Log in as admin</button>
                        <div id="adminmodal" class="modal">
                            <?php require('login.php'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
