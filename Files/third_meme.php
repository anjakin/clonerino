<?php
                                        $postData = simplexml_load_file($postsXML);
                                        $children = $postData->children();
                                        $grandchildren = $children[2]->children();
                                
                                        $title = $postData->post[2]->title;
                                        $description = $postData->post[2]->desc;

                                        $inputTitle = "";
                                        $inputDesc = "";
                                
                                        $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                        $connection->exec("set names utf8");
                                        
                                        $i = 0;
                                        foreach ($connection->query("SELECT * FROM `posts` WHERE `id`=3;") as $row) {
                                                
                                            $inputTitle = $row['title'];
                                            $inputDesc = $row['description'];
                                            $i++;
                                        }
                                        
                                        $connection = null;
                                        
                                        if ($i == 0) {
                                            
                                            echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($grandchildren[0])).'" name="input_title3" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes3" id="savebtn3">Save changes</button>
                                            <button type="submit" name="delete_post3" id="deletebtn3">Remove post</button>
                                            <button type="submit" name="add_to_sql3" id="addbtn3">Add post data to database</button>
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
                                        }
                                        else {
                                            
                                            echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                            <input type="text" value="'.trim(htmlspecialchars($inputTitle)).'" name="input_title3" id="title_area">
                                            <a href="comment_page.html" class="commentslink">comments</a>
                                            <button type="submit" name="save_changes3" id="savebtn3">Save changes</button>
                                            <button type="submit" name="delete_post3" id="deletebtn3">Remove post</button>
                                            <button type="submit" name="add_to_sql3" id="addbtn3">Add post data to database</button>
                                            <br>
                                            <textarea name="input_desc3" id="desc_textarea">'.trim(htmlspecialchars($inputDesc)).'</textarea>
                                            </form>';
                                    
                                            if (isset($_POST['save_changes3'])) {
                                                
                                                $newXML = simplexml_load_file($postsXML);
                                                $newXML->post[2]->title = $_POST['input_title3'];
                                                $newXML->post[2]->desc = $_POST['input_desc3'];
                                                $newXML->asXML($postsXML);
                                                
                                                $newTitle = $_POST['input_title3'];
                                                $newDesc = $_POST['input_desc3'];
                                                $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                                $connection->exec("set names utf8");
                                                
                                                $result = $connection->query("UPDATE `posts` SET `title`='$newTitle', `description`='$newDesc' WHERE `id`=3;");
                                                
                                                if (!$result) {

                                                    $error = $connection->errorInfo();
                                                    print "SQL error: " . $error[2];
                                                    exit();
                                                }
                                            }

                                            if (isset($_POST['delete_post3'])) {
                                                
                                                $newXML = simplexml_load_file($postsXML);
                                                $newXML->post[2]->title = "REMOVED";
                                                $newXML->post[2]->desc = "REMOVED";
                                                $newXML->post[2]->image = 'Images/placeholder.png';
                                                $newXML->asXML($postsXML);
                                                
                                                $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                                $connection->exec("set names utf8");
                                                
                                                $result = $connection->query("DELETE FROM `posts` WHERE `id`=3;");
                                                
                                                if (!$result) {

                                                    $error = $connection->errorInfo();
                                                    print "SQL error: " . $error[2];
                                                    exit();
                                                }
                                            }
                                        }

                                        if (isset($_POST['add_to_sql3'])) {

                                                $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
                                                $connection->exec("set names utf8");

                                                $i = 0;
                                                foreach ($connection->query("SELECT * FROM `posts` WHERE `id`=3;") as $row) {

                                                    $i++;
                                                }

                                                if ($i == 0) {

                                                        $result = $connection->query("INSERT INTO `posts` (`id`, `title`, `description`, `editor`) VALUES (3, '$title', '$description', 'admin');");

                                                        if (!$result) {

                                                            $error = $connection->errorInfo();
                                                            print "SQL error: " . $error[2];
                                                            exit();
                                                        }
                                                }
                                                else {

                                                    $result = $connection->query("UPDATE `posts` SET `title`='$title', `description`='$description' WHERE `id`=3;");

                                                    if (!$result) {

                                                        $error = $connection->errorInfo();
                                                        print "SQL error: " . $error[2];
                                                        exit();
                                                    }
                                                }

                                                $connection = null;
                                        }
                                    ?>