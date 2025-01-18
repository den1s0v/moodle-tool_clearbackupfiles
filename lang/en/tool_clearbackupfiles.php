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
 * English language strings
 *
 * @package    tool_clearbackupfiles
 * @copyright  2015 Shubhendra Doiphode
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['backupcompletedlog'] = 'During this operation {$a->filecount} course backup files of total size {$a->filesize} were deleted.';
$string['backupremovedlog'] = 'Course backup file {$a->filename} of size {$a->filesize} was deleted.';

$string['clearbackupcompleted'] = 'Clear backup completed';
$string['continuetoclearbackup'] = 'Continue to clear backup';
$string['coursebackupremoved'] = 'Course backup deleted';
$string['crontask'] = 'Clear backup (.mbz) files task';

$string['days'] = 'Days';
$string['daysdesc'] = 'Number of days of backup to clear';

$string['enablecron'] = 'Enable CRON';
$string['enablecrondesc'] = '';

$string['filecountsize'] = '{$a->count} files with a total size of {$a->totalsize}';
$string['filecountsizereport'] = 'Backup files can be deleted with current settings: {$a}';

$string['filedeletedempty'] = 'There are no backup files to delete.';
$string['filedeletedfooter'] = 'In total {$a->filecount} backup files were deleted and {$a->filesize} of server space was cleared.';
$string['filedeletedheader'] = 'The course backup files deleted during this operation are as follows:';
$string['filename'] = 'File name';
$string['filesize'] = 'File size';


$string['minmbytes'] = 'Minimum MBytes';
$string['minmbytesdesc'] = 'Minimum size (in megabytes) of backup file to drop. The dafault `0` is to remove all old backups. Use a positive value this to keep some small but important backups permanently.';

$string['nofiles'] = 'no files';

$string['pluginname'] = 'Clear backup files';

$string['reportalways'] = 'Always';
$string['reportdisabled'] = 'Never';
$string['reportheading'] = 'Brief report';
$string['showreportinsettings'] = 'Show brief report on top of this page';
$string['showreportinsettingsdesc'] = 'Show brief report on the number & size of backup files that can be removed with current settings';

$string['warningalert'] = 'Are you sure you want to continue?';
$string['warningmsg'] = 'Please note, clearing of backup files is an irreversible process, you will not be able to restore deleted backup files.';
