<?php
/**
 * Flatpickr time picker (12-hour display, 24-hour HH:mm value) for Adelaide validation and backend.
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
     * @param string $id      Input id (and name target)
     * @param string $name    Form field name
     * @param string $value24 Initial value HH:mm or empty
     * @param array  $opts    required (bool)
     */
    function crm_render_appointment_time_picker($id, $name, $value24 = '', $opts = array())
    {
        $id = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $id);
        $name = htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8');
        $required = !empty($opts['required']);
        $value24Esc = htmlspecialchars(trim((string) $value24), ENT_QUOTES, 'UTF-8');
        $reqAttr = $required ? ' required' : '';

        ob_start();
        ?>
        <div class="crm-appt-time-fp-wrap">
            <input type="text"
                   class="form-control crm-appt-time-fp"
                   id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>"
                   name="<?php echo $name; ?>"
                   value="<?php echo $value24Esc; ?>"
                   placeholder="Select time"
                   autocomplete="off"
                   data-crm-time-picker="1"<?php echo $reqAttr; ?>>
            <small class="text-muted d-block mt-1 crm-tp-hint">Adelaide (ACST)</small>
        </div>
        <?php
        return ob_get_clean();
    }
}
