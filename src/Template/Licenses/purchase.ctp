<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
  
</nav>
<div class="licenses form large-9 medium-8 columns content">
    <?= $this->Form->create($license, ['url' => ['action' => 'checkout']]) ?>
    <p>
        Your free 7-day trial starts with registration. To register, please select a subscription (monthly or annual payment). Your paid subscription only starts after the 7-day trial period has expired. If you wish to cancel your subscription before the end of the trial period, please send us an email at payments@divisual.net
    </p>
    <fieldset>
        <legend><?= __('Purchase License') ?></legend>
        <div id="payment-form"></div>
        <?php
            echo $this->Form->control('client_id', ['type'=>'hidden','value'=>$client['id']]);
            echo $this->Form->control('type', ['options' => ["Yearly"=>"Yearly","Monthly"=>"Monthly","Academic"=>"Academic"], 'empty' => false]);
            echo $this->Form->control('uuid', ['type'=>'hidden','value'=>$uuid]);
            echo $this->Form->control('salt', ['type'=>'hidden','value'=>$salt]);
            echo $this->Form->control('serial', ['type'=>'hidden','value'=>$serial]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

    <script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
        <script>
        // We generated a client token for you so you can test out this code
        // immediately. In a production-ready integration, you will need to
        // generate a client token on your server (see section below).
    

        braintree.setup("<?=$token?>", "dropin", {
          container: "payment-form"
        });
        </script>
