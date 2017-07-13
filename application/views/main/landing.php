<link href="/assets/styles/landing.css" rel="stylesheet"/>
<div class="container-fluid body-text">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <div class="logo">
                    <img src="./assets/images/logo.png" alt="Goat Attack Logo" class="img-responsive" />
                    <p class="tagline">Ram these goats down your friends throats!!</p>
                </div>

<?php
 if(isset($message) && $message!=null){
?>
<div class="alert alert-success">
  <strong>Success!</strong> <?php echo($message); ?>
</div>
<?php 
}
?>

<form action="/main/charge" method="post" id="payment-form">               

                <div class="payment">
                    <p>Send 6, 13 or a ridiculous 30 goat text messages to friends and family from random numbers to really mess with their minds as an awesome prank!</p>
                    <ul id="valid-recipients" class="fa-ul"></ul>

                          <div class="form-group" id="recipients">
                            <label class="sr-only">Recipient Phone Number (5554447788)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="recipient" name="recipient" placeholder="Phone Number (5554447788)" />
                                <span class="input-group-addon add-recipient" title="Add" rel="tooltip" data-placement="top"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" data-val="true" data-val-number="The field AttackPlanId must be a number." data-val-required="The AttackPlanId field is required." id="attackplan" name="attackplan">
                            <?php 
                                foreach($smstypes as $smstype){
                                    $str_item = $smstype["name"]." - ".$smstype["count"]." messages, $".$smstype["price"];
                            ?>

                                <option value="<?php echo($smstype["id"]);?>"><?php echo($str_item);?></option>
                            <?php }?>
                            </select>
                        </div>
                        <!--div class="form-group">
                            <label>
                                Custom message? (+ $0.10)
                                <input data-val="true" data-val-required="The HasCustomMessage field is required." id="HasCustomMessage" name="HasCustomMessage" type="checkbox" />
                            </label>
                            <label class="sr-only">Custom Message</label>
                            <textarea class="form-control" name="CustomMessage" id="CustomMessage" placeholder="Custom message 100 character limit..." maxlength="100"></textarea>
                        </div-->
                        <div class="groupname">
                        <div class="form-group">
                            <label class="sr-only">Your Name*</label>
                            <input class="form-control" data-val="true" data-val-required="The Customer field is required." id="Customer" name="Customer" placeholder="Your Name*" type="text" value="" />
                        </div>
                        </div>
                        <div id="dropin" class="payment-form">
                            <div class="form-row">
                                <label for="card-element">
                                  Credit or debit card
                                </label>
                                <div id="card-element">
                                  <!-- a Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert"></div>
                              </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                    <button class="btn btn-primary" type="button" id="submitorder"><i class="fa fa-lock"></i> Place Order</button>
                                <p style="font-style:italic; font-size:11px; padding-top:8px;">We store no data and never see your credit card. All transactions processed through <a href="http://braintreepayments.com" target="_blank">BraintreePayments.com</a>. PayPal charges appear from "Breaker Studios".</p>
                                <p style="font-style:italic; font-size:11px; padding-top:4px;">*We need your name to comply with spam regulations and inform your friend who is sending the attack.</p>
                                <p style="font-style:italic; font-size:11px; padding-top:4px;">US numbers only please. Standard text rates apply and goatattack.com is not responsible for any such fees, so please use responsibly.</p>
                            </div>
                            <div class="col-md-2">
                                <div class="client-total pull-right" id="client-total"></div>
                            </div>
                        </div>
                </div>
</form>
            </div>
            <div class="col-md-4 iphone-wrapper">
                <img src="./assets/images/iphone.png" class="iphone" />
                <img src="./assets/images/iphone-goat.png" class="iphone-goat" />
                <div class="text-container">
                    <img class="text-message" src="./assets/images/messages/1.png"/>
                    <img class="text-message" src="./assets/images/messages/2.png" />
                    <img class="text-message" src="./assets/images/messages/3.png" />
                    <img class="text-message" src="./assets/images/messages/4.png" />
                    <img class="text-message" src="./assets/images/messages/5.png" />
                    <img class="text-message" src="./assets/images/messages/6.png" />
                    <img class="text-message" src="./assets/images/messages/7.png" />
                    <img class="text-message" src="./assets/images/messages/8.png" />
                </div>
                
            </div>
        </div>
    </div>
</div>



    <div class="container-fluid">
        <hr />
        <footer class="text-center">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-inline">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About & Privacy</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p>&copy; 2017  Goat Attack</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline">
                        <li><a href="https://twitter.com/goatattackme" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
                        <li><a href="https://instagram.com/goatattackme" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
<script src="https://js.stripe.com/v3/" defer></script>
<script type="text/javascript" defer src="/assets/js/landing.js"></script>