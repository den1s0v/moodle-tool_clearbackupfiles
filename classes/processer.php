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

namespace tool_clearbackupfiles;

/**
 * Handles the deletion of backup files.
 *
 * @package    tool_clearbackupfiles
 * @copyright  2015 Shubhendra Doiphode
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class processer {

    /**
     * @var array Contains the deleted files.
     */
    private $deletedfiles = [];

    /**
     * @var int The total size of deleted files in bytes
     */
    private $totalfilesize = 0;

    /**
     * Erases the backup files.
     *
     * @return void
     */
    public function execute() {

        $toolconfig = get_config('tool_clearbackupfiles');
        $days = $toolconfig->days;
        $minmbytes = $toolconfig->minmbytes;

        $backupfiles = $this->get_backup_files($days, $minmbytes);

        if (!$backupfiles) {
            return null;
        }

        $filestorage = get_file_storage();

        foreach ($backupfiles as $filedata) {
            $backupfile = $filestorage->get_file_by_hash($filedata->pathnamehash);
            $backupfile->delete();

            $file = new \stdClass();
            $file->name = $backupfile->get_filename();
            $file->size = $backupfile->get_filesize();

            $this->deletedfiles[] = $file;
            $this->totalfilesize += $file->size;

            \tool_clearbackupfiles\event\coursebackup_removed::create(['other' => [
                'filename' => $file->name,
                'filesize' => self::format_bytes($file->size),
            ]])->trigger();
        }

        \tool_clearbackupfiles\event\clearbackup_completed::create(['other' => [
            'filecount' => count($this->deletedfiles),
            'filesize' => self::format_bytes($this->totalfilesize),
        ]])->trigger();
    }

    /**
     * Counts quantity and total size of backup files can be deleted with current settings.
     *
     * @return string
     */
    public function count_files_to_be_processed() {

        $toolconfig = get_config('tool_clearbackupfiles');
        $days = $toolconfig->days;
        $minmbytes = $toolconfig->minmbytes;

        $backupfiles = $this->get_backup_files($days, $minmbytes);

        if (!$backupfiles) {

            return get_string('nofiles', 'tool_clearbackupfiles');
        }

        $totalfilesize = 0;
        foreach ($backupfiles as $filedata) {

            $totalfilesize += $filedata->filesize;
        }

        $filecount = count($backupfiles);
        $totalsizestr = self::format_bytes($totalfilesize);

        return get_string('filecountsize', 'tool_clearbackupfiles', ['count' => $filecount, 'totalsize' => $totalsizestr]);
    }

    /**
     * Returns the information of the deleted files.
     *
     * @return array An array of stdClass objects
     */
    public function get_deleted_files() {
        return $this->deletedfiles;
    }

    /**
     * Returns the total size of the deleted files in bytes
     *
     * @return int
     */
    public function get_total_file_size() {
        return $this->totalfilesize;
    }

    /**
     * Returns the backup files that are older than $days days
     * but not smaller than $minmbytes megabytes.
     *
     * @param int $days
     * @param int $minmbytes
     * @return array
     */
    private function get_backup_files($days, $minmbytes) {
        global $DB;

        // Calculate the timestamp for the cutoff date.
        $cutofftimestamp = time() - ($days * 24 * 60 * 60);
        $min_bytes = $minmbytes * 1024 * 1024;

        // Fetch files from the last specified number of days.
        $sql = "SELECT * FROM {files} WHERE mimetype LIKE '%backup%' AND timecreated <= :cutofftimestamp AND filesize >= :min_bytes";
        $params = ['cutofftimestamp' => $cutofftimestamp, 'min_bytes' => $min_bytes];

        $backupfiles = $DB->get_records_sql($sql, $params);
        return $backupfiles;
    }

    /**
     * Formats file size values into a human-readable form.
     *
     * @param int $size The file size in bytes
     * @param int $precision The number of digits to round to
     * @return float The human-readable file size
     */
    public static function format_bytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }
}
