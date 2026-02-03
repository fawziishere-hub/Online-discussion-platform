<style>
  /* Style the welcome message */
  /* hr {
    background-color: #222831; */

  hr {
    border: none;
    /* Remove the default border */
    height: 1px;
    /* Set the desired height */
    background-color: #ccc;
    /* Set the desired color */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    /* Add a subtle shadow */
  }


  h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
  }

  /* Style the info boxes */
  .info-box {
    border-radius: 0.5rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    border: none;
    border-radius: 50px;
  }

  .info-box:hover {
    transform: translateY(-5px);
    /* Add a subtle hover effect */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .info-box-icon {
    border-radius: 0.5rem 0 0 0.5rem;
    /* Add rounded corners to the icon */
  }

  .info-box-content {
    padding: 1rem;

  }

  .info-box-text {
    font-weight: 600;
  }

  .info-box-number {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
  }

  /* Style the carousel */
  /* #tourCarousel .carousel-inner {
    border-radius: 0.5rem;
    overflow: hidden;
  } */

  /* #tourCarousel .carousel-item img {
    height: 300px; */
  /* Adjust the height as needed */
  /* object-fit: cover;
  } */

  /* #tourCarousel .carousel-control-prev,
  #tourCarousel .carousel-control-next {
    width: 5%; */
  /* Adjust the width of the carousel controls */
  /* } */
</style>
<h1>Welcome, <?php echo $_settings->userdata('firstname') . " " . $_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon rounded-pill bg-gradient-gray elevation-2"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Category List</span>
        <span class="info-box-number">
          <?php
          $category = $conn->query("SELECT * FROM category_list where delete_flag = 0 and `status` = 1")->num_rows;
          echo format_num($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon  rounded-pill bg-gradient-light  elevation-2"><i
          class="fas fa-user-friends"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Registered Users</span>
        <span class="info-box-number">
          <?php
          $user = $conn->query("SELECT * FROM users where `type` = 2 ")->num_rows;
          echo format_num($user);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon rounded-pill bg-gradient-primary elevation-2"><i class="fas fa-blog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Published Post</span>
        <span class="info-box-number">
          <?php
          $posts = $conn->query("SELECT * FROM post_list where `status` = 1 and delete_flag = 0 ")->num_rows;
          echo format_num($posts);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon rounded-pill bg-gradient-secondary elevation-2"><i class="fas fa-blog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Unpublished Post</span>
        <span class="info-box-number">
          <?php
          $posts = $conn->query("SELECT * FROM post_list where `status` = 0 and delete_flag = 0 ")->num_rows;
          echo format_num($posts);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
<!-- <div class="container">
  <?php
  $files = array();
  $fopen = scandir(base_app . 'uploads/banner');
  foreach ($fopen as $fname) {
    if (in_array($fname, array('.', '..')))
      continue;
    $files[] = validate_image('uploads/banner/' . $fname);
  }
  ?>
  <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner h-100">
      <?php foreach ($files as $k => $img): ?>
        <div class="carousel-item  h-100 <?php echo $k == 0 ? 'active' : '' ?>">
          <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
        </div>
      <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div> -->