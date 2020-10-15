<?php
/**
 * @package    local
 * @subpackage up1_notification
 * @copyright  2012-2016 Silecs {@link http://www.silecs.info/societe}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_up1_notification_extend_navigation() {
    global $OUTPUT, $PAGE, $DB;
    
    $pages = ['/mod/feedback/edit.php', '/mod/feedback/view.php', 
		'/mod/feedback/analysis.php', '/mod/feedback/show_entries.php', 
		'/local/up1_notification/notification.php'];
	if ($PAGE->has_set_url() && in_array($PAGE->url->get_path(), $pages)) {
		$classa = 'nav-link';
		if ($PAGE->url->get_path() === '/local/up1_notification/notification.php') {
			$classa .= ' active';
		}
		if ($DB->get_records('config_plugins', array('plugin' => 'local_up1_notification'))) {
			$id = $PAGE->url->get_param('id');
			$lien = new moodle_url('/local/up1_notification/notification.php', ['id' => $id]);
			$linktab = '<li class="nav-item"><a href="' . htmlspecialchars($lien)
				. '" class="' . $classa . '"' . ' title="' . htmlspecialchars(get_string("notifications")) . '">'
				. htmlspecialchars(get_string("notifications")) . '</a></li>';
		
			//style Boost
			$enc = json_encode($linktab);
			$PAGE->requires->js_init_code(<<<EOJS
   
    var onglets = document.querySelectorAll('#region-main div[role="main"] ul.nav');
    if (onglets) {
		for (var i = 0; i < onglets.length; i++) {
			var ul = onglets[i];
			ul.insertAdjacentHTML('beforeend', $enc);
		}
    }   
EOJS
    , true);
		
		}
	}
}

