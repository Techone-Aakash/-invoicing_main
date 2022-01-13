<?php include 'header.php'; ?>
<div style="height: 100vh;">
           <div class="flex-center">
               
           
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <!-Form without header->
                    <div class="card login">
                        <div class="card-content">
                           
                            <div class="text-center">
                               <h3><i class="fa fa-lock"></i> Login:</h3>
                            </div>
                            
                            <div class="row">
                                <form class="col-md-12">
                                  <div class="row">
                                    <div class="input-field col-md-12">
                                      <i class="fa fa-envelope prefix"></i>
                                      <input id="icon_prefix" type="text" class="validate">
                                      <label for="icon_prefix">Your email</label>
                                    </div>
                                    <div class="input-field col-md-12">
                                      <i class="fa fa-lock prefix"></i>
                                      <input id="icon_telephone" type="tel" class="validate">
                                      <label for="icon_telephone">Your password</label>
                                    </div>
                                  </div>
                                </form>
                             </div>
                               
                             <div class="text-center">
                                <button class="btn btn-default waves-effect waves-light">Login</button>
                             </div>
                             
                             <!–Footer–>
                             <div class="modal-footer">
                                <div class="options">
                                    <p>Not a member? Sign Up</p>
                                    <p>Forgot Password?</p>
                                </div>
                             </div>
                            
                        </div>
                    </div>
                    <!–/Form without header–>
                </div>
            </div>
        </div>
        
        </div>
       </div>
       <?php include 'footer.php'; ?>

       <style>
        .modal-footer {
            margin-top: 1rem;
        }
       
            .flex-center {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100%;
        }
        </style>