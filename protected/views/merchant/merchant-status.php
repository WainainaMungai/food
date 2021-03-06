<?php 
$merchant_id=Yii::app()->functions->getMerchantID();
$token='';
if ($info=Yii::app()->functions->getMerchant($merchant_id)){
	$token=$info['activation_token'];
}
if (empty($token)){
	/*update the merchant token*/
	$token=Yii::app()->functions->updateMerchantToken($merchant_id);	
}

$class=Yii::app()->functions->membershipStatusClass($info['status']);
?>
<form class="uk-form uk-form-horizontal" action="<?php echo Yii::app()->request->baseUrl."/store/merchantSignup/Do/step3/token/$token";?>">
<?php echo CHtml::hiddenField('action','upgradeMembership')?>

<h2><?php echo Yii::t("default","Membership Status")?></h2>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Package Name")?></label>  
  <span class="uk-text-muted"><?php echo $info['package_name']?></span>
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Package Price")?></label>  
  <span class="uk-text-muted"><?php echo prettyFormat($info['package_price'])?></span>
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Membership Expired On")?></label>  
  <span class="uk-text-muted"><?php echo $info['membership_expired']?></span>
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>  
  <span class="<?php echo $class;?> uk-text-large"><?php echo $info['status']?></span>
</div>

<h2><?php echo Yii::t("default","Upgrade Membership");?></h2>

<!--<div class="uk-form-row">
  <label class="uk-form-label uk-text-bold"><?php echo Yii::t("default","Select Package")?></label>  
</div>-->

<ul style="margin-left:168px;">
<?php   
if ($p=Yii::app()->functions->getPackagesList(true))
{
	foreach ($p as $val) {
		$price=$val['price'];
		if ($val['promo_price']>0){
			$price=$val['promo_price'];
		}
		if ( $val['expiration_type']=="year"){
			$expiration= $val['expiration']/365;
		} else $expiration=$val['expiration'];
		?>
		<li  style="list-style:none;margin-bottom:5px;">
		<div class="uk-panel uk-panel-box uk-width-medium-1-2">
		<p class="uk-text-bold"><?php echo $val['title']?> (<?php echo Yii::app()->functions->adminCurrencySymbol().standardPrettyFormat($price)?>)</p>
		
		<p class="uk-text-warning"><?php echo Yii::t("default","Membership Limit")?> <?php echo $expiration;?> <?php echo $val['expiration_type']?></p>
		
		<?php if ( $val['sell_limit'] <=0):?>
		<p class="uk-text-muted"><?php echo Yii::t("default","Sell limit")?> : <?php echo Yii::t("default","Unlimited")?></p>
		<?php else :?>
		<p class="uk-text-muted"><?php echo Yii::t("default","Sell limit")?> : <?php echo $val['sell_limit']?></p>
		<?php endif;?>
		
	
		<p class="uk-text-muted"><?php echo Yii::t("default","Take this package")?> <?php echo CHtml::radioButton('package_id',false,
		array('class'=>"icheck",'value'=>$val['package_id']))?></p>
		</div>
		</li>
		<?php
	}
}
?>
</ul>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Purchase")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>