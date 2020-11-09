<?php 
require_once('includes/header.php');
require_once('includes/classes/VideoDetailFormProvider.php'); 
?>                 
<div class="column" id="column">
    <?php 
    $formProvider= new VideoDetailFormProvider($con);
    echo $formProvider->createUploadForm(); 

    
    ?>
</div>

<div class="modal" id="loadingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
      Please wait this might take a while
      <img src="assets/images/icons/loading-spinner.gif" alt="loading..." width="200px" height="200px" data-backdrop="static" data-keyboard="false">
      </div>
     
    </div>
  </div>
</div>

<script>
$("form").submit(function(){
    $('#loadingModal').show();
})
</script>
<?php require_once('includes/footer.php') ?> 
