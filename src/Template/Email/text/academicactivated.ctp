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
<?= 'Dear '.$client['firstname'].' '.$client['secondname'].',

We have received the confirmation of your academic enrollment and checked it with a positive result. Your subscription has just been activated. In case of difficulties, please open a support ticket via our website

                    Please note: This email message was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.

                    Sincerely, 
                    DiVisual® Customer Service 
                    DiVisual® support


                    ______________________________________________________________________

                    Your Order and Billing Information:
                    Order Number: '.$license['subscription_id'].' 

                    '.$client['firstname'].' '.$client['secondname'].'
                    '.$client['company'].'
                    '.$client['email'].'


                    Product Name: DiVisual® Mapping System
                    Subsсription plan: '.$license['type'].'
                    Serial Number: '.$license['serial'].'

                    Additional Product Information:
                    You will need your Serial Key (shown above) to complete the registration. Please use the Register button in the Options tab of the DiVisual® panel to finish your registration process and start creating stunning condition maps for fine arts.

                    In case you want to cancel your subscription you need to send an cancellation email 30 days before renewal of your subscription to orders@divisual.net


                    Making collaboration easier than ever! To learn more about DiVisual® Mapping System, visit https://www.divisual.com.'  ?>
