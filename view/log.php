<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="vendor/css/style.css" rel="stylesheet" media="all">
        <link href="vendor/css/animate.css" rel="stylesheet" media="all">
    </head>
    <body>
        
            <div class="col-12 text-center animated fadeInDown">
                <img src="view/images/mcu-logo.png" alt=""/>
            </div>
        
        <div class="modal-dialog text-center animated flipInX">
            <div class="col-sm-12 col-md-9 main-section">
                <div class="modal-content">

                    <div class="col-12 user-img ">
                        <img src="view/images/icon/person.png" alt="user-logo">
                    </div>

                    <div class="col-12 form-input">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <input name="user" type="text" class="form-control" placeholder=" Nom D'Utilisateur">
                            </div>

                            <div class="form-group">
                                <input name="pass" type="password" class="form-control" placeholder="Mot de passe">
                                <input style="display: none;" type="text" name="action" value="login">
                            </div>
                            <button class="btn btn-success custom-btn">Login</button>
                        </form>
                    </div>

                    <div class="col-12 forgot">
                        <a href="#">Mot de passe oublié ?</a>
                    </div>
                    <div style="color: red; letter-spacing:3px; font-weight: bold;"class="col-12">
                        <?= $error ?>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="bootstrap.min.js" type="text/javascript"></script>
        <script src="popper.min.js" type="text/javascript"></script>
    </body>
</html>