<!--SIDE AREA START -->
<div class="col-sm-4" >
            <div class="card mt-4">
                <div class="card-body">
                    <img src="images/startblog.png" class="d-block img-fluid mb-3" alt="">
                    <div class="text-center">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                </div>                
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h2 class="lead">Sign Up!</h2>
                </div>                
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-block text-center text-white" name="button">Join the Forum</button>
                    <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe now</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                        <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?><br></span></a>
                        <?php }?>
                    </div>
                 </div>
                 <br>
                 <div class="card">
                     <div class="card-header bg-info text-white"> 
                        <h2 class="lead">Recent Posts</h2>
                     </div>
                     <div class="card-body">
                         <?php 
                         $ConnectingDB;
                         $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                         $stmt = $ConnectingDB->query($sql);
                         while ($DataRows=$stmt->fetch()){
                             $Id        =$DataRows['id'];
                             $Title     =$DataRows['title'];
                             $DateTime  =$DataRows['datetime'];
                             $Image     =$DataRows['image'];
                         ?>
                         <div class="media">
                            <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block ing-fluid align-self-start" width="90" height="94" alt="" >
                            <div class="media-body m1-2">
                                <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead ml-1"><?php echo $Title; ?></h6></a>
                                <p class="small ml-1"><?php echo htmlentities($DateTime); ?></p>
                            </div>
                         </div>
                         <hr>
                         <?php } ?>
                     </div>

                 </div>
        </div>
        <!--SIDE AREA END -->
    </div>
</div>
<!-- HEADER END-->
<br>
<!-- FOOTER -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
            <p class="lead text-center">Theme by | Jazeb Akram | <span id="year"></span> &copy; ----All rights Reserved.</p>
            <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="#">
                This site is only used for studying purposes, jazebakram.com have all rights. No one is allowed to distribute copiers other than <br>
                &trade; jazebakram.com &trade; Udemy &trade; Skillshare; &trade; StackSkills
            </a></p>
            </div>
        </div>
    </div>
</footer>
<div style="height:10px; background:#27aae1;"></div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());

</script>
</body>
</html>