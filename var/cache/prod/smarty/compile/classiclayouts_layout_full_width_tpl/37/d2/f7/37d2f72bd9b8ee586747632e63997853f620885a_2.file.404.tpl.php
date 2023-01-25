<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:43
  from '/var/www/vhosts/astromari.com/httpdocs/modules/creativeelements/views/templates/front/theme/errors/404.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c731e198_19306710',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37d2f72bd9b8ee586747632e63997853f620885a' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/modules/creativeelements/views/templates/front/theme/errors/404.tpl',
      1 => 1674333469,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d089c731e198_19306710 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
if ((isset($_smarty_tpl->tpl_vars['CE_PAGE_NOT_FOUND']->value))) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', $_smarty_tpl->tpl_vars['layout']->value);
} elseif (file_exists(((string)(defined('_PS_THEME_DIR_') ? constant('_PS_THEME_DIR_') : null))."templates/errors/404.tpl")) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', '[1]errors/404.tpl');
} elseif ((defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null)) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', 'parent:errors/404.tpl');
}?>



<?php if ((isset($_smarty_tpl->tpl_vars['CE_PAGE_NOT_FOUND']->value))) {?>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20038458963d089c731cca4_25572190', 'content');
?>

<?php }
$_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['ce_layout']->value);
}
/* {block 'content'} */
class Block_20038458963d089c731cca4_25572190 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_20038458963d089c731cca4_25572190',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<section id="content"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'cefilter' ][ 0 ], array( $_smarty_tpl->tpl_vars['CE_PAGE_NOT_FOUND']->value )), ENT_QUOTES, 'UTF-8');?>
</section>
	<?php
}
}
/* {/block 'content'} */
}
