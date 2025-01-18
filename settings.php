<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin settings page definition.
 *
 * @package    tool_clearbackupfiles
 * @copyright  2015 Shubhendra Doiphode
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // Create the new settings page.
    $settings = new admin_settingpage('tool_clearbackupfiles', get_string('pluginname', 'tool_clearbackupfiles'));


    if (($showreport = get_config('tool_clearbackupfiles', 'showreportinsettings')) > 0) {
        // Show report here.
        $processer = new processer();
        $count_string = $processer->count_files_to_be_processed();
        $report_string = get_string('filecountsizereport', 'tool_clearbackupfiles', $count_string);

        // Add information as a heading.
        $settings->add(new admin_setting_heading(
            'tool_clearbackupfiles/report',
            get_string('reportheading', 'tool_clearbackupfiles') . ': '. $report_string,
            ''
        ));
    }


    // Add a setting for a numeric input field.
    $settings->add(new admin_setting_configtext(
        'tool_clearbackupfiles/days', // This is the setting name.
        get_string('days', 'tool_clearbackupfiles'), // This is the setting title.
        get_string('daysdesc', 'tool_clearbackupfiles'), // This is the setting description.
        5, // Default value.
        PARAM_INT // Type of the parameter.
    ));

    // Add a setting for a numeric input field.
    $settings->add(new admin_setting_configtext(
        'tool_clearbackupfiles/minmbytes', // This is the setting name.
        get_string('minmbytes', 'tool_clearbackupfiles'), // This is the setting title.
        get_string('minmbytesdesc', 'tool_clearbackupfiles'), // This is the setting description.
        0, // Default value.
        PARAM_INT // Type of the parameter.
    ));

    // Add a checkbox for enabling/disabling CRON.
    $settings->add(new admin_setting_configcheckbox(
        'tool_clearbackupfiles/enablecron', // This is the setting name.
        get_string('enablecron', 'tool_clearbackupfiles'), // This is the setting title.
        get_string('enablecrondesc', 'tool_clearbackupfiles'), // This is the setting description.
        0 // Default value (0 for unchecked, 1 for checked).
    ));

    // Add the anchor tag that opens in a new tab and is styled as a button.
    $settings->add(new admin_setting_heading(
        'tool_clearbackupfiles/buttonheading',
        '',
        html_writer::link(
            new moodle_url('/admin/tool/clearbackupfiles/index.php'),
            get_string('continuetoclearbackup', 'tool_clearbackupfiles'),
            ['class' => 'btn btn-primary', 'target' => '_blank']
        )
    ));


    $options = array(
        0 => get_string('reportdisabled', 'tool_clearbackupfiles'),
        // 2 => get_string('reportonce', 'tool_clearbackupfiles'),
        1 => get_string('reportalways', 'tool_clearbackupfiles')
    );
    $settings->add(new admin_setting_configselect(
        'tool_clearbackupfiles/showreportinsettings',
        get_string('showreportinsettings', 'tool_clearbackupfiles'),
        get_string('showreportinsettingsdesc', 'tool_clearbackupfiles'),
        0,
        $options
    ));


    // Add the settings page to the tools category.
    $ADMIN->add('tools', $settings);
}
