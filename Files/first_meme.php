<?php
                                
                                        $postData = simplexml_load_file($postsXML);
                                        $children = $postData->children();
                                        $grandchildren = $children[0]->children();
                                
                                        $title = $postData->post[0]->title;
                                        $description = $postData->post[0]->desc;
                                
                                        $inputTitle = "";
                                        $inputDesc = "";
                                
                                        $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                        $connection->exec("set names utf8");
                                        
                                        $i = 0;
                                        foreach ($connection->query("SELECT * FROM `posts` WHERE `id`=1;") as $row) {
                                                
                                            $inputTitle = $row['title'];
                                            $inputDesc = $row['description'];
                                            $i++;
                                        }
                                        
                                        $connection = null;
                                        
                                        if ($i == 0) {
                                            
                                            echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($grandchildren[0])).'" name="input_title1" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes1" id="savebtn1">Save changes</button>
                                            <button type="submit" name="delete_post1" id="deletebtn1">Remove post</button>
                                            <button type="submit" name="add_to_sql1" id="addbtn1">Add post data to database</button>
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
                                        }
                                        else {
                                            
                                            echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($inputTitle)).'" name="input_title1" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes1" id="savebtn1">Save changes</button>
                                            <button type="submit" name="delete_post1" id="deletebtn1">Remove post</button>
                                            <button type="submit" name="add_to_sql1" id="addbtn1">Add post data to database</button>
                                            <br>
                                            <textarea name="input_desc1" id="desc_textarea">'.trim(htmlspecialchars($inputDesc)).'</textarea>
                                            </form>';
                                    
                                            if (isset($_POST['save_changes1'])) {
                                                
                                                $newXML = simplexml_load_file($postsXML);
                                                $newXML->post[0]->title = $_POST['input_title1'];
                                                $newXML->post[0]->desc = $_POST['input_desc1'];
                                                $newXML->asXML($postsXML);
                                                
                                                $newTitle = $_POST['input_title1'];
                                                $newDesc = $_POST['input_desc1'];
                                                $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                                $connection->exec("set names utf8");
                                                
                                                $result = $connection->query("UPDATE `posts` SET `title`='$newTitle', `description`='$newDesc' WHERE `id`=1;");
                                                
                                                if (!$result) {

                                                    $error = $connection->errorInfo();
                                                    print "SQL error: " . $error[2];
                                                    exit();
                                                }
                                            }

                                            if (isset($_POST['delete_post1'])) {
                                                
                                                $newXML = simplexml_load_file($postsXML);
                                                $newXML->post[0]->title = "REMOVED";
                                                $newXML->post[0]->desc = "REMOVED";
                                                $newXML->post[0]->image = 'Images/placeholder.png';
                                                $newXML->asXML($postsXML);
                                                
                                                $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                                $connection->exec("set names utf8");
                                                
                                                $result = $connection->query("DELETE FROM `posts` WHERE `id`=1;");
                                                
                                                if (!$result) {

                                                    $error = $connection->errorInfo();
                                                    print "SQL error: " . $error[2];
                                                    exit();
                                                }
                                            }
                                        }
                                
                                        if (isset($_POST['add_to_sql1'])) {
                                            
                                            $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                            $connection->exec("set names utf8");
                                                                                        
                                            $i = 0;
                                            foreach ($connection->query("SELECT * FROM `posts` WHERE `id`=1;") as $row) {
                                                
                                                $i++;
                                            }
                                                
                                            if ($i == 0) {
                                                    
                                                    $result = $connection->query("INSERT INTO `posts` (`id`, `title`, `description`, `editor`) VALUES (1, '$title', '$description', 'admin');");
                                                    
                                                    if (!$result) {

                                                        $error = $connection->errorInfo();
                                                        print "SQL error: " . $error[2];
                                                        exit();
                                                    }
                                            }
                                            else {
                                                
                                                $result = $connection->query("UPDATE `posts` SET `title`='$title', `description`='$description' WHERE `id`=1;");
                                                
                                                if (!$result) {

                                                    $error = $connection->errorInfo();
                                                    print "SQL error: " . $error[2];
                                                    exit();
                                                }
                                            }
                                            
                                            $connection = null;
                                        }
                                    ?>