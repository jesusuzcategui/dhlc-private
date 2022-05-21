<?php
use Core\Jdev;
use Core\Config;
use App\helpers\Functions;
	$configuration = Jdev::getConfig();
?>
<!DOCTYPE html>
<html lang="ES">
	<head>
		<title><?php echo Config::AppName; ?> | <?php echo isset($title_head) ? $title_head : ''; ?></title>
        <base href="<?php echo (Functions::isLocal()) ? Config::AppUrl['dev'] : Config::AppUrl['web']; ?>">
		<meta charset="utf-8"/>
		<meta name="description" content="<?php echo Config::AppDesc; ?>"/>
		<meta name="keyswords" content="<?php echo Config::AppKeyword; ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" href="https://locutorios.cl/comprapin/images/favicon.png" sizes="192x192" />
		<!--CSS-->
		<?php echo $css; ?>
		<!--JAVASCRIPT-->
		<?php echo $js; ?>
		
		<!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W8DGRCF');</script>
        <!-- End Google Tag Manager -->
        
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8DGRCF"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->


		<!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '600900951051353');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=600900951051353&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->

	</head>
	<body>
		<div id="page-wrapper">
