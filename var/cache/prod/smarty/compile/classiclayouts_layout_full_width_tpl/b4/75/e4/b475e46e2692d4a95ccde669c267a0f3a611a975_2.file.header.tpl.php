<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:43
  from '/var/www/vhosts/astromari.com/httpdocs/modules/creativeelements/views/templates/front/theme/_partials/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c7399c41_31793424',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b475e46e2692d4a95ccde669c267a0f3a611a975' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/modules/creativeelements/views/templates/front/theme/_partials/header.tpl',
      1 => 1674333469,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:[1]_partials/header.tpl' => 1,
    'parent:_partials/header.tpl' => 1,
  ),
),false)) {
function content_63d089c7399c41_31793424 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['CE_HEADER']->value))) {?>
	<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'cefilter' ][ 0 ], array( $_smarty_tpl->tpl_vars['CE_HEADER']->value )), ENT_QUOTES, 'UTF-8');?>

<?php } elseif (file_exists(((string)(defined('_PS_THEME_DIR_') ? constant('_PS_THEME_DIR_') : null))."templates/_partials/header.tpl")) {?>
	<?php $_smarty_tpl->_subTemplateRender('file:[1]_partials/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ((defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null)) {?>
	<?php $_smarty_tpl->_subTemplateRender('parent:_partials/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
}
