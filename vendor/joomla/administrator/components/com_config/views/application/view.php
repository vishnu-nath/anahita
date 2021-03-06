<?php
/**
 * @version		$Id: view.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Config
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		Joomla
* @subpackage	Config
*/
class ConfigApplicationView
{
	public static function showConfig( &$row, &$lists )
	{
		global $mainframe;

		

		// Load component specific configurations
		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_users' );
		$userparams = new JParameter( $table->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_users'.DS.'config.xml' );		

		// Build the component's submenu
		$contents = '';
		$tmplpath = dirname(__FILE__).DS.'tmpl';
		ob_start();
		require_once($tmplpath.DS.'navigation.php');
		$contents = ob_get_contents();
		ob_end_clean();

		// Load settings for the FTP layer
		jimport('joomla.client.helper');
		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		?>
		<form action="index.php" method="post" name="adminForm" autocomplete="off">
		<?php if ($ftp) {
			require_once($tmplpath.DS.'ftp.php');
		} ?>
		<div id="config-document">
			<div id="page-site">
				<table class="noshow">
					<tr>
						<td width="66%">
							<?php require_once($tmplpath.DS.'config_site.php'); ?>
						</td>
						<td width="36%">
							<?php require_once($tmplpath.DS.'config_seo.php'); ?>
						</td>
					</tr>
				</table>
			</div>
			<div id="page-system">
				<table class="noshow">
					<tr>
						<td width="66%">
							<?php require_once($tmplpath.DS.'config_system.php'); ?>
							<fieldset class="adminform">
								<legend><?php echo JText::_( 'User Settings' ); ?></legend>
								<?php echo $userparams->render('userparams'); ?>
							</fieldset>							
						</td>
						<td width="33%">
							<?php require_once($tmplpath.DS.'config_debug.php'); ?>
							<?php require_once($tmplpath.DS.'config_cache.php'); ?>
							<?php require_once($tmplpath.DS.'config_session.php'); ?>
						</td>
					</tr>
				</table>
			</div>
			<div id="page-server">
				<table class="noshow">
					<tr>
						<td width="65%">
							<?php require_once($tmplpath.DS.'config_server.php'); ?>
							<?php require_once($tmplpath.DS.'config_locale.php'); ?>
							
						</td>
						<td width="35%">
							<?php require_once($tmplpath.DS.'config_database.php'); ?>
							<?php require_once($tmplpath.DS.'config_mail.php'); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="c" value="global" />
		<input type="hidden" name="live_site" value="<?php echo isset($row->live_site) ? $row->live_site : ''; ?>" />
		<input type="hidden" name="option" value="com_config" />
		<input type="hidden" name="secret" value="<?php echo $row->secret; ?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}

	public static function WarningIcon()
	{
		return '';
	}
}
