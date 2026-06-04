<?php
/**
 * Application-wide timezone: Australian Central Standard Time (Adelaide).
 * All PHP date/time functions and MySQL session use this zone — not the logged-in user's locale.
 */
if (!defined('CRM_APP_TIMEZONE')) {
    define('CRM_APP_TIMEZONE', 'Australia/Adelaide');
    define('CRM_APP_TIMEZONE_LABEL', 'ACST (Adelaide)');
    define('CRM_APP_TIMEZONE_STATE', 'Adelaide');
}

if (!function_exists('crm_app_timezone_init')) {
    function crm_app_timezone_init()
    {
        date_default_timezone_set(CRM_APP_TIMEZONE);
    }

    function crm_app_now($format = 'Y-m-d H:i:s')
    {
        return (new DateTime('now', new DateTimeZone(CRM_APP_TIMEZONE)))->format($format);
    }

    function crm_app_today($format = 'Y-m-d')
    {
        return crm_app_now($format);
    }

    function crm_app_mysql_offset()
    {
        $offset = (new DateTime('now', new DateTimeZone(CRM_APP_TIMEZONE)))->getOffset();
        $sign = $offset < 0 ? '-' : '+';
        $offset = abs($offset);
        $h = (int) floor($offset / 3600);
        $m = (int) floor(($offset % 3600) / 60);
        return sprintf('%s%02d:%02d', $sign, $h, $m);
    }

    function crm_app_mysql_set_timezone($connection)
    {
        if (!$connection) {
            return;
        }
        $tz = crm_app_mysql_offset();
        @mysqli_query($connection, "SET time_zone = '" . mysqli_real_escape_string($connection, $tz) . "'");
    }

    /**
     * Interpret $dateYmd + $timeHm as Adelaide local time; return formatted string in $targetTz.
     */
    function crm_app_datetime_in_tz($dateYmd, $timeHm, $targetTz)
    {
        $dateYmd = trim((string) $dateYmd);
        $timeHm = trim((string) $timeHm);
        if ($dateYmd === '' || $timeHm === '') {
            return '';
        }
        $normalized = preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $timeHm) ? $timeHm : substr($timeHm, 0, 5);
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $dateYmd . ' ' . $normalized . ':00', new DateTimeZone(CRM_APP_TIMEZONE));
        if (!$dt) {
            $dt = DateTime::createFromFormat('Y-m-d H:i', $dateYmd . ' ' . substr($normalized, 0, 5), new DateTimeZone(CRM_APP_TIMEZONE));
        }
        if (!$dt) {
            return $dateYmd . ' ' . $normalized;
        }
        $dt->setTimezone(new DateTimeZone($targetTz));
        return $dt->format('Y-m-d H:i:s');
    }

    /**
     * Parse a MySQL datetime string as Adelaide local wall time.
     */
    function crm_app_parse_mysql_datetime($mysqlDatetime)
    {
        $mysqlDatetime = trim((string) $mysqlDatetime);
        if ($mysqlDatetime === '') {
            return null;
        }
        $tz = new DateTimeZone(CRM_APP_TIMEZONE);
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $mysqlDatetime, $tz);
        if (!$dt) {
            $dt = DateTime::createFromFormat('Y-m-d H:i', $mysqlDatetime, $tz);
        }
        if (!$dt) {
            try {
                $dt = new DateTime($mysqlDatetime, $tz);
            } catch (Exception $e) {
                return null;
            }
        }
        return $dt;
    }

    /** ISO 8601 with offset for FullCalendar / JSON APIs. */
    function crm_app_datetime_iso($mysqlDatetime)
    {
        $dt = crm_app_parse_mysql_datetime($mysqlDatetime);
        return $dt ? $dt->format(DateTime::ATOM) : (string) $mysqlDatetime;
    }

    function crm_app_format_time_display($mysqlDatetime)
    {
        $dt = crm_app_parse_mysql_datetime($mysqlDatetime);
        return $dt ? $dt->format('g:i A') : '';
    }

    function crm_app_format_datetime_display($mysqlDatetime, $format = 'd M Y g:i A')
    {
        $dt = crm_app_parse_mysql_datetime($mysqlDatetime);
        return $dt ? $dt->format($format) . ' (' . CRM_APP_TIMEZONE_LABEL . ')' : '';
    }

    function crm_app_is_date_before_today($dateYmd)
    {
        $dateYmd = trim((string) $dateYmd);
        return $dateYmd !== '' && $dateYmd < crm_app_today();
    }

    /** True if $dateYmd + $timeHm (Adelaide wall clock) is strictly before now in Adelaide. */
    function crm_app_is_past_datetime($dateYmd, $timeHm)
    {
        $dateYmd = trim((string) $dateYmd);
        $timeHm = trim((string) $timeHm);
        if ($dateYmd === '' || $timeHm === '') {
            return false;
        }
        if (preg_match('/^\d{1,2}:\d{2}$/', $timeHm)) {
            $timeHm .= ':00';
        }
        $dt = crm_app_parse_mysql_datetime($dateYmd . ' ' . $timeHm);
        if (!$dt) {
            $dt = crm_app_parse_mysql_datetime($dateYmd . ' ' . substr($timeHm, 0, 5));
        }
        if (!$dt) {
            return false;
        }
        $now = new DateTime('now', new DateTimeZone(CRM_APP_TIMEZONE));
        return $dt < $now;
    }

    function crm_app_datetime_compare($dateYmd, $timeHm)
    {
        $timeHm = trim((string) $timeHm);
        if (preg_match('/^\d{1,2}:\d{2}$/', $timeHm)) {
            $timeHm .= ':00';
        }
        return crm_app_parse_mysql_datetime(trim((string) $dateYmd) . ' ' . $timeHm);
    }

    /**
     * Normalise appointment range to Adelaide wall-clock MySQL datetimes (end defaults +1h if missing/invalid).
     *
     * @return array{start:string,end:string}|null
     */
    function crm_appointment_normalize_range($startDatetime, $endDatetime)
    {
        $startDt = crm_app_parse_mysql_datetime($startDatetime);
        if (!$startDt) {
            return null;
        }
        $endDt = crm_app_parse_mysql_datetime($endDatetime);
        if (!$endDt || $endDt <= $startDt) {
            $endDt = clone $startDt;
            $endDt->modify('+1 hour');
        }
        return array(
            'start' => $startDt->format('Y-m-d H:i:s'),
            'end' => $endDt->format('Y-m-d H:i:s'),
        );
    }

    /** SQL expression for appointment end (Adelaide datetimes stored in DB). */
    function crm_appointment_end_sql_expr($connection)
    {
        static $expr = null;
        if ($expr !== null) {
            return $expr;
        }
        $hasEndCol = mysqli_fetch_assoc(@mysqli_query($connection, "SHOW COLUMNS FROM appointments LIKE 'appointment_end_datetime'"));
        $expr = $hasEndCol
            ? "COALESCE(NULLIF(appointment_end_datetime, ''), DATE_ADD(appointment_datetime, INTERVAL 1 HOUR))"
            : 'DATE_ADD(appointment_datetime, INTERVAL 1 HOUR)';
        return $expr;
    }

    /**
     * Overlap: existing_start < new_end AND existing_end > new_start (Adelaide wall-clock in appointment_datetime columns).
     *
     * @return array<string,mixed>|null Conflicting row or null
     */
    function crm_appointment_find_overlap_conflict($connection, $startDatetime, $endDatetime, $excludeAppointmentId, $staffId = 0, $attendeeOrSql = '')
    {
        $range = crm_appointment_normalize_range($startDatetime, $endDatetime);
        if (!$range) {
            return null;
        }
        $startEsc = mysqli_real_escape_string($connection, $range['start']);
        $endEsc = mysqli_real_escape_string($connection, $range['end']);
        $exclude = (int) $excludeAppointmentId;
        $excludeSql = $exclude > 0 ? " AND appointment_id != $exclude " : '';
        $endExpr = crm_appointment_end_sql_expr($connection);
        $staffSql = '';
        $staffId = (int) $staffId;
        if ($staffId > 0) {
            $staffSql = " AND appointment_to_see = $staffId ";
        }
        $attendeeSql = trim((string) $attendeeOrSql) !== '' ? " AND ($attendeeOrSql) " : '';
        $sql = "SELECT appointment_id, student_name, business_name, appointment_datetime, appointment_end_datetime
            FROM appointments
            WHERE delete_status != 1
              AND appointment_status NOT IN ('cancelled', 'no-show')
              $excludeSql
              $staffSql
              $attendeeSql
              AND appointment_datetime < '$endEsc'
              AND $endExpr > '$startEsc'
            ORDER BY appointment_datetime ASC
            LIMIT 1";
        $res = @mysqli_query($connection, $sql);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            return $row;
        }
        return null;
    }
}

crm_app_timezone_init();
