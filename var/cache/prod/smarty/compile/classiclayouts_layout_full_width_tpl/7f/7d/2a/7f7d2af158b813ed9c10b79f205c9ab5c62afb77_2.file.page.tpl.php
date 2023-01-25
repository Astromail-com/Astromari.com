<?php
/* Smarty version 3.1.47, created on 2023-01-24 20:45:43
  from '/var/www/vhosts/astromari.com/httpdocs/themes/classic/templates/page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_63d089c732ec50_93991227',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f7d2af158b813ed9c10b79f205c9ab5c62afb77' => 
    array (
      0 => '/var/www/vhosts/astromari.com/httpdocs/themes/classic/templates/page.tpl',
      1 => 1674329222,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d089c732ec50_93991227 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14257676663d089c732ac01_92949649', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_37682203463d089c732b5a0_78836210 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_18275092363d089c732b076_36435548 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_37682203463d089c732b5a0_78836210', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_79861246063d089c732cdb6_12886798 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_114867902563d089c732d450_50992630 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_101072188463d089c732c970_58944155 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <div id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_79861246063d089c732cdb6_12886798', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_114867902563d089c732d450_50992630', 'page_content', $this->tplIndex);
?>

      </div>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_23827859563d089c732e160_47854679 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_169712691563d089c732dd99_16681404 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_23827859563d089c732e160_47854679', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_14257676663d089c732ac01_92949649 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_14257676663d089c732ac01_92949649',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_18275092363d089c732b076_36435548',
  ),
  'page_title' => 
  array (
    0 => 'Block_37682203463d089c732b5a0_78836210',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_101072188463d089c732c970_58944155',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_79861246063d089c732cdb6_12886798',
  ),
  'page_content' => 
  array (
    0 => 'Block_114867902563d089c732d450_50992630',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_169712691563d089c732dd99_16681404',
  ),
  'page_footer' => 
  array (
    0 => 'Block_23827859563d089c732e160_47854679',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18275092363d089c732b076_36435548', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_101072188463d089c732c970_58944155', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_169712691563d089c732dd99_16681404', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
