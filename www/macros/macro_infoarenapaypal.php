<?php

// Displays a paypal donation button for the infoarena paypal account
//
// Arguments: none
//
// Example: ==infoarenaPayPal()==

function macro_infoarenapaypal() {
    return <<<EOS
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="R6Q8WNVR7PNMU">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
EOS;
}
