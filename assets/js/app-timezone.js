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
        if (typeof global.moment !== 'undefined') {
            return global.moment();
        }
        return null;
    }

    function crmAppTodayYmd() {
        var m = crmAppMoment();
        if (m) {
            return m.format('YYYY-MM-DD');
        }
        var d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    function crmAppNowTimeHm() {
        var m = crmAppMoment();
        if (m) {
            return m.format('HH:mm');
        }
        var d = new Date();
        return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
    }

    function crmAppFormatTimeDisplay() {
        var m = crmAppMoment();
        if (m) {
            return m.format('h:mm A');
        }
        return new Date().toLocaleTimeString();
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
    global.crmInitMomentDefaultTz = crmInitMomentDefaultTz;

    if (typeof global.jQuery !== 'undefined') {
        global.jQuery(function () {
            crmInitMomentDefaultTz();
        });
    } else {
        crmInitMomentDefaultTz();
    }
})(typeof window !== 'undefined' ? window : this);
