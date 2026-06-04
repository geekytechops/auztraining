/**
 * Client-side helpers: all dates/times use Australia/Adelaide (ACST), not the browser locale.
 */
(function (global) {
    var TZ = 'Australia/Adelaide';
    var CLOCK_TTL_MS = 45000;
    var _adelaideClockCache = { ts: 0, today: '', nowHm: '' };
    var _tpEmitTimers = {};
    var _applyMinsTimers = {};
    var _crmTpSilent = false;

    function crmAppDebounce(key, fn, waitMs) {
        clearTimeout(_applyMinsTimers[key]);
        _applyMinsTimers[key] = setTimeout(fn, waitMs);
    }

    function crmAppRefreshAdelaideClock() {
        var now = Date.now();
        if (now - _adelaideClockCache.ts < CLOCK_TTL_MS && _adelaideClockCache.today) {
            return _adelaideClockCache;
        }
        var p = crmIntlParts(new Date());
        if (p && p.year) {
            _adelaideClockCache.today = p.year + '-' + p.month + '-' + p.day;
            _adelaideClockCache.nowHm = p.hour + ':' + p.minute;
        } else {
            var m = crmAppMoment();
            if (m) {
                _adelaideClockCache.today = m.format('YYYY-MM-DD');
                _adelaideClockCache.nowHm = m.format('HH:mm');
            } else {
                var d = new Date();
                _adelaideClockCache.today = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                _adelaideClockCache.nowHm = String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
            }
        }
        _adelaideClockCache.ts = now;
        return _adelaideClockCache;
    }

    function hasMomentTz() {
        return typeof global.moment !== 'undefined' && typeof global.moment.tz === 'function';
    }

    function crmAppMoment() {
        if (hasMomentTz()) {
            return global.moment.tz(TZ);
        }
        return null;
    }

    function crmIntlParts(d) {
        var parts = { year: '', month: '', day: '', hour: '', minute: '' };
        try {
            new Intl.DateTimeFormat('en-GB', {
                timeZone: TZ,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).formatToParts(d || new Date()).forEach(function (p) {
                if (p.type in parts) {
                    parts[p.type] = p.value;
                }
            });
        } catch (e) {
            return null;
        }
        return parts;
    }

    function crmAppTodayYmd() {
        return crmAppRefreshAdelaideClock().today;
    }

    function crmAppNowTimeHm() {
        return crmAppRefreshAdelaideClock().nowHm;
    }

    function crmAppFormatTimeDisplay() {
        var m = crmAppMoment();
        if (m) {
            return m.format('h:mm A');
        }
        var p = crmIntlParts(new Date());
        if (p && p.hour !== '') {
            var h = parseInt(p.hour, 10);
            var mm = p.minute;
            var ap = h >= 12 ? 'PM' : 'AM';
            h = h % 12;
            if (h === 0) {
                h = 12;
            }
            return h + ':' + mm + ' ' + ap;
        }
        return new Date().toLocaleTimeString();
    }

    function crmAppParseSlot(dateYmd, timeHm) {
        dateYmd = (dateYmd || '').toString().trim();
        timeHm = (timeHm || '').toString().trim();
        if (!dateYmd || !timeHm) {
            return null;
        }
        var hm = timeHm.length >= 5 ? timeHm.substring(0, 5) : timeHm;
        if (hasMomentTz()) {
            var m = global.moment.tz(dateYmd + ' ' + hm, 'YYYY-MM-DD HH:mm', TZ);
            return m.isValid() ? m : null;
        }
        return { dateYmd: dateYmd, timeHm: hm };
    }

    function crmAppIsPastAppointment(dateYmd, timeHm) {
        var slot = crmAppParseSlot(dateYmd, timeHm);
        if (!slot) {
            return false;
        }
        if (slot.format) {
            return slot.isBefore(crmAppMoment());
        }
        var today = crmAppTodayYmd();
        if (slot.dateYmd < today) {
            return true;
        }
        if (slot.dateYmd > today) {
            return false;
        }
        return slot.timeHm < crmAppNowTimeHm();
    }

    function crmAppIsDateBeforeToday(dateYmd) {
        dateYmd = (dateYmd || '').toString().trim();
        return dateYmd !== '' && dateYmd < crmAppTodayYmd();
    }

    function crmTimeToMinutes(timeHm) {
        if (!timeHm) {
            return null;
        }
        var p = timeHm.toString().trim().substring(0, 5).split(':');
        return parseInt(p[0], 10) * 60 + parseInt(p[1], 10);
    }

    function crmAppTime24ToParts(timeHm) {
        timeHm = (timeHm || '').toString().trim().substring(0, 5);
        if (!timeHm || timeHm.indexOf(':') < 0) {
            return { hour: '', minute: '00', ampm: 'AM' };
        }
        var p = timeHm.split(':');
        var h24 = parseInt(p[0], 10);
        var min = (p[1] || '00').substring(0, 2);
        if (isNaN(h24)) {
            return { hour: '', minute: '00', ampm: 'AM' };
        }
        var ampm = h24 >= 12 ? 'PM' : 'AM';
        var h12 = h24 % 12;
        if (h12 === 0) {
            h12 = 12;
        }
        return { hour: String(h12), minute: min.length === 1 ? '0' + min : min, ampm: ampm };
    }

    function crmAppPartsTo24(hour12, minute, ampm) {
        hour12 = parseInt(hour12, 10);
        minute = (minute || '00').toString().trim();
        ampm = (ampm || 'AM').toString().trim().toUpperCase();
        if (isNaN(hour12) || hour12 < 1 || hour12 > 12) {
            return '';
        }
        if (minute.length === 1) {
            minute = '0' + minute;
        }
        var h24 = hour12 % 12;
        if (ampm === 'PM') {
            h24 += 12;
        }
        return String(h24).padStart(2, '0') + ':' + minute.substring(0, 2);
    }

    function crmAppFormatHm12(timeHm) {
        var parts = crmAppTime24ToParts(timeHm);
        if (!parts.hour) {
            return '';
        }
        return parts.hour + ':' + parts.minute + ' ' + parts.ampm;
    }

    /** Read HH:mm from hidden picker or legacy type="time" input. */
    function crmAppTimeGetVal(sel) {
        var $ = global.jQuery;
        if (!$) {
            return '';
        }
        var $el = $(sel);
        if (!$el.length) {
            return '';
        }
        return ($el.val() || '').toString().trim();
    }

    function crmAppTimeSetVal(sel, timeHm, silent) {
        var $ = global.jQuery;
        if (!$) {
            return;
        }
        var $el = $(sel);
        if (!$el.length) {
            return;
        }
        timeHm = (timeHm || '').toString().trim().substring(0, 5);
        if (($el.val() || '').toString().trim() === timeHm) {
            return;
        }
        _crmTpSilent = true;
        $el.val(timeHm);
        var $wrap = $el.closest('.crm-time-picker-12');
        if ($wrap.length) {
            crmAppTimePickerSyncFromHidden($wrap);
        }
        _crmTpSilent = false;
        if (!silent) {
            crmAppTimePickerScheduleHiddenChange($el);
        }
    }

    function crmAppTimePickerScheduleHiddenChange($hidden) {
        var $ = global.jQuery;
        if (!$ || !$hidden || !$hidden.length) {
            return;
        }
        var id = $hidden.attr('id') || 'tp-anon';
        clearTimeout(_tpEmitTimers[id]);
        _tpEmitTimers[id] = setTimeout(function () {
            if (!_crmTpSilent) {
                $hidden.trigger('change');
            }
        }, 120);
    }

    function crmAppTimeAddMinutes(timeHm, mins) {
        var m = crmTimeToMinutes(timeHm);
        if (m === null) {
            return '';
        }
        m = Math.max(0, Math.min(m + mins, 24 * 60 - 1));
        var h = Math.floor(m / 60);
        var mn = m % 60;
        return String(h).padStart(2, '0') + ':' + String(mn).padStart(2, '0');
    }

    function crmAppTimePickerWrapForHidden($hidden) {
        return $hidden.closest('.crm-time-picker-12');
    }

    function crmAppTimePickerSyncFromSelects($wrap) {
        var $ = global.jQuery;
        if (!$ || !$wrap || !$wrap.length) {
            return '';
        }
        var hour = $wrap.find('.crm-tp-hour').val();
        var minute = $wrap.find('.crm-tp-minute').val();
        var ampm = $wrap.find('.crm-tp-ampm').val();
        var hm = '';
        if (hour) {
            hm = crmAppPartsTo24(hour, minute, ampm);
        }
        var $hidden = $wrap.find('.crm-tp-hidden');
        $hidden.val(hm);
        crmAppTimePickerUpdateHint($wrap, hm);
        return hm;
    }

    function crmAppTimePickerSyncFromHidden($wrap) {
        var $hidden = $wrap.find('.crm-tp-hidden');
        var parts = crmAppTime24ToParts($hidden.val());
        $wrap.find('.crm-tp-hour').val(parts.hour || '');
        $wrap.find('.crm-tp-minute').val(parts.minute || '00');
        $wrap.find('.crm-tp-ampm').val(parts.ampm || 'AM');
        crmAppTimePickerUpdateHint($wrap, $hidden.val());
    }

    function crmAppTimePickerUpdateHint($wrap, hm) {
        hm = (hm || '').toString().trim();
        var label = hm ? crmAppFormatHm12(hm) + ' (Adelaide)' : 'Select time (Adelaide / ACST)';
        $wrap.find('.crm-tp-hint').text(label);
    }

    function crmAppTimePickerEnforceMin($wrap) {
        if (!$wrap || !$wrap.length) {
            return;
        }
        var minHm = ($wrap.attr('data-min-time') || '').toString().trim();
        if (!minHm) {
            return;
        }
        var $hidden = $wrap.find('.crm-tp-hidden');
        var cur = ($hidden.val() || '').toString().trim();
        var curM = crmTimeToMinutes(cur);
        var minM = crmTimeToMinutes(minHm);
        if (curM !== null && minM !== null && curM < minM) {
            crmAppTimeSetVal($hidden, minHm, true);
        }
    }

    function crmAppBumpToAfterFrom(fromSel, toSel, gapMinutes) {
        gapMinutes = gapMinutes || 1;
        var from = crmAppTimeGetVal(fromSel);
        if (!from) {
            return;
        }
        var to = crmAppTimeGetVal(toSel);
        var fromM = crmTimeToMinutes(from);
        var toM = crmTimeToMinutes(to);
        var newTo = crmAppTimeAddMinutes(from, gapMinutes);
        if (!to || (fromM !== null && toM !== null && toM <= fromM)) {
            crmAppTimeSetVal(toSel, newTo, true);
        }
    }

    function crmAppFixToAfterFrom(fromSel, toSel, gapMinutes) {
        gapMinutes = gapMinutes || 1;
        var from = crmAppTimeGetVal(fromSel);
        var to = crmAppTimeGetVal(toSel);
        if (!from || !to) {
            return;
        }
        var fromM = crmTimeToMinutes(from);
        var toM = crmTimeToMinutes(to);
        if (fromM !== null && toM !== null && toM <= fromM) {
            crmAppTimeSetVal(toSel, crmAppTimeAddMinutes(from, gapMinutes), true);
        }
    }

    function crmAppApplyAppointmentMinsDebounced(dateSel, fromSel, toSel, minDateOpt, waitMs) {
        var key = [dateSel, fromSel, toSel, minDateOpt].join('|');
        crmAppDebounce('mins-' + key, function () {
            crmAppApplyAppointmentMins(dateSel, fromSel, toSel, minDateOpt);
        }, waitMs || 200);
    }

    /**
     * Wire date/from/to once — debounced mins, silent to auto-bump, no duplicate handlers.
     */
    function crmAppWireAppointmentSlot(opts) {
        var $ = global.jQuery;
        if (!$ || !opts) {
            return;
        }
        var dateSel = opts.dateSel;
        var fromSel = opts.fromSel;
        var toSel = opts.toSel;
        var gap = opts.gapMinutes || 1;
        var minDateFn = opts.minDateOptFn;
        var clearFn = opts.onClearError;

        var afterFn = opts.onAfterChange;

        function runMins() {
            var minDate = minDateFn ? minDateFn() : (opts.minDateOpt || '');
            crmAppApplyAppointmentMinsDebounced(dateSel, fromSel, toSel, minDate, 200);
        }

        function finishChange() {
            if (afterFn) {
                crmAppDebounce('after-' + dateSel + fromSel, afterFn, 80);
            }
        }

        $(dateSel).off('change.crmApptSlot').on('change.crmApptSlot', function () {
            if (clearFn) {
                clearFn();
            }
            runMins();
            finishChange();
        });
        $(fromSel).off('change.crmApptSlot').on('change.crmApptSlot', function () {
            crmAppBumpToAfterFrom(fromSel, toSel, gap);
            if (clearFn) {
                clearFn();
            }
            runMins();
            finishChange();
        });
        if (toSel) {
            $(toSel).off('change.crmApptSlot').on('change.crmApptSlot', function () {
                crmAppFixToAfterFrom(fromSel, toSel, gap);
                if (clearFn) {
                    clearFn();
                }
                runMins();
                finishChange();
            });
        }
        runMins();
    }

    function crmAppInitTimePickers12(root) {
        var $ = global.jQuery;
        if (!$) {
            return;
        }
        var $root = root ? $(root) : $(document);
        $root.find('.crm-time-picker-12').each(function () {
            var $wrap = $(this);
            if ($wrap.data('crmTpInited')) {
                return;
            }
            $wrap.data('crmTpInited', true);
            crmAppTimePickerSyncFromHidden($wrap);
            crmAppTimePickerEnforceMin($wrap);
        });
    }

    function crmAppWireTimePicker12() {
        var $ = global.jQuery;
        if (!$) {
            return;
        }
        $(document).on('change', '.crm-time-picker-12 select', function () {
            var $wrap = $(this).closest('.crm-time-picker-12');
            crmAppTimePickerSyncFromSelects($wrap);
            crmAppTimePickerEnforceMin($wrap);
            crmAppTimePickerScheduleHiddenChange($wrap.find('.crm-tp-hidden'));
        });
        $(function () {
            crmAppInitTimePickers12();
        });
    }

    /**
     * Validate appointment date/from/to in Adelaide time.
     * @returns {{ ok: boolean, message: string }}
     */
    function crmAppValidateAppointmentSlot(dateYmd, fromHm, toHm) {
        dateYmd = (dateYmd || '').toString().trim();
        fromHm = (fromHm || '').toString().trim();
        toHm = (toHm || '').toString().trim();

        if (!dateYmd || !fromHm) {
            return { ok: false, message: 'Please select appointment date and start time.' };
        }
        if (crmAppIsDateBeforeToday(dateYmd)) {
            return { ok: false, message: 'Appointment date cannot be in the past (Adelaide time).' };
        }
        if (crmAppIsPastAppointment(dateYmd, fromHm)) {
            var picked = crmAppFormatHm12(fromHm);
            var nowLbl = crmAppFormatTimeDisplay();
            var detail = picked ? (' You selected ' + picked + '.') : '';
            var nowPart = nowLbl ? (' It is now ' + nowLbl + ' in Adelaide.') : '';
            return { ok: false, message: 'Appointment start time cannot be in the past (Adelaide time).' + detail + nowPart };
        }
        if (toHm) {
            var fromM = crmTimeToMinutes(fromHm);
            var toM = crmTimeToMinutes(toHm);
            if (fromM !== null && toM !== null && toM <= fromM) {
                return { ok: false, message: 'End time must be at least 1 minute after start time.' };
            }
        }
        return { ok: true, message: '' };
    }

    function crmAppApplyAppointmentMins(dateSel, fromSel, toSel, minDateOpt) {
        var $date = global.jQuery ? global.jQuery(dateSel) : null;
        if (!$date || !$date.length) {
            return;
        }
        var todayStr = crmAppTodayYmd();
        var nowTimeStr = crmAppNowTimeHm();
        minDateOpt = (minDateOpt || '').toString().trim();
        var dateMin = todayStr;
        if (minDateOpt && minDateOpt > dateMin) {
            dateMin = minDateOpt;
        }
        $date.attr('min', dateMin);
        var selectedDate = ($date.val() || '').toString().trim();
        var $from = global.jQuery(fromSel);
        var $to = toSel ? global.jQuery(toSel) : null;
        if (selectedDate === todayStr) {
            if ($from.length) {
                var $fromWrap = $from.closest('.crm-time-picker-12');
                if ($fromWrap.length) {
                    $fromWrap.attr('data-min-time', nowTimeStr);
                    crmAppTimePickerEnforceMin($fromWrap);
                } else {
                    $from.attr('min', nowTimeStr);
                }
            }
            if ($to && $to.length) {
                var $toWrap = $to.closest('.crm-time-picker-12');
                if ($toWrap.length) {
                    $toWrap.attr('data-min-time', nowTimeStr);
                    crmAppTimePickerEnforceMin($toWrap);
                } else {
                    $to.attr('min', nowTimeStr);
                }
            }
        } else {
            if ($from.length) {
                var $fw = $from.closest('.crm-time-picker-12');
                if ($fw.length) {
                    $fw.removeAttr('data-min-time');
                } else {
                    $from.removeAttr('min');
                }
            }
            if ($to && $to.length) {
                var $tw = $to.closest('.crm-time-picker-12');
                if ($tw.length) {
                    $tw.removeAttr('data-min-time');
                } else {
                    $to.removeAttr('min');
                }
            }
        }
        var fromHm = crmAppTimeGetVal(fromSel);
        if (fromHm && $to && $to.length) {
            var minTo = crmAppTimeAddMinutes(fromHm, 1);
            var $toW = $to.closest('.crm-time-picker-12');
            if ($toW.length) {
                $toW.attr('data-min-time', minTo);
                crmAppTimePickerEnforceMin($toW);
            } else if (minTo) {
                $to.attr('min', minTo);
            }
        }
    }

    var API_SLOT_MESSAGES = {
        past_datetime: 'This appointment is in the past. Please choose a future date and time (Adelaide / ACST).',
        invalid_time_range: 'End time must be at least 1 minute after the start time.',
        missing_datetime: 'Please select appointment date and start time.',
        '2': 'This person already has an appointment overlapping the selected time (Adelaide / ACST). Please choose a different time.',
        '3': 'This time slot is blocked for the selected staff member. Please choose a different time or staff.',
        '4': 'This staff member already has another appointment overlapping the selected time (Adelaide / ACST). Please choose a different time or staff member.'
    };

    function crmAppSlotMessageForCode(code, fallback) {
        return API_SLOT_MESSAGES[code] || fallback || API_SLOT_MESSAGES.past_datetime;
    }

    /**
     * Highlight fields + inline error + optional alert banner + error toast.
     * opts: { dateSel, fromSel, toSel, errorSel, alertSel, message, toastMessage, scrollTo }
     */
    function crmAppShowAppointmentSlotError(opts) {
        opts = opts || {};
        var message = opts.message || API_SLOT_MESSAGES.past_datetime;
        var $ = global.jQuery;
        if (!$) {
            return;
        }
        var fields = [opts.dateSel, opts.fromSel, opts.toSel].filter(Boolean);
        fields.forEach(function (sel) {
            var $el = $(sel);
            if ($el.length) {
                $el.addClass('is-invalid');
                var $wrap = $el.closest('.crm-time-picker-12');
                if ($wrap.length) {
                    $wrap.addClass('is-invalid');
                    $wrap.find('select').addClass('is-invalid');
                }
                $el.closest('.mb-3').addClass('crm-slot-invalid-wrap');
            }
        });
        if (opts.errorSel) {
            $(opts.errorSel).text(message).addClass('d-block text-danger').css({ display: 'block', visibility: 'visible' });
        }
        if (opts.alertSel) {
            $(opts.alertSel).removeClass('d-none').addClass('show').text(message);
        }
        if (opts.scrollTo !== false) {
            var $target = opts.alertSel ? $(opts.alertSel) : (opts.errorSel ? $(opts.errorSel) : $(opts.dateSel));
            if ($target.length && $target[0].scrollIntoView) {
                $target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        var toastMsg = opts.toastMessage || message;
        var $toastBody = $('.toast-text2');
        if ($toastBody.length) {
            $toastBody.html(toastMsg);
        }
        var $toastBtn = $('#borderedToast2Btn');
        if ($toastBtn.length) {
            $toastBtn.trigger('click');
        } else if (global.Swal && typeof global.Swal.fire === 'function') {
            global.Swal.fire({ icon: 'error', title: 'Invalid appointment time', text: toastMsg });
        }
    }

    function crmAppClearAppointmentSlotError(opts) {
        opts = opts || {};
        var $ = global.jQuery;
        if (!$) {
            return;
        }
        [opts.dateSel, opts.fromSel, opts.toSel].filter(Boolean).forEach(function (sel) {
            var $el = $(sel);
            if ($el.length) {
                $el.removeClass('is-invalid');
                var $wrap = $el.closest('.crm-time-picker-12');
                if ($wrap.length) {
                    $wrap.removeClass('is-invalid');
                    $wrap.find('select').removeClass('is-invalid');
                }
                $el.closest('.mb-3').removeClass('crm-slot-invalid-wrap');
            }
        });
        if (opts.errorSel) {
            $(opts.errorSel).hide().removeClass('d-block');
        }
        if (opts.alertSel) {
            $(opts.alertSel).addClass('d-none').removeClass('show').text('');
        }
    }

    function crmAppHandleAppointmentApiError(code, opts) {
        crmAppShowAppointmentSlotError({
            message: crmAppSlotMessageForCode(code),
            toastMessage: crmAppSlotMessageForCode(code),
            dateSel: opts && opts.dateSel,
            fromSel: opts && opts.fromSel,
            toSel: opts && opts.toSel,
            errorSel: opts && opts.errorSel,
            alertSel: opts && opts.alertSel
        });
    }

    function crmInitMomentDefaultTz() {
        if (hasMomentTz()) {
            global.moment.tz.setDefault(TZ);
        }
    }

    global.CRM_APP_TIMEZONE = TZ;
    global.CRM_APP_TIMEZONE_LABEL = 'ACST (Adelaide)';
    global.crmAppTodayYmd = crmAppTodayYmd;
    global.crmAppNowTimeHm = crmAppNowTimeHm;
    global.crmAppFormatTimeDisplay = crmAppFormatTimeDisplay;
    global.crmAppFormatHm12 = crmAppFormatHm12;
    global.crmAppTimeGetVal = crmAppTimeGetVal;
    global.crmAppTimeSetVal = crmAppTimeSetVal;
    global.crmAppTimeAddMinutes = crmAppTimeAddMinutes;
    global.crmAppInitTimePickers12 = crmAppInitTimePickers12;
    global.crmAppWireAppointmentSlot = crmAppWireAppointmentSlot;
    global.crmAppApplyAppointmentMinsDebounced = crmAppApplyAppointmentMinsDebounced;
    global.crmAppValidateAppointmentSlot = crmAppValidateAppointmentSlot;
    global.crmAppApplyAppointmentMins = crmAppApplyAppointmentMins;
    global.crmAppIsPastAppointment = crmAppIsPastAppointment;
    global.crmAppShowAppointmentSlotError = crmAppShowAppointmentSlotError;
    global.crmAppClearAppointmentSlotError = crmAppClearAppointmentSlotError;
    global.crmAppHandleAppointmentApiError = crmAppHandleAppointmentApiError;
    global.crmAppSlotMessageForCode = crmAppSlotMessageForCode;
    global.crmInitMomentDefaultTz = crmInitMomentDefaultTz;

    global.CRM_APPOINTMENT_BOOKING_UI = {
        dateSel: '#appointment_date',
        fromSel: '#appointment_time',
        toSel: '#appointment_time_to',
        errorSel: '#appointment_past_time_error',
        alertSel: '#appointment_slot_alert'
    };
    global.CRM_APPOINTMENT_FP_UI = {
        dateSel: '#fp_appointment_date',
        fromSel: '#fp_appointment_time',
        toSel: '#fp_appointment_time_to',
        errorSel: '#fp_appointment_past_time_error',
        alertSel: '#fp_appointment_slot_alert'
    };

    crmAppWireTimePicker12();

    if (typeof global.jQuery !== 'undefined') {
        global.jQuery(function () {
            crmInitMomentDefaultTz();
            crmAppInitTimePickers12();
        });
    } else {
        crmInitMomentDefaultTz();
    }
})(typeof window !== 'undefined' ? window : this);
