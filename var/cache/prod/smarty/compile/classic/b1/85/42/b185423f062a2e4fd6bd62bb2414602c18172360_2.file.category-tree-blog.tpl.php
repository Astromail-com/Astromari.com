<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:42
  from '/var/www/vhosts/astromari.com/httpdocs/modules/ybc_blog/views/templates/hook/category-tree-blog.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c673a024_19277746',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b185423f062a2e4fd6bd62bb2414602c18172360' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/modules/ybc_blog/views/templates/hook/category-tree-blog.tpl',
      1 => 1674333425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d089c673a024_19277746 (Smarty_Internal_Template $_smarty_tpl) {
?><li style="list-style: none; position: relative;">
    <input style="margin: 2px 7px 0 0; float: left;" type="checkbox" <?php if (in_array($_smarty_tpl->tpl_vars['node']->value['id_category'],$_smarty_tpl->tpl_vars['disabled_categories']->value)) {?>disabled="disabled"<?php } else {
if (in_array($_smarty_tpl->tpl_vars['node']->value['id_category'],$_smarty_tpl->tpl_vars['selected_categories']->value)) {?> checked="checked"<?php }
}?> value="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['node']->value['id_category'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['name']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
[]" id="ybc_input_blog_category_<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['node']->value['id_category'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" /><label for="ybc_input_blog_category_<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['node']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
"><?php if ((isset($_smarty_tpl->tpl_vars['node']->value['thumb_link']))) {
echo $_smarty_tpl->tpl_vars['node']->value['thumb_link'];?>
&nbsp;<?php }
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['node']->value['title'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</label>
    <?php if (count($_smarty_tpl->tpl_vars['node']->value['children']) > 0) {?>
            <span class="category-blog-parent">click</span>
        		<ul class="children">
        		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['node']->value['children'], 'child', false, NULL, 'categoryTreeBranch', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['child']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
$_smarty_tpl->tpl_vars['child']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['total'];
?>
                     
        			<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categoryTreeBranch']->value['last'] : null)) {?>
        				<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['branche_tpl_path_input']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'last'=>'true'), 0, true);
?>
        			<?php } else { ?>
        				<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['branche_tpl_path_input']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'last'=>'false'), 0, true);
?>
        			<?php }?>
        		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    		</ul>
   	<?php }?>
    <input type="radio" name="main_category" class="category_default" value="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['node']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['id_category'] == $_smarty_tpl->tpl_vars['id_category_default']->value) {?> checked="checked"<?php }?> />   
</li>
                       <?php }
}
