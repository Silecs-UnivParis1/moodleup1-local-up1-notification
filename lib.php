<?php
/**
 * @package    local
 * @subpackage up1_notification
 * @copyright  2012-2016 Silecs {@link http://www.silecs.info/societe}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_up1_notification_extend_navigation() {
    global $OUTPUT, $PAGE, $DB;
    if ($PAGE->theme->name == 'boost') {
        $pages = ['/mod/feedback/edit.php', '/mod/feedback/view.php', 
            '/mod/feedback/analysis.php', '/mod/feedback/show_entries.php',
            '/mod/feedback/manage_templates.php', 
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
                    . '" class="' . $classa . '"' 
                    . ' title="' . htmlspecialchars(get_string("notifications")) 
                    . '" role="menuitem">'
                    . htmlspecialchars(get_string("notifications")) . '</a></li>';
            
                $enc = json_encode($linktab);
                $PAGE->requires->js_init_code(<<<EOJS
               
        var ongletrep = document.querySelectorAll('#topofscroll div.secondary-navigation ul[role="menubar"] li[data-key="responses"]');
        if (ongletrep) {
            var li = ongletrep[0];
            li.insertAdjacentHTML('afterend', $enc);
        }   
EOJS
        , true);
            
            }
        }
    } else if ($PAGE->theme->name == 'adaptable') {
        $pages = ['/mod/feedback/view.php'];
        if ($PAGE->has_set_url() && in_array($PAGE->url->get_path(), $pages)) {
             if ($DB->get_records('config_plugins', array('plugin' => 'local_up1_notification'))) {
                $id = $PAGE->url->get_param('id');
                $lien = new moodle_url('/local/up1_notification/notification.php', ['id' => $id]);
                $classa = 'btn btn-secondary';
                $linktab = '<li class="navitem"><a href="' . htmlspecialchars($lien)
                    . '" class="' . $classa . '"' 
                    . ' title="' . htmlspecialchars(get_string("notifications")) 
                    . '" role="menuitem">'
                    . htmlspecialchars(get_string("notifications")) . '</a></li>';
            
                $enc = json_encode($linktab);
                $PAGE->requires->js_init_code(<<<EOJS
            var boutons = document.querySelectorAll('#region-main div[role="main"] div.tertiary-navigation div.row');
            if (boutons) {
                var barreb = boutons[0];
                barreb.insertAdjacentHTML('beforeend', $enc);
            }
        
EOJS
        , true);
            }
        }
    }
}

