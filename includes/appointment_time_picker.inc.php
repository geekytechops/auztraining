<?php
/**
 * 12-hour time picker (hour, minute, AM/PM) with hidden HH:mm for Adelaide validation and backend.
 */
if (!function_exists('crm_time_24_to_12_parts')) {
    function crm_time_24_to_12_parts($time24)
    {
        $time24 = trim((string) $time24);
        if ($time24 === '') {
            return array('hour' => '', 'minute' => '00', 'ampm' => 'AM');
        }
        if (preg_match('/^(\d{1,2}):(\d{2})/', $time24, $m)) {
            $h24 = (int) $m[1];
            $min = $m[2];
            $ampm = $h24 >= 12 ? 'PM' : 'AM';
            $h12 = $h24 % 12;
            if ($h12 === 0) {
                $h12 = 12;
            }
            return array('hour' => (string) $h12, 'minute' => $min, 'ampm' => $ampm);
        }
        return array('hour' => '', 'minute' => '00', 'ampm' => 'AM');
    }

    /**
     * @param string $id      Hidden input id (and name target)
     * @param string $name    Form field name
     * @param string $value24 Initial value HH:mm or empty
     * @param array  $opts    required (bool)
     */
    function crm_render_appointment_time_picker($id, $name, $value24 = '', $opts = array())
    {
        $id = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $id);
        $name = htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8');
        $required = !empty($opts['required']);
        $parts = crm_time_24_to_12_parts($value24);
        $value24Esc = htmlspecialchars(trim((string) $value24), ENT_QUOTES, 'UTF-8');
        $reqAttr = $required ? ' required' : '';

        ob_start();
        ?>
        <div class="crm-time-picker-12" data-hidden-id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" class="crm-tp-hidden" id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>"
                   name="<?php echo $name; ?>" value="<?php echo $value24Esc; ?>"<?php echo $reqAttr; ?>>
            <div class="crm-tp-controls d-flex flex-wrap align-items-center gap-1">
                <select class="form-select form-select-sm crm-tp-hour" aria-label="Hour" title="Hour">
                    <option value="">Hour</option>
                    <?php for ($h = 1; $h <= 12; $h++) :
                        $hv = (string) $h;
                        $sel = ($parts['hour'] === $hv) ? ' selected' : '';
                        ?>
                        <option value="<?php echo $h; ?>"<?php echo $sel; ?>><?php echo $h; ?></option>
                    <?php endfor; ?>
                </select>
                <span class="crm-tp-sep text-muted">:</span>
                <select class="form-select form-select-sm crm-tp-minute" aria-label="Minute" title="Minute">
                    <?php for ($m = 0; $m < 60; $m++) :
                        $mv = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
                        $sel = ($parts['minute'] === $mv) ? ' selected' : '';
                        ?>
                        <option value="<?php echo $mv; ?>"<?php echo $sel; ?>><?php echo $mv; ?></option>
                    <?php endfor; ?>
                </select>
                <select class="form-select form-select-sm crm-tp-ampm" aria-label="AM or PM" title="AM or PM">
                    <option value="AM"<?php echo $parts['ampm'] === 'AM' ? ' selected' : ''; ?>>AM</option>
                    <option value="PM"<?php echo $parts['ampm'] === 'PM' ? ' selected' : ''; ?>>PM</option>
                </select>
            </div>
            <small class="text-muted d-block mt-1 crm-tp-hint">Adelaide (ACST)</small>
        </div>
        <?php
        return ob_get_clean();
    }
}
