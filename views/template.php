<!DOCTYPE html>
<html>
  <head>
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="<?php echo BASE_URL; ?>assets/css/estilos.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <?php $this->loadViewInTemplate($viewName, $viewData);?>

    <div class="modalBG" style="display:none;">
      <div class="modalArea">...</div>
    </div>
    <script type="text/javascript">
      var BASE_URL = "<?php echo BASE_URL;?>";
      var groupList = <?php echo json_encode($viewData['currentGroups']);?>;
    </script>
    <script
      src="<?php echo BASE_URL; ?>assets/js/jquery.js"
      type="text/javascript"
    ></script>
    <script
      src="<?php echo BASE_URL; ?>assets/js/chat.js"
      type="text/javascript"
    ></script>
    <script
      src="<?php echo BASE_URL; ?>assets/js/script.js"
      type="text/javascript"
    ></script>
  </body>
</html>
