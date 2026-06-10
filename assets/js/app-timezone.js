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

    function crmAppGetFlatpickrInstance(el) {
        if (!el) {
            return null;
        }
        if (el._flatpickr) {
            return el._flatpickr;
        }
        if (global.flatpickr && typeof global.flatpickr.getInstance === 'function') {
            return global.flatpickr.getInstance(el);
        }
        return null;
    }

    function crmAppFlatpickrWrapForInput($input) {
        return $input.closest('.crm-appt-time-fp-wrap');
    }

    /** Read HH:mm from Flatpickr input or legacy type="time" input. */
    function crmAppTimeGetVal(sel) {
        var $ = global.jQuery;
        if (!$) {
            return '';
        }
        var $el = $(sel);
        if (!$el.length) {
            return '';
        }
        var fp = crmAppGetFlatpickrInstance($el[0]);
        if (fp && fp.selectedDates && fp.selectedDates.length) {
            var d = fp.selectedDates[0];
            return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
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
        var cur = crmAppTimeGetVal(sel);
        if (cur === timeHm) {
            return;
        }
        _crmTpSilent = true;
        var fp = crmAppGetFlatpickrInstance($el[0]);
        if (fp) {
            if (timeHm) {
                fp.setDate(timeHm, false, 'H:i');
            } else {
                fp.clear();
            }
        } else {
            $el.val(timeHm);
        }
        crmAppTimePickerUpdateHint(crmAppFlatpickrWrapForInput($el), timeHm);
        _crmTpSilent = false;
        if (!silent) {
            crmAppTimePickerScheduleHiddenChange($el);
        }
    }

    function crmAppTimePickerScheduleHiddenChange($input) {
        var $ = global.jQuery;
        if (!$ || !$input || !$input.length) {
            return;
        }
        var id = $input.attr('id') || 'tp-anon';
        clearTimeout(_tpEmitTimers[id]);
        _tpEmitTimers[id] = setTimeout(function () {
            if (!_crmTpSilent) {
                $input.trigger('change');
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

    function crmAppTimePickerUpdateHint($wrap, hm) {
        if (!$wrap || !$wrap.length) {
            return;
        }
        hm = (hm || '').toString().trim();
        var label = hm ? crmAppFormatHm12(hm) + ' (Adelaide)' : 'Adelaide (ACST)';
        $wrap.find('.crm-tp-hint').text(label);
    }

    function crmAppFlatpickrApplyMinTime($input, minHm) {
        var fp = crmAppGetFlatpickrInstance($input[0]);
        if (!fp) {
            return;
        }
        minHm = (minHm || '').toString().trim();
        if (minHm) {
            fp.set('minTime', minHm);
            var cur = crmAppTimeGetVal($input);
            var curM = crmTimeToMinutes(cur);
            var minM = crmTimeToMinutes(minHm);
            if (curM !== null && minM !== null && curM < minM) {
                crmAppTimeSetVal($input, minHm, true);
            }
        } else {
            fp.set('minTime', null);
        }
    }

    function crmAppFlatpickrBaseConfig($input) {
        var inModal = $input.closest('.modal').length > 0;
        return {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            altInput: true,
            altFormat: 'h:i K',
            time_24hr: false,
            minuteIncrement: 1,
            allowInput: false,
            static: inModal,
            onChange: function (selectedDates, dateStr, instance) {
                crmAppTimePickerUpdateHint(crmAppFlatpickrWrapForInput(global.jQuery(instance.input)), dateStr);
                if (!_crmTpSilent) {
                    crmAppTimePickerScheduleHiddenChange(global.jQuery(instance.input));
                }
            },
            onReady: function (selectedDates, dateStr, instance) {
                crmAppTimePickerUpdateHint(crmAppFlatpickrWrapForInput(global.jQuery(instance.input)), dateStr);
                var minHm = (global.jQuery(instance.input).attr('data-min-time') || '').toString().trim();
                if (minHm) {
                    instance.set('minTime', minHm);
                }
            }
        };
    }

    function crmAppDestroyFlatpickrTimePickers(root) {
        var $ = global.jQuery;
        if (!$ || typeof global.flatpickr === 'undefined') {
            return;
        }
        var $root = root ? $(root) : $(document);
        $root.find('.crm-appt-time-fp[data-crm-time-picker="1"]').each(function () {
            var fp = crmAppGetFlatpickrInstance(this);
            if (fp) {
                fp.destroy();
            }
            $(this).removeData('crmFpInited');
        });
    }

    function crmAppInitFlatpickrTimePickers(root) {
        var $ = global.jQuery;
        if (!$ || typeof global.flatpickr === 'undefined') {
            return;
        }
        var $root = root ? $(root) : $(document);
        $root.find('.crm-appt-time-fp[data-crm-time-picker="1"]').each(function () {
            var $input = $(this);
            if ($input.data('crmFpInited')) {
                return;
            }
            var existing = crmAppGetFlatpickrInstance(this);
            if (existing) {
                existing.destroy();
            }
            global.flatpickr(this, crmAppFlatpickrBaseConfig($input));
            $input.data('crmFpInited', true);
            crmAppTimePickerUpdateHint(crmAppFlatpickrWrapForInput($input), crmAppTimeGetVal($input));
            var minHm = ($input.attr('data-min-time') || '').toString().trim();
            if (minHm) {
                crmAppFlatpickrApplyMinTime($input, minHm);
            }
        });
    }

    /** Backward-compatible alias */
    function crmAppInitTimePickers12(root) {
        crmAppInitFlatpickrTimePickers(root);
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

    /**
     * Validate appointment date/from/to in Adelaide time.
     * @returns {{ ok: boolean, message: string }}
     */
    function crmAppValidateAppointmentSlot(dateYmd, fromHm, toHm) {
        dateYmd = (dateYmd || '').toString().trim();
        fromHm = (fromHm || '').toString().trim();
        toHm = (toHm || '').toString().trim();

        if (!dateYmd || !fromHm) {
            return { ok: false, message: API_SLOT_MESSAGES.missing_datetime };
        }
        if (crmAppIsDateBeforeToday(dateYmd)) {
            return { ok: false, message: 'Appointment date cannot be in the past. All times are Adelaide (ACST).' };
        }
        if (crmAppIsPastAppointment(dateYmd, fromHm)) {
            var nowLbl = crmAppFormatTimeDisplay();
            var nowPart = nowLbl ? (' It is now ' + nowLbl + ' in Adelaide.') : '';
            return { ok: false, message: 'Appointment start time cannot be in the past.' + nowPart };
        }
        if (toHm) {
            var fromM = crmTimeToMinutes(fromHm);
            var toM = crmTimeToMinutes(toHm);
            if (fromM !== null && toM !== null && toM <= fromM) {
                return { ok: false, message: API_SLOT_MESSAGES.invalid_time_range };
            }
        }
        return { ok: true, message: '' };
    }

    function crmAppApplyAppointmentMins(dateSel, fromSel, toSel, minDateOpt) {
        var $ = global.jQuery;
        var $date = $ ? $(dateSel) : null;
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
        var $from = $(fromSel);
        var $to = toSel ? $(toSel) : null;
        if (selectedDate === todayStr) {
            if ($from.length) {
                $from.attr('data-min-time', nowTimeStr);
                crmAppFlatpickrApplyMinTime($from, nowTimeStr);
            }
            if ($to && $to.length) {
                $to.attr('data-min-time', nowTimeStr);
                crmAppFlatpickrApplyMinTime($to, nowTimeStr);
            }
        } else {
            if ($from.length) {
                $from.removeAttr('data-min-time');
                crmAppFlatpickrApplyMinTime($from, '');
            }
            if ($to && $to.length) {
                $to.removeAttr('data-min-time');
                crmAppFlatpickrApplyMinTime($to, '');
            }
        }
        var fromHm = crmAppTimeGetVal(fromSel);
        if (fromHm && $to && $to.length) {
            var minTo = crmAppTimeAddMinutes(fromHm, 1);
            var toMin = ($to.attr('data-min-time') || '').toString().trim();
            if (!toMin || crmTimeToMinutes(minTo) > crmTimeToMinutes(toMin)) {
                $to.attr('data-min-time', minTo);
            }
            crmAppFlatpickrApplyMinTime($to, ($to.attr('data-min-time') || minTo));
        }
    }

    var API_SLOT_MESSAGES = {
        past_datetime: 'Appointments can only be booked for future dates and times (Adelaide / ACST).',
        invalid_time_range: 'End time must be after start time. Please adjust From and To.',
        missing_datetime: 'Please select appointment date, start time, and end time.',
        '2': 'This student already has an appointment at this date and time (with any staff). Please choose a different slot.',
        '3': 'This time slot is blocked and cannot be booked. Please choose a different time or staff member.',
        '4': 'This staff member already has another appointment at this time. Please choose a different time or staff.'
    };

    function crmAppSlotMessageForCode(code, fallback) {
        return API_SLOT_MESSAGES[code] || fallback || API_SLOT_MESSAGES.past_datetime;
    }

    function crmAppMarkTimeFieldInvalid($el) {
        $el.addClass('is-invalid');
        var fp = crmAppGetFlatpickrInstance($el[0]);
        if (fp && fp.altInput) {
            global.jQuery(fp.altInput).addClass('is-invalid');
        }
        $el.closest('.crm-appt-time-fp-wrap').addClass('is-invalid');
        $el.closest('.mb-3').addClass('crm-slot-invalid-wrap');
    }

    function crmAppClearTimeFieldInvalid($el) {
        $el.removeClass('is-invalid');
        var fp = crmAppGetFlatpickrInstance($el[0]);
        if (fp && fp.altInput) {
            global.jQuery(fp.altInput).removeClass('is-invalid');
        }
        $el.closest('.crm-appt-time-fp-wrap').removeClass('is-invalid');
        $el.closest('.mb-3').removeClass('crm-slot-invalid-wrap');
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
                crmAppMarkTimeFieldInvalid($el);
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
                crmAppClearTimeFieldInvalid($el);
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
    global.crmAppInitFlatpickrTimePickers = crmAppInitFlatpickrTimePickers;
    global.crmAppDestroyFlatpickrTimePickers = crmAppDestroyFlatpickrTimePickers;
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

    if (typeof global.jQuery !== 'undefined') {
        global.jQuery(function () {
            crmInitMomentDefaultTz();
            crmAppInitFlatpickrTimePickers();
        });
    } else {
        crmInitMomentDefaultTz();
    }
})(typeof window !== 'undefined' ? window : this);
