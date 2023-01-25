<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:42
  from '/var/www/vhosts/astromari.com/httpdocs/modules/ets_affiliatemarketing/views/templates/hook/head.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c6752bf9_76127416',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f783aaa6d12553b3cbdfd53dd0b5cd874f64d2f3' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/modules/ets_affiliatemarketing/views/templates/hook/head.tpl',
      1 => 1674400252,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d089c6752bf9_76127416 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['og_url']->value))) {?>
	<meta property="og:url"                content="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['og_url']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
<?php }
if ((isset($_smarty_tpl->tpl_vars['og_type']->value))) {?>
	<meta property="og:type"               content="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['og_type']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
<?php }
if ((isset($_smarty_tpl->tpl_vars['og_title']->value))) {?>
	<meta property="og:title"              content="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['og_title']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
<?php }
if ((isset($_smarty_tpl->tpl_vars['og_description']->value))) {?>
	<meta property="og:description"        content="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['og_description']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
<?php }
if ((isset($_smarty_tpl->tpl_vars['og_image']->value))) {?>
	<meta property="og:image"              content="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['og_image']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript">
    <?php if ((isset($_smarty_tpl->tpl_vars['link_cart']->value))) {?>
    var link_cart = "<?php echo $_smarty_tpl->tpl_vars['link_cart']->value;?>
";
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['link_reward']->value))) {?>
    var link_reward = "<?php echo $_smarty_tpl->tpl_vars['link_reward']->value;?>
";
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['link_shopping_cart']->value))) {?>
    var link_shopping_cart = "<?php echo $_smarty_tpl->tpl_vars['link_shopping_cart']->value;?>
";
    <?php }?>
    <?php if ((isset($_smarty_tpl->tpl_vars['ets_am_product_view_link']->value))) {?>
        var ets_am_product_view_link = '<?php echo $_smarty_tpl->tpl_vars['ets_am_product_view_link']->value;?>
';
        var eam_id_seller = '<?php echo $_smarty_tpl->tpl_vars['eam_id_seller']->value;?>
';
    <?php }?>
    var eam_sending_email = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sending...','mod'=>'ets_affiliatemarketing'),$_smarty_tpl ) );?>
";
    var eam_email_invalid = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email is invalid','mod'=>'ets_affiliatemarketing'),$_smarty_tpl ) );?>
";
    var eam_email_sent_limited = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You have reached the maximum number of invitation','mod'=>'ets_affiliatemarketing'),$_smarty_tpl ) );?>
";
    var eam_token = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['_token']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";
    var name_is_blank = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name is required','mod'=>'ets_affiliatemarketing','js'=>'1'),$_smarty_tpl ) );?>
';
    var email_is_blank = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email is required','mod'=>'ets_affiliatemarketing','js'=>'1'),$_smarty_tpl ) );?>
';
    var email_is_invalid = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email is invalid','mod'=>'ets_affiliatemarketing','js'=>'1'),$_smarty_tpl ) );?>
';
<?php echo '</script'; ?>
>
<?php }
}
