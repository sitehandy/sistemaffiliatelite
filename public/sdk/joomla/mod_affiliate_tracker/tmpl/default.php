<?php
/**
 * @package     Joomla.Module
 * @subpackage  mod_affiliate_tracker
 */

defined('_JEXEC') or die;

$jsConfig = $helper->getJsConfig();
?>
<script>
window.AffiliateTrackerConfig = <?php echo $jsConfig; ?>;
</script>
