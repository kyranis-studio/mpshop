<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:04
  from '/home/mpshop/public_html/modules/mp_shift_clock/views/templates/hook/clock.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842ce6f700_01941415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9997d23b09e31e0217f6e5105cbd1a037ec4edcb' => 
    array (
      0 => '/home/mpshop/public_html/modules/mp_shift_clock/views/templates/hook/clock.tpl',
      1 => 1644593552,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842ce6f700_01941415 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="mp-footer">
	<div id="shift-plan-fr" >
		<h1 style="text-align:center;font-size:32px">Horaires de travaille</h1>
		<div>
			<h1 style="text-align:center">Lundi - <?php if (!$_smarty_tpl->tpl_vars['doubleShift']->value) {?>Samedi<?php } else { ?>Vendredi<?php }?></h1>
		</div>
		<div>
			<h3 style="text-align:center">
			<span class="first-shift" style="color:#009fe3"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['firstShift']->value, ENT_QUOTES, 'UTF-8');?>
 </span><br> 
			<?php if ($_smarty_tpl->tpl_vars['doubleShift']->value) {?>
			<span class="pause-shift" style="color:#be1622"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pause']->value, ENT_QUOTES, 'UTF-8');?>
 </span><br>
			<span class="second-shift" style="color:#009fe3"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['secondShift']->value, ENT_QUOTES, 'UTF-8');?>
 </span>
			<?php }?>
			
			</h3>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['doubleShift']->value) {?>
		<div>
			<h1 style="text-align:center">Samedi</h1>
		</div>
		<div>
			<h3 class="saturday-shift" style="text-align:center;color:#009fe3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['saturdayShift']->value, ENT_QUOTES, 'UTF-8');?>
</h3>
		</div>
		<?php }?>
	</div>
	<div id="mp-shift" >
		<div >
			<h1 id="mp-open"  style="text-align:center;margin-bottom: 30px"><i class="fa fa-clock-o" style="color:#009fe3"></i> La boutique est ouvert</h1>
			<h1 id="mp-close" style="text-align:center;margin-bottom: 30px"><i class="fa fa-clock-o" style="color:#be1622"></i> La boutique est fermée</h1>
		</div>
		<ul id="clock" class="clock-bg <?php if ($_smarty_tpl->tpl_vars['doubleShift']->value && !$_smarty_tpl->tpl_vars['saturday']->value && !$_smarty_tpl->tpl_vars['sunday']->value) {?>double-seance<?php } else { ?> one-seance <?php if ($_smarty_tpl->tpl_vars['sunday']->value) {?>sunday<?php }?> <?php }?>" style="--fs-start-deg:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fsStartDeg']->value, ENT_QUOTES, 'UTF-8');?>
;--pause-start-deg:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pauseStartDeg']->value, ENT_QUOTES, 'UTF-8');?>
;--ss-start-deg:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ssStartDeg']->value, ENT_QUOTES, 'UTF-8');?>
;--pause-start-prog:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pauseStartProg']->value, ENT_QUOTES, 'UTF-8');?>
;--pause-end-prog:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pauseEndProg']->value, ENT_QUOTES, 'UTF-8');?>
;--ss-end-prog:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ssEndShiftProg']->value, ENT_QUOTES, 'UTF-8');?>
;">	
			<li><img src="/modules/mp_shift_clock/views/img/clock.png" class="pause" style="z-index: 1;position: absolute;" width="300px" height="300px"></li>
			<li id="sec"></li>
			<li id="hour"><span class="time-marker"></span> <div class="pointer"><i class="icon icon-arrow-up-solid" style="margin-left: -9.3px;margin-top: -10px;position: absolute;"></i></div></li>
			<li id="min"></li>
		</ul>
		<h3 id="mp-message" style="text-align:center;margin-top:20px"></h3>
		<div style="text-align:center;background:#009fe3;margin:auto;color:white;width:100%;padding:10px;">Temps de travaille - أوقات العمل</div>
		<div style="text-align:center;background:#be1622;margin:auto;color:white;width:100%;padding:10px;margin-bottom: 10px;">Pause - راحة</div>
	</div>
	<div id="shift-plan-ar" >
		<h1 style="text-align:center;font-size:36px">أوقات العمل</h1>
		<div>
			<h1 style="text-align:center">الإثنين-<?php if (!$_smarty_tpl->tpl_vars['doubleShift']->value) {?>السبت<?php } else { ?>الجمعة<?php }?></h1>
		</div>
		<div>
			<h3 style="text-align:center">
			<span class="first-shift" style="color:#009fe3"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['firstShift']->value, ENT_QUOTES, 'UTF-8');?>
 </span><br>
			<?php if ($_smarty_tpl->tpl_vars['doubleShift']->value) {?>
			<span class="pause-shift" style="color:#be1622"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pause']->value, ENT_QUOTES, 'UTF-8');?>
 </span><br>
			<span class="second-shift" style="color:#009fe3"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['secondShift']->value, ENT_QUOTES, 'UTF-8');?>
 </span>
			<?php }?>
			
			</h3>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['doubleShift']->value) {?>
		<div>
			<h1 style="text-align:center">السبت</h1>
		</div>
		<div >
			<h3 class="saturday-shift" style="text-align:center;color:#009fe3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['saturdayShift']->value, ENT_QUOTES, 'UTF-8');?>
</h3>
		</div>
		<?php }?>
				
	</div>
</div><?php }
}
