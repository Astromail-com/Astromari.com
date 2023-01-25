<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:43
  from '/var/www/vhosts/astromari.com/httpdocs/themes/classic/templates/_partials/helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c734ceb9_58952877',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '016fe3d53ba9fed3147676151a1b0c058d4398cf' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/themes/classic/templates/_partials/helpers.tpl',
      1 => 1674329222,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d089c734ceb9_58952877 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => '/var/www/vhosts/astromari.com/httpdocs/var/cache/prod/smarty/compile/classiclayouts_layout_full_width_tpl/01/6f/e3/016fe3d53ba9fed3147676151a1b0c058d4398cf_2.file.helpers.tpl.php',
    'uid' => '016fe3d53ba9fed3147676151a1b0c058d4398cf',
    'call_name' => 'smarty_template_function_renderLogo_32335442263d089c73495c6_91318280',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_32335442263d089c73495c6_91318280 */
if (!function_exists('smarty_template_function_renderLogo_32335442263d089c73495c6_91318280')) {
function smarty_template_function_renderLogo_32335442263d089c73495c6_91318280(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['index'], ENT_QUOTES, 'UTF-8');?>
">
    <img
      class="logo img-fluid"
      src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['src'], ENT_QUOTES, 'UTF-8');?>
"
      alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
      width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['width'], ENT_QUOTES, 'UTF-8');?>
"
      height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['height'], ENT_QUOTES, 'UTF-8');?>
">
  </a>
<?php
}}
/*/ smarty_template_function_renderLogo_32335442263d089c73495c6_91318280 */
}
