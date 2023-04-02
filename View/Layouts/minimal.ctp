<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<title> 
        <?php 
        echo $this->fetch('title') . ' ' . $this->fetch('title_for_layout'); 
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
        crossorigin="anonymous"></script>
	   <?php  
        //echo $this->Html->css('bootstrap.min');   
		//echo $this->Html->script(array('jquery-1.11.0.min', 'typeahead.bundle.min.js'));  
        ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
        crossorigin="anonymous"></script>

        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');     
    ?>  
</head>
<body class="s_layout_fixed">
    <div class="row">
        <div class="container wrapper">   
			<?php echo $this->fetch('content'); ?>
        </div>
        <div class="clearfix"></div> 
    </div>
    <br />

    <div class="row">
        <div class="container">
            <p class="text-center">--*--</p>
        </div>
    </div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content"> 
      <div class="modal-body">
        <p>Sequencing 0's and 1's. Please wait ...</p>
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div> 
    </div>

  </div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
    $('.wait_dial').click(function(){
        $('.modal').modal('show');
    });
});  
</script>

</body>
</html>
