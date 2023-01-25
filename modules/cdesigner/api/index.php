<?php
require_once('../../../config/config.inc.php');
require_once('../../../init.php');
	$code = Tools::getValue('code');
	if(isset($code)) {
		$url = 'https://api.instagram.com/oauth/access_token';
		$access_token_parameters = array(
		        'client_id'                =>     Configuration::get('client_id'),
		        'client_secret'                =>     Configuration::get('client_secret'),
		        'grant_type'                =>     'authorization_code',
		        'redirect_uri'                =>     Configuration::get('redirect_URI'),
		        'code'                        =>     $code
		);

		
		$curl = curl_init($url);
		curl_setopt($curl,CURLOPT_POST,true);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$access_token_parameters);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		$arr = json_decode($result,true);
		$pictureURL = 'https://api.instagram.com/v1/users/'.$arr['user']['id'].'/media/recent?access_token='.$arr['access_token'];
		// to get the user's photos
		$curl = curl_init($pictureURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$pictures = curl_exec($curl);
		curl_close($curl);

		$pics = json_decode($pictures,true);
		?>
	    
		<ul class="results-ins" style="display:none">
		<?php 
			for($i=0;$i<count($pics['data']);$i++){
				$url = $pics['data'][$i]['images']['standard_resolution']['url'];
			?>
				<li class="from-instagram">
					<a href="<?php echo $url?>" class="frominsta" style="background-image:url(<?php echo $url?>)">
						<img src="<?php echo $url;?>"/>
						<i class="fa fa-plus"></i>
					</a>
				</li>
			<?php 
				}
			?>
		</ul>
		<?php } ?>
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script>
		window.opener.jQuery('#cp-sel-Photos ul').prepend( jQuery('.results-ins').html() );
		window.opener.jQuery(window).load(function() {
			window.opener.jQuery('#btn-instagram').remove();
			window.opener.jQuery('.lst-tags a').removeClass('active');
			window.opener.jQuery('#from-instagram').show();
			window.opener.jQuery('#from-instagram').addClass('active');
			window.opener.jQuery('.lst-img li').hide();
			window.opener.jQuery('.lst-tags a.active').closest('.lst-img').find('li.'+ window.opener.jQuery('.lst-tags a.active').attr('id')).fadeIn('pretty');
	  		window.close();
		});
	</script>