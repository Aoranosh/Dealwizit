<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="inc/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="inc/css/animate.css"> -->
<?php require_once ('inc/init.inc.php'); ?>
</head>
<body>
<?php require_once ('inc/haut.inc.php'); ?>
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
    <h3>Contactez nous !</h3>
    <form role="form" id="contactForm">
        <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="name" class="h4">Nom, Prénom</label>
                        <input type="text" data-error="Recommencez!" class="form-control" id="name" placeholder="Nom, Prénom" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="email" class="h4">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Votre email" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="tel" class="h4">Téléphone</label>
                        <input type="tel" class="form-control" id="tel" placeholder="Votre téléphone">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="h4 ">Message</label>
                    <textarea id="message" class="form-control" rows="10" placeholder="Votre message" required></textarea>
                    <div class="help-block with-errors"></div>
                </div>
                <button type="submit" id="form-submit" class="btn btn-success pull-right ">Envoyer</button>
        <div id="msgSubmit" class="h3 text-center hidden">Message Envoyé!</div>
    </form>
</div>
</div>
<?php require_once ('inc/bas.inc.php'); ?>
</body>

<script type="text/javascript" src="inc/js/formScripts.js"></script>
<script  type="text/javascript" src="inc/js/jquery.min.js"></script>
</html>
