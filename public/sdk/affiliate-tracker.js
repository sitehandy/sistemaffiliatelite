/**
 * Affiliate Tracking SDK for HTML/JavaScript Sites
 *
 * Usage:
 * <script src="https://your-domain.com/sdk/affiliate-tracker.js" data-api-key="YOUR_API_KEY"></script>
 *
 * Or initialize manually:
 * AffiliateTracker.init({ apiKey: 'YOUR_API_KEY' });
 */

(function(window, document) {
    'use strict';

    var AffiliateTracker = {
        config: {
            apiKey: null,
            apiUrl: null,
            cookieDuration: 30, // days
            cookieName: 'aff_ref',
            debug: false
        },

        init: function(options) {
            var scriptTag = document.querySelector('script[data-api-key]');

            if (scriptTag) {
                this.config.apiKey = scriptTag.getAttribute('data-api-key');
                this.config.apiUrl = scriptTag.src.replace('/sdk/affiliate-tracker.js', '/api');
            }

            if (options) {
                for (var key in options) {
                    if (options.hasOwnProperty(key)) {
                        this.config[key] = options[key];
                    }
                }
            }

            this.processReferral();
            this.log('AffiliateTracker initialized');
        },

        processReferral: function() {
            var ref = this.getUrlParam('ref');

            if (ref) {
                this.setCookie(this.config.cookieName, ref, this.config.cookieDuration);
                this.trackClick(ref);
                this.log('Referral processed: ' + ref);
            }
        },

        getUrlParam: function(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        },

        setCookie: function(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/; SameSite=Lax';
        },

        getCookie: function(name) {
            var nameEQ = name + '=';
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(c.substring(nameEQ.length, c.length));
                }
            }
            return null;
        },

        getTrackingCode: function() {
            return this.getCookie(this.config.cookieName);
        },

        trackClick: function(code) {
            // Click is automatically tracked by the tracking URL endpoint
            this.log('Click tracked for: ' + code);
        },

        trackConversion: function(data, callback) {
            var trackingCode = this.getTrackingCode();

            if (!trackingCode) {
                this.log('No tracking code found, skipping conversion');
                if (callback) callback({ success: false, message: 'No tracking code' });
                return;
            }

            var payload = {
                tracking_code: trackingCode,
                order_id: data.orderId || null,
                amount: data.amount || 0,
                type: data.type || 'sale',
                metadata: data.metadata || {}
            };

            this.sendRequest('POST', '/track/conversion', payload, function(response) {
                AffiliateTracker.log('Conversion tracked: ' + JSON.stringify(response));
                if (callback) callback(response);
            });
        },

        sendRequest: function(method, endpoint, data, callback) {
            var xhr = new XMLHttpRequest();
            var url = this.config.apiUrl + endpoint;

            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');

            if (this.config.apiKey) {
                xhr.setRequestHeader('X-API-Key', this.config.apiKey);
            }

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    var response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (e) {
                        response = { success: false, message: 'Invalid response' };
                    }

                    if (callback) {
                        response.success = xhr.status >= 200 && xhr.status < 300;
                        callback(response);
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        },

        log: function(message) {
            if (this.config.debug && console && console.log) {
                console.log('[AffiliateTracker] ' + message);
            }
        }
    };

    // Auto-initialize when script loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            AffiliateTracker.init();
        });
    } else {
        AffiliateTracker.init();
    }

    // Expose to global scope
    window.AffiliateTracker = AffiliateTracker;

})(window, document);
