/**
 * Client-side helpers: all dates/times use Australia/Adelaide (ACST), not the browser locale.
 */
(function (global) {
    var TZ = 'Australia/Adelaide';

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
        var m = crmAppMoment();
        if (m) {
            return m.format('YYYY-MM-DD');
        }
        var p = crmIntlParts(new Date());
        if (p && p.year) {
            return p.year + '-' + p.month + '-' + p.day;
        }
        var d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    function crmAppNowTimeHm() {
        var m = crmAppMoment();
        if (m) {
            return m.format('HH:mm');
        }
        var p = crmIntlParts(new Date());
        if (p && p.hour !== '') {
            return p.hour + ':' + p.minute;
        }
        var d = new Date();
        return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
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
            return { ok: false, message: 'Appointment start time cannot be in the past (Adelaide time).' };
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
                $from.attr('min', nowTimeStr);
            }
            if ($to && $to.length) {
                $to.attr('min', nowTimeStr);
            }
        } else {
            if ($from.length) {
                $from.removeAttr('min');
            }
            if ($to && $to.length) {
                $to.removeAttr('min');
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
        });
    } else {
        crmInitMomentDefaultTz();
    }
})(typeof window !== 'undefined' ? window : this);
