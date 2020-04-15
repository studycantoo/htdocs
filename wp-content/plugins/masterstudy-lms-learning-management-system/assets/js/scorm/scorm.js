(function ($) {

    var SCORM = pipwerks.SCORM;

    window.API = {
        LastError: 0,
        Initialized: false,
        Initialize: function () {
            this.ModuleRunning = true;
            this.Initialized = true;
            return true;
        },
        Terminate: function () {
            this.ModuleRunning = false;
            this.Initialized = false;
            SCORM.connection.isActive = false;
            return 'true';
        },
        GetValue: function (key, value) {
            console.log(key, value, 'dedede');
            this.LastError = 0;
            if (!this.Initialized) {
                this.LastError = scormErrors.GetValueBeforeInit;
                return '';
            }
            return '';
        },
        SetValue: function (key, value) {
            console.log(key, value, 'kekekekekekeke');
            this.LastError = 0;
            if (!this.Initialized) {
                this.LastError = scormErrors.SetValueBeforeInit;
                return '';
            }
            return 'true';
        },
        Commit: function () {
            this.LastError = 0;
            return 'true';
        },
        GetLastError: function () {
            var error = this.LastError;
            this.LastError = 0;
            return error;
        },
        GetErrorString: function (error) {
            return 'Error: ' + error;
        },
        GetDiagnostic: function () {
            var message = 'Diagnostic: ' + this.LastError;
            this.LastError = 0;
            return message;
        },
        LMSInitialize: function () {
            //console.log('LMS Set initialize');
            return this.Initialize();
        },
        LMSFinish: function () {
            //console.log('LMS Set finish');
            return this.Terminate();
        },
        LMSGetValue: function (key) {
            //console.log('LMS Get initialize');
            return this.GetValue(key);
        },
        LMSSetValue: function (key, value) {
            //console.log('LMS Set value', key, value);
            return this.SetValue(key, value);
        },
        LMSCommit: function () {
            //console.log('LMS Set commit');
            return this.Commit();
        },
        LMSGetLastError: function () {
            return this.GetLastError();
        },
        LMSGetErrorString: function () {
            return this.GetErrorString();
        },
        LMSGetDiagnostic: function () {
            return this.GetDiagnostic();
        },
    };


    // hardcoded - should be the same as uploaded scorm course
    SCORM.version = "1.2";

    var success = SCORM.init();

    // Example usage
    if (success) {
        var status = SCORM.get("cmi.core.lesson_location");
        console.log(status);
        if (status != "completed") {
            success = SCORM.set("cmi.core.lesson_status", "completed");
            if (success) {
                SCORM.quit();
            }
        }
    }


})(jQuery);