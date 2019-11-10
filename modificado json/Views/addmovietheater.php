<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="<?php echo FRONT_CSS; ?>css/alertify.css">
    <link rel="stylesheet" type="text/css" href="<?php echo FRONT_CSS; ?>css/themes/default.css">

    <script src="<?php echo FRONT_CSS; ?>jquery-3.2.1.min.js"></script>
    <script src="<?php echo FRONT_CSS; ?>alertify.js"></script>

</head>

<body>

    <div id="tabla">

    </div>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla').load('components/createBillBoardTable.php');
    });
</script>

