<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
          echo '<img src="http://license.divisual.net/img/DiVisual_-Logo_subtext.png" /><br/>
              <p>Dear '.$client['firstname'].' '.$client['secondname'].',<br/>
<br/>
You have ordered a FREE subscription of the „Divisual® Mapping System“. The free academic plan needs to be approved by sending a valid copy of your academic enrollment.
<br/>
The student version provides you with all tools and functions of the „Divisual® Mapping System“.
<br/>
By using the software, you agree to the current license agreements.
<br/>
Declaration of consent: I agree that DiVisual GmbH stores my data in order to inform me about products and services by mail or e-mail. I can revoke this agreement at any time.
<br/>
Please pay particular attention to the following contents of the current license agreement. The student version may only be used:
<br/>
<ul>
<li>exclusively for educational purposes</li>
<li>are not made available to third parties</li>
<li>are not used commercially</li>
</ul>
<br/>
You can send your proof by e-mail to admin@license.divisual.com .<br/>
Please send your documents as PDF, PNG or JPG file.<br/> 
<br/>
<br/>
                    Please note: This email message was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.
<br/>
                    Sincerely,<br/> 
                    DiVisual® Customer Service <br/>
                    DiVisual® support<br/>
<br/>
<br/>
                    ______________________________________________________________________<br/>
<br/>
                    Your Order and Billing Information:<br/>
                    Order Number: '.$license['subscription_id'].' <br/>
                    Order Date: '.$todayDate.' <br/>

                    '.$client['firstname'].' '.$client['secondname'].'<br/>
                    '.$client['company'].'<br/>
                    '.$client['email'].'<br/>
<br/>
<br/>
                    Product Name: DiVisual® Mapping System<br/>
                    Subsсription plan: '.$license['type'].'<br/>
                    Serial Number: '.$license['serial'].'<br/>
<br/>
                    Additional Product Information:<br/>
                    You will need your Serial Key (shown above) to complete the registration. Please use the Register button in the Options tab of the DiVisual® panel to finish your registration process and start creating stunning condition maps for fine arts.<br/>
<br/>
                    In case you want to cancel your subscription you need to send an cancellation email 30 days before renewal of your subscription to orders@divisual.net<br/>
<br/>
<br/>
                    Making collaboration easier than ever! To learn more about DiVisual® Mapping System, visit https://www.divisual.com.<br/></p>';
     ?>
